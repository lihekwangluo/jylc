<?php
//验证码
class CodeAction extends Action{
	/*
		mobile 手机号
	*/
	public function getcode(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			if(empty($mobile)){
				return get_obj_array('20000','参数不全','0');
			}else{
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
				return get_obj_array('10000',"$code",'1');
			}
			
	}
}