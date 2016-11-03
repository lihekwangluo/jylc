<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Manage extends Adminin {
	//管理员列表
	public function manageList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Manage']['manageList']);

		$data['query'] = $this->Public->is_sql_name('zj_admin','','1');
		$this->load->view("admin/Manage/manageList.html",$data);
	}
	//管理员编辑
	public function manageEdit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Manage']['manageList']);

		$data = array();
		$id = $this->uri->segment(3);
		if($id){
			$data = $this->Public->is_sql_name('zj_admin',"id= '$id'");
		}
		$this->load->view("admin/Manage/manageEdit.html",$data);
	}
	//管理员数据提交
	public function managePost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Manage']['manageList']);

		$id = $this->input->post('id',true);
		$data['name'] = $this->input->post('name',true);
		$data['password'] = md5($this->input->post('password',true));
		if($data['name'] && $data['password']){
			
			if($id){
				$this->db->update('zj_admin',$data,"id='$id'");
			}else{
				$cont = $this->Public->is_sql_name('zj_admin',"name = '".$data['name']."' limit 1");
				if(empty($cont)){
					$data['addtime'] = time();
					$this->db->insert('zj_admin',$data);
				}else{
					error($data['name']." 管理员已存在！",site_url("/Manage/manageList"),3);
					return;
				}
			}
			success("操作成功！",site_url("/Manage/manageList"),3);
			
		}else{
			error("参数不全，非法提交！",site_url("/Manage/manageList"),3);
		}

	}
	//管理员删除
	public function manageDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Manage']['manageList']);

		$id = $this->uri->segment(3);
		if($id){
			$this->db->delete('zj_admin',"id = '$id'");
			success("操作成功！",site_url("/Manage/manageList"),3);
		}else{
			error("操作失败！",site_url("/Manage/manageList"),3);
		}

	}
	//管理员权限
	public function managePower(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Manage']['manageList']);
		
		$id = $this->uri->segment(3);
		$menu = $this->input->post('menu',true);
		$datt['text'] = json_encode($menu);

		
		if(!empty($id) && !empty($_POST['menu'])){

			$this->db->update('zj_admin',$datt,"id='$id'");
			$_SESSION["num_JSONPOWER_arr"] = array();
			$t = json_decode($datt['text'],true);
			$_SESSION["num_JSONPOWER_arr"] = $t;
		}
		$data = $this->Public->is_sql_name('zj_admin',"id= '$id'");

		$this->load->view("admin/Manage/managePower.html",$data);
	}
}