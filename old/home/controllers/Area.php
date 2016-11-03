<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Area extends Indexinit {
	public function index(){
		$query['data'] = $this->db->query("select * from `zj_area` where area_parent_id=0 order by area_s asc");
		$this->load->view("home/chengshi.html",$query);
	}
}
