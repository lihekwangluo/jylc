<?php
// 本类由系统自动生成，仅供测试用途
class LoginAction extends HcommonAction {

	public function index(){
        if(IS_POST||I("get.code")){
				$_POST['version'] = '1.0';
				$_POST['terminal'] = 'h5';
				$user = A("Api/User");
				$res = $user->userlogin();
				if($res===true) {
					if(session_tp( "openid")){
						session_tp( "uid",session_tp( "openid"));
						session_tp( "openid",null);
						redirect_tp( $this->_root."/member");
						exit;
					}else{
						$mobile = I("post.mobile");
						$pass = I("post.pass");
						$vo = M("user")->field("id,nickname")->where("status = 1 and mobile='$mobile' and pass = '".md5($pass)."'")->find();
						session_tp( "uid",$vo['id']);
						session_tp( "nickname",$vo['nickname']);
						setcookie("uid",$vo['id'],time()+351860000,'/');
						setcookie("nickname",$vo['nickname'],time()+351860000,'/');
                        if(IS_POST){
                            ajaxmsg("1","登陆成功");
                        }else{
                            header("Location:/wap/index.php/member");
                        }
					}
				}else ajaxmsg(0,$res);
			}

			if(cookie_tp("uid")){
				header("Location:/wap/index.php/member");
			}else{
				$this->display();
			}


	}

	public function get_openid(){
		//应用的APPID
		$app_id = "101307047";
		//应用的APPKEY
		$app_secret = "1573603b1ee8ca5882632e9286964fe1";
		//成功授权后的回调地址
		$my_url = 'http://'.$_SERVER["SERVER_NAME"].'/wx.php/login';

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
			header("location:".$this->_root."/login");
		}else{
			echo("The state does not match. You may be a victim of CSRF.");
		}
	}

	public function logout(){

			session_tp( "uid",NULL);
			session_tp( "nickname",NULL);
		setcookie("uid","$this->uid",time()-7*86400,'/');
		setcookie("nickname","$this->nickname",time()-7*86400,'/');
			redirect_tp( $this->_root);

	}
}