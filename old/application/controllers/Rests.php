<?php
//其他
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Rests extends Adminin {
	
	//刷帖设置
	public function brushpost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Rests']['brushpost']);

		if($_POST){
			$data['addtime'] = $this->input->post('addtime',true);
			$this->db->update('zj_setsystem',$data,'id=1');
		}
		$data = $this->Public->is_sql_name('zj_setsystem','id=1 limit 1');
		$this->load->view("admin/Rests/brushpost.html",$data);

	}
	//敏感字
	public function sensitivity(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Rests']['sensitivity']);
		
		if($_POST){
			$data['sensitivity'] = $this->input->post('sensitivity',true);
			$this->db->update('zj_setsystem',$data,'id=1');
		}
		$data = $this->Public->is_sql_name('zj_setsystem','id=1 limit 1');
		$this->load->view("admin/Rests/sensitivity.html",$data);
	}
}