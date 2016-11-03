<?php
//人脉
class FriendAction extends IndexAction{

	public $token;
	public $fuserid;

	function __construct(){
			parent::__construct();
			$this->token = I('post.token')?I('post.token'):I('get.token');
			$id = explode('_',I('post.fuserid')?I('post.fuserid'):I('get.fuserid'));
			$this->fuserid = intval($id['1']);
			if(empty($this->token)){
				get_obj_array('20000','参数不全！','');
			}

	}


	//人脉添加好友申请
	public function friendadd(){
			$fuserid = $this->fuserid;
			$User = M('User');
			$Friend = M('Friend');
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$Fcontent = $User->where("id = '$fuserid'")->limit(1)->select();

			if(!empty($Fcontent)){
				$zuserid = $uerContent['0']['id'];
				$Tcontent = $Friend->where("zuserid = '$zuserid' and fuserid = '$fuserid'")->limit(1)->select();
				if(empty($Tcontent)){
					$data['zuserid'] = $zuserid;
					$data['fuserid'] = $fuserid;
					$data['addtime'] = time();
					$Friend->add($data);
					get_obj_array('10000','添加成功',$this->token);
				}else{
					get_obj_array('20000','该用户已经是你的好友！','');
				}
			}else{
				get_obj_array('20000','该用户不存在！','');
			}

	}
	//好友同意申请
	public function friendagree(){
		$Friend = M('Friend');
		$Public = D('Public');
		$uerContent = $Public->userTokenCark($this->token);
		$fuserid = $uerContent['0']['id'];
		$zuserid = $this->fuserid;
		$Tcontent = $Friend->where("zuserid = '$zuserid' and fuserid = '$fuserid'")->limit(1)->select();
		if(!empty($Tcontent)){
			if($Tcontent['0']['status'] == 1){
				$data = array();
				$data['status'] = 2;
				$Friend->where("id='".$Tcontent['0']['id']."'")->data($data)->save();
				$Tcontent = $Friend->where("zuserid = '$fuserid' and fuserid = '$zuserid'")->limit(1)->select();
				if(empty($Tcontent)){
					$data['zuserid'] = $fuserid;
					$data['fuserid'] = $zuserid;
					$data['addtime'] = time();
					$Friend->add($data);
				}
				get_obj_array('10000','添加成功',$this->token);
			}else{
				get_obj_array('20000','该用户已经是你的好友！','');
			}
			
		}else{
			get_obj_array('20000','数据不存在！','');
		}

	}

	//删除好友
	public function frienddel(){
			
			if(!empty($this->fuserid)){
				$Friend = M('Friend');
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($this->token);
				$zuserid = $uerContent['0']['id'];
					
				$Friend->where("zuserid='$zuserid' and fuserid = '".$this->fuserid."'")->delete();
				get_obj_array('10000','删除成功！',$this->token);
			}else{
				get_obj_array('20000','参数不全！','');
			}
				

	}


	//获取好友资料 搜索用户
	/*
		参数：
			通过 以下都可以
			昵称 	nickname 获取单个
			手机号 	mobile


	*/
	public function frienddataList(){

			$hxname = I('post.hxname')?I('post.hxname'):I('get.hxname');
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$nickname = I('post.nickname')?I('post.nickname'):I('get.nickname');
			$isfriend = I('post.isfriend')?I('post.isfriend'):I('get.isfriend');
			$limit = ' group by u.id desc limit '.pageLimit();
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$userid = $uerContent['0']['id'];
			$where = '';
			if(!empty($hxname)){
				$where = " and u.hxname = '$hxname'";

			}
			if(!empty($mobile)){
				$where = " and u.mobile like '%$mobile%' ";
				//分页
			}
			if(!empty($nickname)){
				$where = " and u.nickname like '%$nickname%' ";

				//分页
			}
			if(!empty($isfriend)){
				$in = " INNER ";
				$where = ' and f.status = 2 ';
			}else{
				$in = " LEFT ";
			}
			
				$Friend = D('Friend');
				$sql = "SELECT u.id as uid,u.hxname,u.chusheng,u.nickname,u.mobile,u.sex,u.address,u.pic,IF(f.id && f.status=2,1,0) AS isfriend,IF(f.id && f.status=1,1,0) AS ist FROM zj_user as u
						$in JOIN zj_friend as f
						ON u.id = f.fuserid
						WHERE u.id != $userid $where" . $limit;
				$list = $Friend->query($sql);
				foreach ($list as $key => $value) {
					$list[$key]['uid'] = (string)$value['uid'];
					$list[$key]['nickname'] = (string)$value['nickname'];
					$list[$key]['hxname'] = (string)$value['hxname'];
					$list[$key]['chusheng'] = (string)getAge($value['chusheng']);
					$list[$key]['mobile'] = (string)$value['mobile'];
					$list[$key]['sex'] = (string)$value['sex'];
					$list[$key]['address'] = (string)$value['address'];
					$list[$key]['pic'] = (string)$value['pic'];
					$list[$key]['isfriend'] = (string)$value['isfriend'];
					$list[$key]['ist'] = (string)$value['ist'];
				}
				if(!empty($list)){
					get_obj_array('10000','查询成功',$list);
				}else{
					get_obj_array('20000','未查询到数据','');
				}

	}

	//通知信息列表
	/*
		参数：
			token
			客户端 type  1 安卓 2是ios 


	*/
	public function informList(){
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$type = I('post.type')?I('post.type'):I('get.type');
			$userid = $uerContent['0']['id'];
			$where = " userid = '$userid' and (type = 3 ";
			if($type == 1){
				$where .= ' or type = 1) ';
			}elseif($type == 2){
				$where .= ' or type = 2) ';
			}else{
				get_obj_array('20000','未查询到数据','');
			}
			$limit = pageLimit();
			$Inform = M('Inform');
			$list = $Inform->where($where)->limit($limit)->select();
			$root = array();
			if(!empty($list)){
				foreach ($list as $key => $value) {
					$root[$key]['iid'] = (string)$value['id'];
					$root[$key]['title'] = (string)$value['title'];
					$root[$key]['content'] = explode("\r\n",$value['content']);
					$root[$key]['addtime'] = (string)date('Y-m-d',$value['addtime']);
					$root[$key]['status'] = (string)$value['status'];
				}
				get_obj_array('10000','查询成功',$root);
			}else{
				get_obj_array('20000','未查询到数据','');
			}
	}
	//查看通知信息
	public function informlook(){
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$id = I('post.iid')?I('post.iid'):I('get.iid');
			$userid = $uerContent['0']['id'];
			if(!empty($id)){
				$root = array();
				$where = " id = '$id' and userid = '$userid'";
				$Inform = M('Inform');
				$list = $Inform->where($where)->limit(1)->select();
				$root['0']['iid'] = (string)$list['0']['id'];
				$root['0']['title'] = (string)$list['0']['title'];
				$root['0']['content'] = explode("\r\n",$list['0']['content']);
				$root['0']['addtime'] = (string)date('Y-m-d',$list['0']['addtime']);
				$root['0']['status'] = '1';
				if($list['0']['status'] == 0){
					$data['status'] = 1;
					$Inform->where("id='$id' and userid = '$userid'")->data($data)->save();
				}
				
				get_obj_array('10000','查询成功',$root);
			}else{
				get_obj_array('20000','未查询到数据','');
			}
	}
	
	//删除通知信息
	public function informdel(){
		$Public = D('Public');
		$Inform = M('Inform');
		$uerContent = $Public->userTokenCark($this->token);
		$id = trim(I('post.iid')?I('post.iid'):I('get.iid'),',');
		$userid = $uerContent['0']['id'];
		$t = $Inform->where("id in($id) and userid = '$userid'")->delete();
		if(empty($t)){
			get_obj_array('20000','删除失败','');
		}else{
			get_obj_array('10000','删除成功',$this->token);
		}
		
	}

}