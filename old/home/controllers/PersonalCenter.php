<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class PersonalCenter extends Indexinit {

	public function index(){
		$this->cklogin();
		$this->load->model('Public_model','Public');
		$segment=$this->uri->segment(3);
		$Sql = "SELECT p.id,p.title,p.addtime,p.status,u.name,u.type as stype FROM zj_publish as p
					INNER JOIN zj_user as u
					ON u.id = p.userid
					WHERE p.userid=".$_SESSION['uid']." group by p.id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data['leftcss'] = 1;
		$data['url'] = "pesonalcenter/index";
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren1.html",$data);
	}
	public function datas(){
		$this->cklogin();
		$uid = $_SESSION['uid'];
		if($_POST){
			$data = array();
			$mobile = $this->input->post("mobile");
			$nickname = $this->input->post("nickname");
			// $name = $this->input->post("name");
			$chusheng = $this->input->post("chusheng");
			$sex = $this->input->post("sex");
			$address = $this->input->post("address");
			if(!empty($nickname)){
				$data['nickname'] = $nickname;
			}
			if(!empty($chusheng)){
				$data['chusheng'] = $chusheng;
			}
			if(!empty($sex)){
				$data['sex'] = $sex;
			}
			if(!empty($address)){
				$data['address'] = $address;
			}

			// if(!empty($name)){
			// 	$data['name'] = $name;
			// }

			$craftid = $this->input->post("craftid");
			$this->load->model('Score_model','Score');
			$uerContent = $this->Score->userTokenCark($uid);
			$id = $uerContent['id'];
			if(empty($uerContent['mobile'])){
				$data['mobile'] = $mobile;
			}

			$this->db->update("zj_user",$data,"id='$uid'");

			//写入工种
			if($craftid){
				$this->db->query("delete from zj_usercraft where userid = '$uid'");
				$craftid = explode(',',trim($craftid,','));
				foreach ($craftid as $v) {
					$data = array();
					$data['userid'] = $uid;
					$data['craftid'] = $v;
					$this->db->insert("zj_usercraft",$data);
				}
			}
			$data = array(
				'status' => 1,
				'message' => '修改成功',
			);
			exit(json_encode($data));
		}
		$data=array();
		$data = $this->db->query("select * from zj_user where id='$uid' limit 1")->row_array();
		$sql = "SELECT c.id,c.name,c.pid,c.status FROM zj_user as u
				INNER JOIN zj_usercraft as uc
				ON u.id = uc.userid
				INNER JOIN zj_craft as c
				ON uc.craftid = c.id
				WHERE u.id = '$uid' and c.status =1 group by c.id";
		$data['craft'] = $this->db->query($sql)->result_array();
		$data['crafts'] = $this->db->query("select id,name from zj_craft where status=1")->result_array();
		$data['leftcss'] = 2;
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren2.html",$data);
	}
	public function integral(){
		$this->cklogin();
		$uid = $_SESSION['uid'];
		$this->load->model('Public_model','Public'); //公用model
		$segment=$this->uri->segment(3);
		$integral = $this->db->query("select integral from zj_user where id='$uid' limit 1")->row_array();
		$Sql = "SELECT * FROM zj_integrallog where userid='$uid' order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data["leftcss"] = 3;
		$data['integral'] = $integral['integral'];
		$data['url'] = "pesonalcenter/integral";
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren3.html",$data);
	}
	public function coll(){
		$this->cklogin();
		$uid = $_SESSION['uid'];
		if($_GET['cid']){
			$id = intval($_GET['cid']);
			$this->db->query("delete from zj_collect where id ='$id' limit 1");
			$data = array(
				'status' => 1,
				'message' => '删除成功',
			);
			exit(json_encode($data));
		}
		$this->load->model('Public_model','Public'); //公用model
		$segment=$this->uri->segment(3);
		$Sql = "SELECT c.*,p.title FROM zj_collect as c inner join zj_publish as p ON c.publishid=p.id where c.userid='$uid' order by c.id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data["leftcss"] = 4;
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren4.html",$data);
	}
	public function invitation(){
		$this->cklogin();
		$uid = $_SESSION['uid'];
		$data=array("leftcss"=>5);
		//$data['code'] = inviteCode($uid);
		$li = $this->db->query("select * from zj_invitecode where userid=2 limit 1")->row_array();
		$data['code'] = $li['code'];
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren5.html",$data);
	}
	public function certification(){
		$this->cklogin();
		$uid = $_SESSION['uid'];
		$this->load->model('Score_model','Score');
		$uerContent = $this->Score->userTokenCark($uid);
		if($uerContent['renzheng']=='1'){
			echo '<script>alert("已经认证成功");</script>';
		}elseif($_POST){
			$name = $this->input->post("name");
			$idcard = $this->input->post("idcard");
			$type = $this->input->post("type");
			if(empty($uid) || empty($name) || empty($idcard)|| empty($type)){
				exit("请填写完整再提交");
			}else{
				$imgNum = count($_FILES);
				$data = array();
				//图片上传判断
				if(($imgNum==2) && ($type==1)){
					$data['type'] = '1';
				}elseif(($imgNum==3) && ($type==2)){
					$data['type'] = '2';
				}elseif(($imgNum==2) && ($type==3)){
					$data['type'] = '3';
				}else{
					exit("上传与认证不符合！");
				}
				$this->load->model('Public_model','Public');
				// for($i=1;$i<=$imgNum;$i++){
				// 	$pic[] = $this->Public->fileImg($_FILES['pic'.$i]);
				// }

				if($_FILES['idcard_1']){
					$idcard_1 = $this->Public->fileImg($_FILES['idcard_1'],$this->input->post("idcard_1"));
					@unlink($_SERVER['DOCUMENT_ROOT'].$uerContent['cardzpic']);
				}

				if($_FILES['idcard_2']){
					$idcard_2 = $this->Public->fileImg($_FILES['idcard_2'],$this->input->post("idcard_2"));
					@unlink($_SERVER['DOCUMENT_ROOT'].$uerContent['cardfpic']);
				}

				if($data['type'] == 1){
					$data['enterprisepic'] = '';
					$data['cardzpic'] = $idcard_1;
					$data['cardfpic'] = $idcard_2;

				}else{
					if($_FILES['zhizhao']){
						$zhizhao = $this->Public->fileImg($_FILES['zhizhao'],$this->input->post("zhizhao"));
						@unlink($_SERVER['DOCUMENT_ROOT'].$uerContent['enterprisepic']);
					}
					$data['enterprisepic'] = $zhizhao;
					$data['cardzpic'] = $idcard_1;
					$data['cardfpic'] = $idcard_2;
				}

				$data['name'] = $name;
				$data['idcard'] = $idcard;
				$this->db->update("zj_user",$data,"id='$uid'");

				echo '<script>alert("提交成功,请耐心等待审核");</script>';
				exit();
			}
		}
		$uerContent['leftcss'] = 6;
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren6.html",$uerContent);
	}
	public function updatetel(){
		$this->cklogin();
		$uid= $_SESSION['uid'];
		if($_POST){
			$mobile = $this->input->post("mobile");
			$pass = $this->input->post("pass");
			$mobile2 = $this->input->post("mobile2");
			$code = $this->input->post("code");
			if(empty($uid) || empty($mobile) || empty($pass) || empty($mobile2) || empty($code)){
				ajaxmsg(0,"请填写完再提交");
				//return get_obj_array('20000',"参数不全！",'');

			}else{
				if($mobile == $mobile2){
					ajaxmsg(0,"新手机号不能与旧手机号相同！");
					//return get_obj_array('20000',"新手机号不能与旧手机号相同！",'');
				}

				$list = $this->db->query("select * from zj_code where mobile='$mobile' and code='$code' limit 1")->row_array();
				if(!empty($list)){
					$list1 = $this->db->query("select * from zj_user where mobile='$mobile2' limit 1")->row_array();
					if(empty($list1)){
						$list = $this->db->query("select * from zj_user where status = 1 and mobile='$mobile' and pass = '".md5($pass)."' limit 1")->row_array();
						if(!empty($list)){
							$data = array();
							$data['mobile'] = $mobile2;
							$this->db->update("zj_user",$data,"id='$list[id]'");
							//删除验证码
							$this->db->query("delete from zj_code where mobile='$mobile'");
							ajaxmsg(1,"修改成功！");//return get_obj_array('10000','修改成功！',$list['0']['token']);
						}else{
							ajaxmsg(0,"用户名密码不匹配！");//return get_obj_array('20000','用户名密码不匹配！','');
						}
					}else{
						ajaxmsg(0,"新手机号已经被注册！");//return get_obj_array('20000','新手机号已经被注册！','');
					}

				}else{
					ajaxmsg(0,"验证码错误！");//return get_obj_array('20000','验证码错误！','');
				}

			}
		}
		$data=array("leftcss"=>7);
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren7.html",$data);
	}
	public function updatepassword(){
		$this->cklogin();
		$uid= $_SESSION['uid'];
		if($_POST){
			$mobile = $this->input->post("mobile");
			$pass1 = $this->input->post("password");
			$pass2 = $this->input->post("newpwd");
			$pass3 = $this->input->post("newrepwd");
			if(empty($uid) || empty($mobile) || empty($pass1) || empty($pass2) || empty($pass2)){
				ajaxmsg(0,"请填写完整再提交");
			}else{
				if($pass1 === $pass2){
					ajaxmsg(0,"新密码和旧密码太过相似！");// /return get_obj_array('20000',"新密码和旧密码太过相似！",'');
				}else{
					if($pass2 === $pass3){
						//$User = M('User');
						$list = $this->db->query("select * from zj_user where status = 1 and mobile='$mobile' and pass = '".md5($pass1)."' limit 1")->row_array();
						if(!empty($list)){
							$data = array();
							$data['pass'] = md5($pass2);
							$this->db->update("zj_user",$data,"id='$list[id]'");
							ajaxmsg(1,"修改成功！");
						}else{
							ajaxmsg(0,"用户名密码不匹配！");//return get_obj_array('20000','用户名密码不匹配！','');
						}
					}else{
						ajaxmsg(0,"两次密码不一致！");
						//return get_obj_array('20000',"两次密码不一致！",'');
					}

				}
			}
		}
		$data=array("leftcss"=>8);
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren8.html",$data);
	}
	// public function updatepasswordsub(){
	// 	$mobile=$this->input->post("sjh");
	// 	//µÇÂ¼ÃÜÂë
	// 	$pass=$this->input->post("dl_mima");
	// 	$newpass=$this->input->post("mima");
	// 	$newpass2=$this->input->post("mima2");
	// 	$yanzheng=$this->selectRow("zj_user","mobile='".$mobile."' and pss='".$pass."'");
	// 	if($yanzheng){
	// 		if($newpass===$newpass2){
	// 			$array=array(
	// 				'pass'=>$newpass,
	// 			);
	// 			$password=$this->db->update("zj_user",$array,"mobile='".$mobile."'");
	// 			if($password){

	// 			}else{

	// 			}
	// 		}
	// 	}else{
	// 		//exit("<script>alert('ÃÜÂëÊäÈëµÄ²»Ò»ÖÂ');windon.</script>");
	// 	}
	// }
	public function opinion(){
		$data=array("leftcss"=>9);
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren9.html",$data);
	}
	public function opinionsub(){
		$this->cklogin();
		$name=$this->input->post("name");
		$tell=$this->input->post("tell");
		$yijian=$this->input->post("yijian");
		if($this->input->post("sub")==="1"){
			$array=array(
				'userid'=>$_SESSION['uid'],
				'name'=>$name,
				'mobile'=>$tell,
				'content'=>$yijian,
				'addtime'=>time()
			);
			$feek=$this->db->insert("zj_feedback",$array);
			if($feek){
				success("反馈成功");
			}else{
				error("反馈失败");
			}
		}
	}
	public function me(){
		$this->cklogin();
		$data=array("leftcss"=>10);
		$data['me']=$this->selectRow("zj_aboutus","typeaboutus=1");
		$data['search']=$this->remen();
		$this->load->view("home/personal/geren10.html",$data);
	}
				//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
