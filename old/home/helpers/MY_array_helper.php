<?php


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

function inviteCode($id){
    return chr(rand(97, 122)).chr(rand(97, 122)).rand(100,999).chr(rand(97, 122)).chr(rand(97, 122)).$id;
}

function ajaxmsg($status,$message,$info=''){
    return exit(json_encode(array("status"=>$status,"message"=>$message,"info"=>$info)));
}