<?php
use App\Http\Logic\UserLogic;
// 本类由系统自动生成，仅供测试用途
class RegisterAction extends HcommonAction {

	public function index(){
		if(IS_POST){
			$user = A("Api/User");
			$res = $user->adduser();
			if($res===true){
				$mobile = I("post.mobile");
				$pass = I("post.pass1");
				$vo = M("user")->field("id,nickname")->where("status = 1 and mobile='$mobile' and pass = '".md5($pass)."'")->find();
				session_tp( "uid",$vo['id']);
				session_tp( "nickname",$vo['nickname']);
				ajaxmsg(1,"注册成功");
			}else ajaxmsg(0,$res);
		}
		$this->display();
	}

	public function send_code(){
        $mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
        $is_register = I('post.is_register')?I('post.is_register'):I('get.is_register');
        if($is_register == 1){
            $userLogic = new UserLogic();
            if($userLogic->checkUserMobileExist($mobile)){
                ajaxmsg(0,"该手机号已注册");
            }
        }
		$code = A("Api/Code");
		$res = $code->getcode();
		if($res===false) ajaxmsg(0,"手机号码有误");
		else ajaxmsg(1,$res);
	}
}