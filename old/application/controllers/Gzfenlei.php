<?php
//分类
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Gzfenlei extends Adminin {
	//工种
	public function GzfenleiList(){

		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['GzfenleiList']);
			
			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_craft order by id desc ";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Gzfenlei/GzfenleiList';
			$this->load->view("admin/Gzfenlei/GzfenleiList.html",$data);
	}

	public function GzfenleiDeit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['GzfenleiDeit']);
			
			$id = $this->uri->segment(3);
			$data = $this->Public->is_sql_name('zj_craft',"id = '$id' limit 1");
			$this->load->view("admin/Gzfenlei/GzfenleiDeit.html",$data);
	}

	public function GzfenleiPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['GzfenleiDeit']);
		
			$id = $this->input->post('id',true);
			$data['name'] = $this->input->post('name',true);
			$data['status'] = $this->input->post('status',true);
			if($id){
				$this->db->update('zj_craft',$data,"id = '$id'");
			}else{
				$this->db->insert('zj_craft',$data);
			}
			success("编辑成功！",site_url("/Gzfenlei/GzfenleiList"),1);
	}
	public function GzfenleiDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['GzfenleiList']);
			
			$id = $this->uri->segment(3);
			$this->db->delete('zj_craft',"id='$id'");
			success("删除成功！",site_url("/Gzfenlei/GzfenleiList"),1);
	}
	//设备
	public function deviceList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['deviceList']);
			
			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_device order by id desc ";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Gzfenlei/deviceList';
			$this->load->view("admin/Gzfenlei/deviceList.html",$data);

	}

	public function deviceDeit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['deviceDeit']);

			$id = $this->uri->segment(3);
			$data = $this->Public->is_sql_name('zj_device',"id = '$id' limit 1");
			$this->load->view("admin/Gzfenlei/deviceDeit.html",$data);
	}


	public function devicePost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['deviceDeit']);

			$id = $this->input->post('id',true);
			$data['name'] = $this->input->post('name',true);
			$data['status'] = $this->input->post('status',true);
			if($id){
				$this->db->update('zj_device',$data,"id = '$id'");
			}else{
				$this->db->insert('zj_device',$data);
			}
			success("编辑成功！",site_url("/Gzfenlei/deviceList"),1);
	}

	public function deviceDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['deviceList']);
			
			$id = $this->uri->segment(3);
			$this->db->delete('zj_device',"id='$id'");
			success("删除成功！",site_url("/Gzfenlei/deviceList"),1);

	}
	//项目类型
	public function moldList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['moldList']);
		
			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_mold order by id desc ";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Gzfenlei/moldList';
			$this->load->view("admin/Gzfenlei/moldList.html",$data);

	}

	public function moldDeit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['moldDeit']);

			$id = $this->uri->segment(3);
			$data = $this->Public->is_sql_name('zj_mold',"id = '$id' limit 1");
			$this->load->view("admin/Gzfenlei/moldDeit.html",$data);
	}


	public function moldPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['moldDeit']);

			$id = $this->input->post('id',true);
			$data['name'] = $this->input->post('name',true);
			$data['status'] = $this->input->post('status',true);
			if($id){
				$this->db->update('zj_mold',$data,"id = '$id'");
			}else{
				$this->db->insert('zj_mold',$data);
			}
			success("编辑成功！",site_url("/Gzfenlei/moldList"),1);
	}

	public function moldDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['moldList']);

			$id = $this->uri->segment(3);
			$this->db->delete('zj_mold',"id='$id'");
			success("删除成功！",site_url("/Gzfenlei/moldList"),1);

	}
	//店铺分类
	public function alcorList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['alcorList']);

			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_alcor order by id desc ";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Gzfenlei/alcorList';
			$this->load->view("admin/Gzfenlei/alcorList.html",$data);

	}

	public function alcorDeit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['alcorDeit']);
			$id = $this->uri->segment(3);
			$data = $this->Public->is_sql_name('zj_alcor',"id = '$id' limit 1");
			$this->load->view("admin/Gzfenlei/alcorDeit.html",$data);
	}


	public function alcorPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['alcorDeit']);
			$id = $this->input->post('id',true);
			$data['name'] = $this->input->post('name',true);
			$data['ptype'] = $this->input->post('ptype',true);
			$data['status'] = $this->input->post('status',true);
			if($id){
				$this->db->update('zj_alcor',$data,"id = '$id'");
			}else{
				$this->db->insert('zj_alcor',$data);
			}
			success("编辑成功！",site_url("/Gzfenlei/alcorList"),1);
	}

	public function alcorDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Gzfenlei']['alcorList']);
			$id = $this->uri->segment(3);
			$this->db->delete('zj_alcor',"id='$id'");
			success("删除成功！",site_url("/Gzfenlei/alcorList"),1);

	}

}