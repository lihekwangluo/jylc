<?php

class Adminin extends CI_Controller {
	public $admin_id="";
	public $admin_username="";
	public $admin_status=""; //1 是管理员
	function __construct(){
			@session_start();
			parent::__construct();

			//加载公用模块

		if(!empty($_SESSION["admin_author"]['admin_id']) && !empty($_SESSION["admin_author"]['admin_username']) && !empty($_SESSION["admin_author"]['admin_status'])){

			$this->admin_id=$_SESSION["admin_author"]['admin_id'];
			$this->admin_username=$_SESSION["admin_author"]['admin_username'];
			$this->admin_status=$_SESSION["admin_author"]['admin_status'];
			$this->load->helper('url'); //url加载辅助函数
			$this->load->database(); //数据库类
			$this->load->model('Public_model','Public'); //公用model
			$this->load->helper('array');//加载函数

		}else{
			echo "<script>alert('请登录？');location.href='/admin.php/admin/login'</script>";
		}

	}

}


?>
