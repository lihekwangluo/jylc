<?php

class WorkmateModel extends Model {

	//删除回复
	public function delReply($id){
			$Reply = M('Workmatereply');
			$list = $Reply->where("pid = '$id' and type = 2")->select();
			foreach($list as $key => $value) {
				$this->delReply($value['id']);
				$Reply->where("id = '".$value['id']."' and type = 2")->delete();
			}
			$Reply->where("id = '$id' and type = 2")->delete();
	}
	//查询列表
	public function sFriendWorkmate($userid,$limit,$status,$id=''){
		if($status == 1){
			$where = " w.status = 1";
		}elseif($status == 2){
			$where = " w.status = 2";
		}else{
			$where = " w.userid = '$userid' and w.status = 1";
		}
		if($id){
			$where = " w.id = '$id' and w.status = '$status'";
		}
		
		$S = M();
		$Workmatereply = M('Workmatereply');
		 $sql = "SELECT w.id as wid,w.userid,w.content,w.content as wcontent,w.video,w.litpic,w.pic,w.address,w.addtime,w.share,u.nickname,u.pic as upic FROM zj_workmate as w
				left JOIN zj_user as u
				ON u.id = w.userid
				WHERE $where group by w.id desc limit ".$limit;
		$list = $S->query($sql);
		foreach ($list as $key => $value) {
				$list[$key]['wid'] = (string)$value['wid'];
				$list[$key]['userid'] = (string)$value['userid'];
				$list[$key]['nickname'] = (string)$value['nickname'];
				$list[$key]['upic'] = (string)$value['upic'];
				$root[$key]['wcontent'] = (string)$value['wcontent'];
				$list[$key]['content'] = (string)$value['content'];
				$list[$key]['video'] = (string)$value['video'];
				$list[$key]['litpic'] = json_decode($value['litpic'],true);
				if($value['pic']==''){
					$list[$key]['pic']=array();
				}else{
					$list[$key]['pic']= explode(',',$value['pic']);
				}
				$list[$key]['address'] = (string)$value['address'];
				$list[$key]['addtime'] = (string)date('Y-m-d H:i',$value['addtime']);
				$list[$key]['share'] = (string)$value['share']; //分享次数
				$list[$key]['reply'] = $this->sFriendReply($value['wid']); //查询回复
				$list[$key]['replycount'] = (string)count($list[$key]['reply']); //回复多少个
				$list[$key]['is_zan'] = (string)$this->is_Zan($userid,$value['wid']);
				$list[$key]['praise'] = (string)$Workmatereply->where("workmateid = '".$value['wid']."' and type = 1")->count(); //点赞多少个
		}
		return $list;
	}


	//查询评价
	public function sFriendReply($id,$i='',$userid='',$pid=0){
		$S = M('Workmatereply');
		if(!empty($i) && !empty($userid)){
			$S->where("workmateid = '$id'  and type = 1")->data(array('status'=>'1'))->save(); //点赞已读
			$S->where("workmateid = '$id'  and type = 2 and fuserid = '$userid'")->data(array('status'=>'1'))->save(); //回复已读
		}
		$list = $S->where("workmateid = '$id' and type = 2 and pid = '$pid'")->order('addtime asc,leve asc')->select();
		
		$root = array();
		foreach ($list as $key => $value) {
			$root[$key] = $this->slUser($value['fuserid'],$value['zuserid']);
			$root[$key]['rid'] = (string)$value['id'];
			$root[$key]['wid'] = (string)$value['workmateid'];
			$root[$key]['content'] = (string)$value['content'];
			$root[$key]['pid'] = (string)$value['pid'];
			$root[$key]['addtime'] = (string)date('Y-m-d H:i',$value['addtime']);
			$root[$key]['leve'] = (string)$value['leve'];
			if($pid == 0){
				
				$root[$key]['reply'] = $this->sFriendReply($id,$i='',$userid='',$value['id']);
			}
		}
		return $root;
		
	}

	//与我有关
	public function sCountMy($userid,$limit){
		$S = M();
		$User = M("User");
		$sql = "SELECT w.id,r.id as rid,r.zuserid as userid,r.content,w.content as wcontent,w.pic,w.address,r.addtime,r.type,u.nickname,u.pic as upic FROM zj_workmatereply as r
				INNER JOIN zj_workmate as w ON w.id = r.workmateid
				INNER JOIN zj_user as u ON u.id = r.zuserid
				WHERE r.fuserid = '$userid' and r.pid=0 group by r.id desc limit ".$limit;
		$list = $S->query($sql);
		$root = array();
		foreach($list as $key => $value){
				$root[$key]['wid'] = (string)$value['id'];
				$root[$key]['rid'] = (string)$value['rid'];
				$root[$key]['userid'] = (string)$value['userid'];
				$root[$key]['nickname'] = (string)$value['nickname'];
				$root[$key]['upic'] = (string)$value['upic'];
				$root[$key]['content'] = (string)$value['content'];
				$root[$key]['wcontent'] = (string)$value['wcontent'];
				$root[$key]['pic'] = explode(',',$value['pic']);
				if($value['pic']==''){
					$root[$key]['pic']=array();
				}else{
					$root[$key]['pic']= explode(',',$value['pic']);
				}
				$root[$key]['address'] = (string)$value['address'];
				$root[$key]['addtime'] = date('Y-m-d H:i',$value['addtime']);
				$root[$key]['type'] = (string)$value['type']; //类别
				$Usercont = array();
				if($value['type'] == 2){
					$S = M();
					$sql="SELECT id as rid,zuserid,fuserid,content FROM zj_workmatereply where `fuserid` in ($value[userid],$userid) and `zuserid` in ($value[userid],$userid) and `workmateid`=$value[id] and pid=$value[rid]";
					$result=$S->query($sql);
					foreach($result as $k=>$v){
						$S = M();
						$sql="SELECT id,nickname FROM zj_user where `id`=$v[zuserid]";
						$nickname=$S->query($sql);
						$result[$k]['zuserid']=$nickname[0]['id'];
						$result[$k]['zusername']=$nickname[0]['nickname'];
						$S = M();
						$sql="SELECT id,nickname FROM zj_user where `id`=$v[fuserid]";
						$nickname=$S->query($sql);
						$result[$k]['fuserid']=$nickname[0]['id'];
						$result[$k]['fusername']=$nickname[0]['nickname'];
					}
					$root[$key]['reply'] = $result;
				}else{
					$root[$key]['reply'] = array(); //查询回复
					$Usercont = $User->where("id = '".$value['zuserid']."'")->limit(1)->field('nickname,pic')->select();
				}
//				$root[$key]['zuserid'] = (string)$value['zuserid']; //赞了我
//				$root[$key]['nickname'] = (string)$Usercont['0']['nickname']; //赞了我
//				$root[$key]['userpic'] = (string)$Usercont['0']['pic']; //赞了我
		}
		return $root;

	}
	//查询用户谁对谁发布用户信息
	public function slUser($fuserid,$zuserid){

		$User = M("User");
		$list = $User->where("id in('$fuserid','$zuserid')")->limit(2)->select();
		$root = array();
		for($i=0; $i <= 1; $i++) { 
			if($list[$i]['id'] == $fuserid){
				$root['fuserid'] = (string)$list[$i]['id'];
				$root['fuserpic'] = (string)$list[$i]['pic'];
				$root['fusername'] = (string)$list[$i]['nickname'];
			}else{
				$root['zuserid'] = (string)$list[$i]['id'];
				$root['zuserpic'] = (string)$list[$i]['pic'];
				$root['zusername'] = (string)$list[$i]['nickname'];
			}
		}
		return $root;
	}
	//查询是否点赞
	public function is_Zan($userid,$workmateid){
			$Workmatereply = M("Workmatereply");
			$list = $Workmatereply->where("zuserid = '$userid' and workmateid = '$workmateid' and type=1")->limit(1)->select();
			if(empty($list)){
				return '0';
			}else{
				return '1';
			}
	}
}