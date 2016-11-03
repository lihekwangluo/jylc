<?php
//意见反馈
class FeedbackAction extends IndexAction{

		/*
			反馈意见添加
			参数：
				token 	用户登录
				name 	用户名称
				mobile  手机号
				content 反馈内容

		*/
		public function feedbackadd(){
			$data = array();
			$token = $this->uid;
			$data['name'] = I('post.name')?I('post.name'):I('get.name');
			$data['mobile'] = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$data['content'] = I('post.content')?I('post.content'):I('get.content');
			if(empty($token) || empty($data['name']) || empty($data['mobile']) || empty($data['content'])){
					return get_obj_array('20000','参数不全！','');
			}else{
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				$data['userid'] = $uerContent['0']['id'];
				$data['addtime'] = time();
				//反馈信息写入数据库
				$Feedback = M('Feedback');
				$Feedback -> add($data);
				//返回参数
				// $root['token'] = (string)$token;
				// $root['pic'] = (string)$uerContent['0']['pic'];
				// $root['mobile'] = (string)$uerContent['0']['mobile'];
				// $root['name'] = (string)$uerContent['0']['name'];
				return get_obj_array('10000',"成功");
			}
		}
}