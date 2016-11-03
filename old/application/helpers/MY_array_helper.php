<?php

//读取文件
function read_file($l1){
	return @file_get_contents($l1);
}

//写入文件
function write_file($l1, $l2=''){
	$dir = dirname($l1);
	if(!is_dir($dir)){
		mkdirss($dir);
	}
	return @file_put_contents($l1, $l2);
}
//递归创建文件
function mkdirss($dirs,$mode=0777) {
	if(!is_dir($dirs)){
		mkdirss(dirname($dirs), $mode);
		return @mkdir($dirs, $mode);
	}
	return true;
}

//开始时间到结束时间中间的每一天开始结束时间
function starEnd($date,$end){
	$arr = array();
	for($i=0;strtotime($date.'+'.$i.' days')<=strtotime($end)&&$i<365;$i++){
		$time = strtotime($date.'+'.$i.' days');
		$arr[$i]['time'] = date('Y-m-d',$time);
		$arr[$i]['startime'] = strtotime($arr[$i]['time'].'00:00:00');
		$arr[$i]['endtime'] = strtotime($arr[$i]['time'].'23:59:59');
	}
	return $arr;
}

//是否活跃 用户活跃度 = (登录次数/((当前时间 - 最后一次登录时间)/86400)/N)*100%
function active($t,$z,$m){
		$d = strtotime(date('Y-m-d 23:59:59',time()));
		$m = ceil((($z+86400)-$m)/86400);
		$z = strtotime(date('Y-m-d',$z));
		$h = floor((($t/ceil(($d-$z)/86400))/$m)*100);
		if($h>=100){
			return 100;
		}
		return $h;

}
