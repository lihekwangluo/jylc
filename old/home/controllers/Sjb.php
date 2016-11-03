<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Sjb extends Indexinit {
	public function index(){
		$this->load->view("home/sjb.html");
	}
}
