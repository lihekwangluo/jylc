<?php

class DemandModel extends Model {
	  
	//去除敏感字
	public function publishTime($uid){
		$Publish = M('Publish');
		$Setsystem = M('Setsystem');
		$list = $Setsystem -> where('id = 1')->limit(1)->select();
		$Publish = $Publish -> where("userid = '$uid'")->order('id desc')->limit(1)->select();
		$time = $Publish['0']['addtime'] + $list['0']['addtime'];
		if($time > time()){
			return false;
		}else{
			return true;
		}
		
	}
}