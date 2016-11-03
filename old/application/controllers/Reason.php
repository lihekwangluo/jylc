<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Reason extends Adminin {

	public function reasonList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Reason']['reasonList']);

		$segment=$this->uri->segment(3);
		$Sql = "SELECT r.*,p.title,u.name FROM zj_reason as r
				INNER JOIN zj_user as u 
				ON r.userid = u.id
				INNER JOIN zj_publish as p
				ON r.publishid = p.id
				group by r.id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data['url'] = 'Reason/reasonList';
		$this->load->view("admin/Reason/reasonList.html",$data);
		
	}

	public function reasonEdit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Reason']['reasonList']);

		$id=$this->uri->segment(3);
		$sql = "SELECT r.*,p.title,u.name FROM zj_reason as r
				INNER JOIN zj_user as u 
				ON r.userid = u.id
				INNER JOIN zj_publish as p
				ON r.publishid = p.id
				where r.id = '$id'
				group by r.id desc limit 1";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		if(empty($data)){
			error("该内容不存在！",site_url("/Reason/reasonList"),1);
		}else{
			$this->load->view("admin/Reason/reasonEdit.html",$data);
		}
	}

	public function reasonPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Reason']['reasonList']);

		$id = $this->input->post('id');
		$content = $this->input->post('content');
		$data['reply'] = $this->input->post('reply');
		$data['replytime'] = time();
		if($id){
			$this->db->update('zj_reason',$data,"id='$id'");
			$title = "【系统消息】您举报的信息我们已经受理";
			$content = $content."\r\n  我们给您的回复：".$data['reply'];
			$this->Public->informAdd($id,$title,$content);
		}
		success("回复成功！",site_url("/Reason/reasonList"),1);
	}

	public function reasonDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Reason']['reasonList']);
		
		$where = '';
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
				$this->Public->delImgAll("zj_reason","id in($where)",'');
			}
			if(!empty($_POST['id'])){
				echo '1';
			}else{
				success("删除成功！",site_url("/Reason/reasonList"),1);
			}
		
		
	}

}