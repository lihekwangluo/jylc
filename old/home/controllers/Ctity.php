<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Ctity extends Indexinit {
			//读取城市列表
	$sheng=$_POST["sheng"];
	$result=$this->selectRow("zj_area","pid='".$sheng."'",false);
	$smarty->assign('result',$result);
	//-----结束
    if (isset($_SESSION['userid'])){
        $smarty->display('region.ajax.city.html');
    }else{
        $smarty->display('login.html');
    }
}
?>
