<?php
use App\Http\Logic\UserLogic;
defined('BASEPATH') OR exit('No direct script access allowed');
class Lilogin extends CI_Controller {
	function __construct(){
			@session_start();
			parent::__construct();
			$this->load->helper('url'); //url加载辅助函数
			$this->load->helper('array');
			$this->load->database(); //数据库类
	}
	public function login(){
		$data['mobile'] = $this->db->query("select * from `zj_aboutus` where id=1 ")->result_array();
		$this->load->view("home/login/login.html",$data);

	}

	public function getcode(){
		$mobile = $this->input->post("mobile",true);
        $is_register = $this->input->post("is_register",true);
		if(empty($mobile)){
			$data['status'] = 0;
			$data['message'] = "请填写手机号";
			exit(json_encode($data));
		}else{
            if($is_register == 1){
                $userLogic = new UserLogic();
                if($userLogic->checkUserMobileExist($mobile)){
                    $data['status'] = 0;
                    $data['message'] = "该手机号已注册";
                    exit(json_encode($data));
                }
            }
			$code = rand('1000','9999');
			$content = '来自建遇良才的信息，你的验证码：'.$code;
			$res = $this->ChuanglanSmsHelper($mobile,$content);
			if($res===true) {
				// 查询数据
				$list=$this->db->query("select * from zj_code where mobile='$mobile' limit 1")->row_array();

				$data['addtime'] = time();
				$data['code'] = $code;
				if(empty($list)){
					$data['mobile'] = $mobile;
					$this->db->insert('zj_code', $data);
				}else{
					$this->db->update("zj_code",$data,"mobile='".$mobile."'");
				}
				$data = array();
				$data['status'] = 1;
				$data['message'] = "短信验证码发送成功";
				exit(json_encode($data));
			}else{
				$data = array();
				$data['status'] = 0;
				$data['message'] = "短信验证码发送失败";
				exit(json_encode($data));
			}

		}

	}

	public function ChuanglanSmsHelper($mobile,$content){
		$this->load->library("chuanglansmsapi");
		$clapi  = new ChuanglanSmsApi();
		$result = $clapi->sendSMS($mobile,$content,'true');
		$result = $clapi->execResult($result);
		if($result[1] != 0){
			return false;
		}
		return true;
	}

	public function sub(){
		$username = $this->input->post('uname',true);
		$password = md5($this->input->post('password',true));

		//第三方登录
		$qq = $_SESSION['openid'];
		$weibo = $this->input->post('weibo',true);
		$weixin = $this->input->post('weixin',true);
		if($qq || $weibo || $weixin){
			$where = '';
			if($qq){
				$where = "where qq='$qq'";
				$m = 'qq';
				$third = $qq;
				$username = $_SESSION['nickname'];
			}else if($weibo){
				$where = "where weibo = '$weibo'";
				$m = 'weibo';
				$third = $weibo;
			}else if($weixin) {
				$where = "where weibo = '$weibo'";
				$m = 'weixin';
				$third = $weixin;
			}

			$list = $this->db->query("select * from zj_user ".$where." limit 1")->row_array();

			if(empty($list)){
				$log = $fdata = array();
				//注册写入数据库
				$fdata['mobile'] = $mobile;
				$fdata['pass'] = md5($pass1);
				$fdata['nickname'] = $username;
				$fdata['cidtoken'] = $cidtoken;
				$fdata[$m] = $third;
				$fdata['addtime'] = time();
				$this->db->insert("zj_user",$fdata);
				$id = $this->db->insert_id();
				if($id>0){

					$this->load->model("LInvitecode_model",'LInvitecode');
					// $hxname=$this->LInvitecode->huanxinRegister('Janzhu_'.$id);

					// if(!empty($hxname)){
					// 	$Hxdata['hxname'] = $hxname;
					// 	$this->db->update("zj_user","id='".$id."'");
					// 	$this->LInvitecode->invitecode2($id);
					// }else{
					// 	$this->db->delete("zj_user","id='".$id."'");
					// 	$data = array();
					// 	$data['status'] = 0;
					// 	$data['message'] = "环信注册失败";
					// 	exit(json_encode($data));
					// }
					$log = array();
					$log['userid'] = $id;
					$log['content'] = '新用户注册';
					$log['zhuangtai'] = 1;
					$log['status'] = 2;
					$this->LInvitecode->integrallog($log,'1');
					$_SESSION['uid']=$id;
					$_SESSION["nickname"] = $username;
					if($qq) header("location:".site_url("personalcenter/index"));
					else ajaxmsg(1,"登陆成功");
				}else{
					ajaxmsg(0,"登陆失败");
				}
			}else{
				if($list['status'] == 0){
					ajaxmsg(0,"账号已被冻结");
				}
				$_SESSION['uid'] = $list['id'];
				$_SESSION["nickname"] = $list['nickname'];
				if($qq) header("location:".site_url("personalcenter/index"));
				else ajaxmsg(1,"登陆成功");
			}

		}
		if(is_numeric($username)){
			$sql = "SELECT id,name,nickname,mobile FROM zj_user where mobile = '$username' and pass = '$password'";
		}else{
			$sql = "SELECT id,name,nickname,mobile FROM zj_user where nickname = '$username' and pass = '$password'";
		}

		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			$array=$query->row_array();
			$_SESSION['uid']=$array['id'];
			$_SESSION["nickname"] = $array['nickname'];
			$_SESSION['mobile']=$array['mobile'];
			header("location:".site_url("Index/index"));
		}else{
			exit("<script>alert('账号或密码错误');window.history.go(-1)</script>");
		}

	}

	public function logout(){
			unset($_SESSION["uid"]);
			unset($_SESSION["nickname"]);
			unset($_SESSION["mobile"]);
			header("location:".site_url("Lilogin/login"));
		}
	public function register(){
		$data['mobile'] = $this->db->query("select * from `zj_aboutus` where id=1 ")->result_array();
		$this->load->view("home/login/zhuce.html",$data);
	}

	//qq第三方登录
	public function get_openid(){
		//应用的APPID
		$app_id = "101307047";
		//应用的APPKEY
		$app_secret = "1573603b1ee8ca5882632e9286964fe1";
		//成功授权后的回调地址
		$my_url = 'http://'.$_SERVER["SERVER_NAME"].'/index.php/Lilogin/sub';
		//Step1：获取Authorization Code
		$code = $_REQUEST["code"];
		if(empty($code))
		{
		 //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
		 $_SESSION['state'] = md5(uniqid(rand(), TRUE));
		 //拼接URL
		 $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=". $app_id . "&redirect_uri=" . urlencode($my_url) . "&state=". $_SESSION['state'];

		 echo("<script> top.location.href='" . $dialog_url . "'</script>");
		}
		//Step2：通过Authorization Code获取Access Token
		if($_REQUEST['state'] == $_SESSION['state'])
		{
			//拼接URL
			$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"."client_id=".$app_id."&redirect_uri=".urlencode($my_url)."&client_secret=" . $app_secret . "&code=" . $code;
			$response = file_get_contents($token_url);
			if (strpos($response, "callback") !== false){
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);
				if (isset($msg->error)){
				   echo "<h3>error:</h3>" . $msg->error;
				   echo "<h3>msg  :</h3>" . $msg->error_description;
				   exit;
				}
			}

			//Step3：使用Access Token来获取用户的OpenID
			$params = array();
			parse_str($response, $params);
			$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".
			$params['access_token'];
			$str  = file_get_contents($graph_url);
			if (strpos($str, "callback") !== false){
				$lpos = strpos($str, "(");
				$rpos = strrpos($str, ")");
				$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
			}
			$user = json_decode($str);
			if (isset($user->error)){
				echo "<h3>error:</h3>" . $user->error;
				echo "<h3>msg  :</h3>" . $user->error_description;
				exit;
			}
			$info_url = "https://graph.qq.com/user/get_user_info?access_token=".$params['access_token']."&oauth_consumer_key=".$app_id."&openid=".$user->openid;
			$res  = file_get_contents($info_url);
			if (strpos($res, "callback") !== false){
				$lpos = strpos($res, "(");
				$rpos = strrpos($res, ")");
				$res  = substr($res, $lpos + 1, $rpos - $lpos -1);
			}
			$info = json_decode($res);
			if (isset($info->error)){
				echo "<h3>error:</h3>" . $info->error;
				echo "<h3>msg  :</h3>" . $info->error_description;
				exit;
			}
			$_SESSION['openid'] = $user->openid;//echo($user->openid);
			$_SESSION['nickname'] = $info->nickname;
			header("location:".site_url("Lilogin/sub"));
		}else{
			echo("The state does not match. You may be a victim of CSRF.");
		}
	}

	public function submint(){
		$mobile=$this->input->post("mobile");
		$password=$this->input->post("password");
		$pass=$this->input->post("pass");
		$invitation=$this->input->post("invitation");
		$xoopscaptcha=$this->input->post("xoopscaptcha");
		$vo = $this->db->query("select * from zj_user where mobile='$mobile' limit 1")->row_array();
		if(is_array($vo)){
			$data = array();
			$data['status'] = 0;
			$data['message'] = "该手机号已经注册";
			exit(json_encode($data));
		}
		if($password===$pass){
			$data = array(
		       'mobile' => $mobile,
		       'nickname'=>$mobile,
		       'pass' => md5($password),
		    );
			$this->db->insert('zj_user', $data);
			$vo = $this->db->query("select * from zj_user where mobile='$mobile' limit 1")->row_array();
			$id=$vo['id'];
			if(!empty($id)){
				//注册环信
				$this->load->model("LInvitecode_model",'LInvitecode');
				 $hxname=$this->LInvitecode->huanxinRegister('Janzhu_'.$id);

				 if(!empty($hxname)){
				 	$Hxdata['hxname'] = $hxname;
				 	$this->db->update("zj_user",$Hxdata,"id=$id");
				 	$this->LInvitecode->invitecode2($id);
				 }else{
				 	$this->db->delete("zj_user","id='".$id."'");
				 	$data = array();
				 	$data['status'] = 0;
				 	$data['message'] = "环信注册失败";
				 	exit(json_encode($data));
				 }
				$log = array();
				$log['userid'] = $id;
				$log['content'] = '新用户注册';
				$log['zhuangtai'] = 1;
				$log['status'] = 2;
				$this->LInvitecode->integrallog($log,'1');
				if(!empty($invitation)){
					$sql="select * from `zj_invitecode` where code='".$invitation."'";
					$query=$this->db->query($sql);
					$invitationid=$query->row_array();
					if($invitationid){
						$log = array();
						$log['userid'] = $list['0']['userid'];
						$log['content'] = '邀请注册';
						$log['zhuangtai'] = 1;
						$log['status'] = 1;
						$this->User_Model->integrallog($log,'1');

					}else{
						$data = array();
						$data['status'] = 0;
						$data['message'] = "邀请码不存在";
						exit(json_encode($data));
					}
				}

				$data = array();
				$data['status'] = 1;
				$data['message'] = "注册成功";
				$_SESSION['uid'] = $id;
				$_SESSION['nickname'] = $mobile;
				$_SESSION['mobile'] = $mobile;
				exit(json_encode($data));
			}else{
				$data = array();
				$data['status'] = 0;
				$data['message'] = "注册失败";
				exit(json_encode($data));
			}
		}else{
			$data = array();
			$data['status'] = 0;
			$data['message'] = "两次输入的密码不一致";
			exit(json_encode($data));
		}
	}

	public function forgetpassword(){
		$data['mobile'] = $this->db->query("select * from `zj_aboutus` where id=1 ")->result_array();
		$this->load->view("home/login/zhaohui.html",$data);
	}
	public function forgetsub(){
		$newphone=$this->input->post('newphone');
		//验证码
		$xoopscaptcha=$this->input->post('xoopscaptcha');
		$reg_rand=$this->input->post('reg_rand');
		$referer=$this->input->post('referer');
		$sql="select * from `zj_user` where mobile='".$newphone."' limit 0,1";
		echo $sql;
		$row = $this->db->query($sql);
		if($row->row_array>1){
			$array=array(
				'pass' => md5($password),
			);
			$password=$this->db->update("zj_user",$array,"mobile='".$newphone."'");
			if($password){
				exit("<script>alert('修改成功'); window.location.href='".site_url('Lilogin/login')."';</script>");
			}else{
				exit('<script>alert("修改失败");window.history.go(-1)</script>');
			}
		}else{
			exit('<script>alert("手机号不存在");window.history.go(-1)</script>');
		}
	}
}
