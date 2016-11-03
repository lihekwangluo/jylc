<?php
class Index extends CI_Controller {
		function __construct(){
			@session_start();
			parent::__construct();
			$this->load->helper('url'); //url加载辅助函数
			$this->load->database(); //数据库类
	}
}
