<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		require "Adminin.php";
class Welcome extends Adminin {
	public function index(){
		$this->load->view("admin/welcome/index.html");
	}
}