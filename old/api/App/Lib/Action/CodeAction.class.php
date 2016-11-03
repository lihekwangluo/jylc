<?php
use App\Http\Logic\UserLogic;
//验证码
class CodeAction extends Action{
	/*
		mobile 手机号
	*/
	public function getcode(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
            $is_register = I('post.is_register')?I('post.is_register'):I('get.is_register');
			if(empty($mobile)){
				get_obj_array('20000','参数不全','0');
			}else{
                if($is_register == 1){
                    $userLogic = new UserLogic();
                    if($userLogic->checkUserMobileExist($mobile)){
                        get_obj_array('20000','该手机号已注册','0');
                    }
                }
				$Public = D('Public');
				$code = rand('1000','9999');
				$content = '来自建遇良才的信息，你的验证码：'.$code;
				$Public->ChuanglanSmsHelper($mobile,$content);
				SendMsg($mobile,$content);
				// 查询数据
				$Code = M("Code"); 
				$list = $Code->where("mobile='$mobile'")->limit(1)->select();

				$data['addtime'] = time();
				$data['code'] = $code;
				if(empty($list)){
					$data['mobile'] = $mobile;
					$t = $Code->add($data);
				}else{
					$Code->where("mobile='$mobile'")->save($data); 
				}
				get_obj_array('10000',"$code",'1');
			}
			
	}
}