<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Integral extends Adminin {
	//积分商品
	public function product(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['product']);

		$segment=$this->uri->segment(3);
		$Sql = "SELECT * FROM zj_product  order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data['url'] = 'Integral/product';
		$this->load->view("admin/Integral/product.html",$data);
	}

	public function productPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['productAdd']);

		$data['title'] = $this->input->post('title',true);
		$data['integral'] = $this->input->post('integral',true);
		$data['content'] = $this->input->post('content',true);
		$data['num'] = $this->input->post('num',true);
		$data['snum'] = $this->input->post('snum',true)?$this->input->post('snum',true):$this->input->post('num',true);
		$id = $this->input->post('id',true);
		$pics = $this->input->post('pics',true);
		$data['pic'] = $this->Public->fileImg($_FILES['pic'],$pics);
		if($id>0){
			$this->db->update('zj_product',$data,"id='$id'");
		}else{
			$data['addtime'] = time();
			$this->db->insert('zj_product',$data);
			
		}
		success("编辑成功！",site_url("/Integral/product"),1);
	}

	//积分商品添加
	public function productAdd(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['productAdd']);

		$id=$this->uri->segment(3);
		$data = array();
		if($id>0){
			$data = $this->Public->is_sql_name('zj_product',"id='$id'");
		}
		$this->load->view("admin/Integral/productAdd.html",$data);

	}
	public function productDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['product']);

		$id=$this->uri->segment(3);
		$arrImg = array('pic');
		$this->Public->delImgAll("zj_product","id ='$id'",$arrImg);
		success("删除成功！",site_url("/Integral/product"),1);
	}
	//兑换人列表
	public function integralLog(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['integralLog']);
		
			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_integrallog WHERE status=4 and sendout !=0 order by id desc";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Integral/integralLog';
			$this->load->view("admin/Integral/integralLog.html",$data);
	}
	public function integralLogDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['integralLog']);

		$where = '';
		$type = $_POST['type']?$_POST['type']:$_GET['type'];
		if(!empty($_POST['id'])){
			$pid = explode(',', trim($_POST['id'],','));
			foreach ($pid as $key => $value) {
				$where .= "'".$value."',";
			}

		}else{
			$id = intval($this->uri->segment(3));
			$where = "'$id'";
		}			
			if(!empty($where)){
				$where = trim($where,',');
				if($type == 'zhuangtai'){
					$set = " sendout = 2 ";
					$where2 = " sendout = 1 and ";
				}else{
					$set = " sendout = 0 ";
				}
				$sql = "update zj_integrallog set $set where $where2 status = 4 and id in($where)";
				$this->db->query($sql);
			}
			if(!empty($_POST['id'])){
				echo '1';
			}else{
				success("操作成功！",site_url("/Integral/integralLog"),1);
			}
	}
	//积分设置
	public function integralSet(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['integralSet']);
		
		$data = $this->Public->is_sql_name('zj_setintegral');
		$this->load->view("admin/Integral/integralSet.html",$data);

	}
	public function integralSetPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Integral']['integralSet']);
		
		$data['invitation'] = $this->input->post('invitation',true);
		$data['register'] = $this->input->post('register',true);
		$data['login'] = $this->input->post('login',true);
		$data['content'] = $this->input->post('content',true);
		$this->db->update('setintegral',$data,"id='1'");
		success("设置成功！",site_url("/Integral/integralSet"),1);
	}
}