<?php
// 工友圈
class WorkmateAction extends IndexAction{

	//发布内容
	/*
		参数：
			token 		用户唯一标示
			content 	发布内容
			address 	地址
			pic0-pic9 	图片

	*/
	public function workmatePublish(){
			$data = array();
			$token = I('post.token')?I('post.token'):I('get.token');
			$data['content'] = I('post.content')?I('post.content'):I('get.content');
			$data['address'] = I('post.address')?I('post.address'):I('get.address');

			if(empty($token)){
				get_obj_array('20000','参数不全','');
			}elseif(!empty($_FILES) || !empty($data['content'])){
				//用户提前判断
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				//图片
				if(!empty($_FILES)){
					$imgArr = $Public->imgFile('1');
					$pic = '';
					for($i=0;$i<=9;$i++) {
						$pic .= $imgArr['pic'.$i].',';
					}
					$data['pic'] = trim($pic,',');
				}
				$data['userid'] = $uerContent['0']['id'];
				$data['addtime'] = time();
				$data['status'] = '1';
				$Workmate = M('Workmate');
				$id = $Workmate->add($data);
				if($id>0){
					get_obj_array('10000','发布成功！',$token);
				}else{
					get_obj_array('20000','服务异常，发布失败！','');
				}

			}	
	}
	//删除发布
	/*
		token 
		wid
	*/
	public function workmateDel(){
		$token = I('post.token')?I('post.token'):I('get.token');
		$wid = I('post.content')?I('post.wid'):I('get.wid');
		if(empty($wid) || empty($token)){
				get_obj_array('20000','参数不全','');
		}else{
			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$id = $uerContent['0']['id'];

			$Workmate = M('Workmate');
			$Workmatepraise = M('Workmatepraise');
			$Workmatereply = M('Workmatereply');
			//查询是否存在
			$list = $Workmate->where("id='$wid' and userid='$id'")->select();
			if(!empty($list)){
				//删除主表
				$Workmate->where("id='$wid' and userid='$id'")->delete();
				$Workmatepraise->where("workmateid='$wid'")->delete();
				$Workmatereply->where("workmateid='$wid'")->delete();
				get_obj_array('10000','删除成功',$token);
			}else{
				get_obj_array('20000','数据不存在','');
			}
			
		}
	}

	//点赞
	/*
			参数：

				token 		用户唯一标示
				wid 		发布内容id
	*/

	public function workmatepraise(){
		$token = I('post.token')?I('post.token'):I('get.token');
		$wid = I('post.wid')?I('post.wid'):I('get.wid');
		if(empty($wid) || empty($token)){
				get_obj_array('20000','参数不全','');
		}else{
			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$Workmate = M('Workmate');
			$list = $Workmate->where("id = '".$wid."'")->limit(1)->select();
			if(!empty($list)){
				$Workmatereply = M('Workmatereply');
				$praiselist = $Workmatereply->where("fuserid = '".$list['0']['userid']."' and zuserid = '".$uerContent['0']['id']."' and workmateid='$wid' and type = 1 ")->limit(1)->select();
				
				if(empty($praiselist)){
					$data = array();
					$data['workmateid'] = $wid;
					$data['fuserid'] = $list['0']['userid'];
					$data['zuserid'] = $uerContent['0']['id'];
					$data['addtime'] = time();
					$data['type'] = '1';
					
					$id = $Workmatereply->add($data);
					if($id>0){
						get_obj_array('10000','点赞成功！',$token);
					}else{
						get_obj_array('20000','服务异常，发布失败！','');
					}
				}else{

					$id = $Workmatereply->where("id='".$praiselist['0']['id']."' and type = 1")->delete();
					get_obj_array('10000','取消点赞！','');
				}
			}else{
				get_obj_array('20000','参数不全','');
			}
		}
	}

	//回复留言
	/*
		token 		用户唯一标示
		wid   		发布内容id
		content     回复内容
		pid   		回复的id

	*/
	public function workmatereply(){
			$Public = D('Public');
			$token = I('post.token')?I('post.token'):I('get.token');
			$wid = I('post.wid')?I('post.wid'):I('get.wid');
			$content = $Public->delSensitivity(I('post.content')?I('post.content'):I('get.content'));//详细要求
			$pid = I('post.pid')?I('post.pid'):I('get.pid');

			if(empty($token) || empty($wid) || empty($content)){

				get_obj_array('20000','参数不全','');
			}

			//用户提前判断
			
			$uerContent = $Public->userTokenCark($token);
			
			$Workmate = M('Workmate');
			$Workmatelist = $Workmate->where("id = '$wid'")->select();
			if(empty($Workmatelist)){
				get_obj_array('20000','数据不存在','');
			}

			$Workmatereply = M('Workmatereply');
			$data = array();
			$data['workmateid'] = $wid;
			$data['fuserid'] = $Workmatelist['0']['userid'];
			$data['zuserid'] = $uerContent['0']['id'];
			$data['content'] = $content;
			$data['addtime'] = time();
			$data['type'] = '2';
			if(!empty($pid)){
				$Replylist = $Workmatereply->where("id = '$pid' and workmateid='$wid' and type = 2")->select();
				if(!empty($Replylist)){
					if($Replylist['0']['pid'] == 0){$pid = $Replylist['0']['id'];}else{$pid = $Replylist['0']['pid'];}
					$data['pid'] = $pid;
					$data['fuserid'] = $Replylist['0']['zuserid'];
					$data['zuserid'] = $uerContent['0']['id'];
					$data['leve'] = $Replylist['0']['leve'] + 1;
				}else{
					get_obj_array('20000','回复内容不存在','');
				}
			}
			if($data['fuserid'] == $data['zuserid']){

				get_obj_array('20000','自己不能给自己回复','');
			}
			$id = $Workmatereply->add($data);
			$list = array();
			$Workmate = D('Workmate');
			$list = $Workmate->sFriendWorkmate($uerContent['0']['id'],'1',$Workmatelist['0']['status'],$wid);
			if($id>0){
				get_obj_array('10000','回复成功！',$list);
			}else{
				get_obj_array('20000','回复失败！','');
			}
	}
	//删除回复
	/*
		token 		用户唯一标示
		rid 		回复id
	*/
	public function replyDel(){
		$token = I('post.token')?I('post.token'):I('get.token');
		$rid = I('post.rid')?I('post.rid'):I('get.rid');
		if(empty($token) || empty($rid)){

			get_obj_array('20000','参数不全','');
		}

		//用户提前判断
		$Public = D('Public');
		$uerContent = $Public->userTokenCark($token);
		$zuserid = $uerContent['0']['id'];
		//查询回复是否存在
		$Workmatereply = M('Workmatereply');
		$list = $Workmatereply->where("id = '$rid' and zuserid = '$zuserid'")->select();
		if(!empty($list)){
			$Workmate = D('Workmate');
			$Workmate ->delReply($rid);
			get_obj_array('10000','删除成功！',$token);
		}else{
			get_obj_array('20000','数据不存在','');
		}

	}

	//-------------------------列表---------------
	//所有动态
	/*
		token 		用户唯一标示
		status 		1是工友圈/2是子女教育
		wid 		文章id
	*/
	public function workmateList($token,$status,$wid=''){
			$token = I('post.token')?I('post.token'):I('get.token');
			$status = I('post.status')?I('post.status'):I('get.status');
			$id = I('post.wid')?I('post.wid'):I('get.wid');
			if(empty($token) || empty($status)){

				get_obj_array('20000','参数不全','');
			}
			
			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$Workmate = D('Workmate');

			//分页
			$limit = pageLimit();
			
			$list = $Workmate->sFriendWorkmate($uerContent['0']['id'],$limit,$status,$id);
			if(!empty($list)){
				get_obj_array('10000','成功！',$list);
			}else{
				get_obj_array('20000','数据不存在','');
			}
	}

	//与我相关
	/*
		token 		用户唯一标示
	*/
	public function workmateMy(){
			$token = I('post.token')?I('post.token'):I('get.token');
			if(empty($token)){

				get_obj_array('20000','参数不全','');
			}
			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$Workmate = D('Workmate');

			//分页
			$limit = pageLimit();

			$list = $Workmate->sCountMy($uerContent['0']['id'],$limit);
			if(!empty($list)){
				get_obj_array('10000','成功！',$list);
			}else{
				get_obj_array('20000','数据不存在','');
			}

	}

	//有多少个与我相关
	/*
		token 		用户唯一标示
	*/
	public function workmateMyNum(){
			$token = I('post.token')?I('post.token'):I('get.token');
			if(empty($token)){

				get_obj_array('20000','参数不全','');
			}
			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$userid = $uerContent['0']['id'];
			$Workmatereply = M('Workmatereply');
			$list = $Workmatereply->where("fuserid = '$userid' and status = 0")->count();
			if(empty($list)){
				$list = '0';
			}
			get_obj_array('10000','与我相关数量',$list);
	}

	//分享给我提交下
	public function workmateShare(){
			$token = I('post.token')?I('post.token'):I('get.token');
			$wid = I('post.wid')?I('post.wid'):I('get.wid');
			if(empty($token) || empty($wid)){

				get_obj_array('20000','参数不全','');
			}

			//用户提前判断
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			
			$Workmate = M('Workmate');
			$Workmatelist = $Workmate->where("id = '$wid'")->select();
			if(empty($Workmatelist)){
				get_obj_array('20000','数据不存在','');
			}
			$Workmate = M();
			$sql = "UPDATE zj_workmate SET share = share+1 WHERE id = '$wid'";
			$Workmate->query($sql);
			get_obj_array('10000','成功',$token);

	}

	


	// ------------------------辅助---------------
	






}