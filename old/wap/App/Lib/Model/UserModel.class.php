<?php

class UserModel extends Model {
	  //获取用户的工种
	public function selectUserCraft($id){
		$query = D();
		$sql = "SELECT c.id,c.name,c.pid,c.status FROM zj_user as u 
				INNER JOIN zj_usercraft as uc
				ON u.id = uc.userid
				INNER JOIN zj_craft as c
				ON uc.craftid = c.id
				WHERE u.id = '$id' and c.status =1 group by c.id";
		$list = $query->query($sql);
		if(empty($list)){
			return array();
		}else{
			return $list;
		}
	}
	//查询该用户最后一次获取积分的时间
	//默认是登录
	public function getIntegralTime($id,$t ='3'){
		$query = D();
		$sql = "SELECT * FROM zj_integrallog WHERE userid = '$id' and status = '$t' order by id desc limit 1";
		$list = $query->query($sql);
		return $list['0'];
	}
	
	//环信注册
	public function huanxinRegister($hxname){
		import("ORG.Huanxin.Recson");
		//固定
		$options['client_id'] = 'YXA6t0o2oJpVEeW1DLXywiX-lw';
        $options['client_secret'] = 'YXA6eLIbiKUovCYcNGAZZlxk7zoORPk';
        $options['org_name'] = 'lihewangluo';
        $options['app_name'] = 'janzhu';
		$Easemob=new Easemob($options);
		$EasemobCount = $Easemob->openRegister(array("username"=>$hxname,"password"=>'JianZhu_5F3A64'));
		$EasemobCount = json_decode($EasemobCount,true);
		if(!empty($EasemobCount['duration'])){
		    return $hxname;
		}else{
			return '';
		}
	}
	//用户统计
	public function usert($id,$version,$terminal){
		$data['uid'] = $id;
		$data['addtime'] = time();
		$data['version'] = $version;
		$data['terminal'] = $terminal;
		$user = M('Usert');
		$user ->add($data);

	}
}