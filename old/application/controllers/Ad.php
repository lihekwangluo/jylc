<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Ad extends Adminin {
	//权限
	public function index(){
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Ad']['index']);
	}
}



$act = trim($_REQUEST['act']);

// 显示列表
if ($act=='' or $act=='list') {
	//print_r($_SESSION);

	$smarty->assign("username",$_SESSION['username']);
	$smarty->assign("admin_title",$config['adminname']);
	$smarty->assign("filename",$filename);
	$smarty->assign("flag72","class='current'");
	$sid		= trim ( isset($_GET ['sid']) ) ? trim ( $_GET ['sid'] ) : 0;
	$keywords 		= trim($_GET['keywords']);
	$page 			= isset($_GET ['page']) ? $_GET ['page'] : 1;
	$page_size 		= 10;
	$where=" ";
	$sql_string = "select * from `ai_ad` order by `sort` asc";
	$total_nums = $db->getRowsNum ( $sql_string );
	$mpurl 	= "index.php?ctrl=circle&sid=" . $id."&keywords=".$keywords."&page=".$page;
	$member_list = $db->selectLimit ( $sql_string, $page_size, ($page - 1) * $page_size );
	$smarty->assign('pages',multi ( $total_nums, $page_size, $page, $mpurl, 0, 10 ));
	foreach( $member_list as $key => $value ){
		# code...
		$member_list[$key]['sheng']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$value['region_p']."'");
	  $member_list[$key]['shi']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$value['region_s']."'");
	  $member_list[$key]['qu']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$value['region_q']."'");
	}
	$smarty->assign('myArray', $member_list);
	if (isset($_SESSION['userid'])){
		$smarty->display('ad.html');
	}else{
		$smarty->display('login.html');
	}
}elseif($act=='add'){
	//省市联动
	//$province = $db->getList("select * from ai_delivery where pid = 0");
	//$smarty->assign('province',$province);
	//赋值---开始
	$smarty->assign('act', "insert");
	$smarty->assign('actname', "添加");
	$smarty->assign("username",$_SESSION['username']);
	$smarty->assign("admin_title",$config['adminname']);
	$smarty->assign("flag71","class='current'");
	//-----结束
	if (isset($_SESSION['userid'])){
		$smarty->display('ad.add.html');
	}else{
		$smarty->display('login.html');
	}
}elseif($act=="insert"){
	//添加公告信息
	require AT_ROOT."/include/recson.php";
	$imgurl=upload_form($_FILES["imageurl"],$result);
	if($result=="success"){
		$_array=array(
			"region_s"=>$_REQUEST['shi'],
			"region_p"=>$_REQUEST['sheng'],
			"region_q"=>$_REQUEST['qu'],
			"title"=>$_REQUEST["title"],
			"imgurl"=>$imgurl,
			"sort"=>$_REQUEST["sort"],
			"url"=>$_REQUEST["url"],
			"pubtime"=>time(),
		);
		$db->insert("ai_ad",$_array);
		success('index.php?ctrl=ad');
	}else{
		exit("<script>alert('失败');window.history.go(-1)</script>");
	}
}elseif($act=="edit"){
	$result=$db->getOneRow("select * from `ai_ad` where `id`='".$_GET["id"]."'");
	$result['sheng']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$result['region_p']."'");
  $result['shi']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$result['region_s']."'");
  $result['qu']=$db->getOneRow("select `name`,`id` from `ai_delivery` where `id`='".$result['region_q']."'");
	$smarty->assign("flag71","class='current'");
	$results=$db->getOneRow("select * from `ai_ad` where `id`='".$_REQUEST["id"]."'");
	$smarty->assign("myArray",$results);
	$smarty->assign("row",$result);
	if (isset($_SESSION['userid'])){
		$smarty->display('ad.edit.html');
	}else{
		$smarty->display('login.html');
	}
}elseif($act=="update"){
	require AT_ROOT."/include/recson.php";
	$imgurl=upload_form($_FILES["imageurl"],$result,array("rename"=>$_REQUEST["tupian"],"upload"=>false));
	if($result=="success"){
		$_array=array(
			"region_s"=>$_REQUEST['shi'],
			"region_p"=>$_REQUEST['sheng'],
			"region_q"=>$_REQUEST['qu'],
			"title"=>$_REQUEST["title"],
			"imgurl"=>$imgurl,
			"sort"=>$_REQUEST["sort"],
			"url"=>$_REQUEST["url"],
			"pubtime"=>time(),
		);
		$db->update("ai_ad",$_array,"`id`='".$_REQUEST["id"]."'");
		success('index.php?ctrl=ad');
	}else{
		exit("<script>alert('".$imgurl."');window.history.go(-1)</script>");
	}
}elseif($act=="delete"){
	$id = $_GET['id'];
	$db->query("delete from `ai_ad` where `id`='$id'");
	@unlink(AT_ROOT."/".$_GET["pic"]);
	success('index.php?ctrl=ad');
}elseif($act=="deleteall"){
	$notice=$_POST["noticeid"];
	for($i=0;$i<count($notice);$i++){
		$arr=explode("|",$notice[$i]);
		$sql="delete from `ai_ad` where `id`='".$arr[0]."'";
		$db->query($sql);
		@unlink(AT_ROOT."/".$arr[1]);
	}
	success('index.php?ctrl=ad');
}
