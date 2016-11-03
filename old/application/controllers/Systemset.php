<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Systemset extends Adminin {
	// 导航页
	public function setGps(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setGps']);

		$data = $this->Public->is_sql_name('zj_gpsye',"1=1 limit 1");
		$this->load->view("admin/Systemset/setGps.html",$data);
	}
	public function setGpsPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setGps']);

		$str = '';
		for ($i=1; $i <= 5; $i++) {
			$str .= $this->Public->fileImg($_FILES['pic'.$i],$pics).',';
		}
		$data['pic'] = trim($str,',');
		$this->db->update('zj_gpsye',$data,"id = 1");
		success("修改成功！",site_url("/Systemset/setGps"),1);

	}
	//版本介绍
	public function setEdition(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setEdition']);

		if(!empty($_POST)){
			$data['versions'] = $this->input->post('versions',true);
			$data['download'] = $this->input->post('download',true);
			$this->db->update('zj_setsystem',$data,'id=1');
			$download=explode('#',$data['download']);
			include_once './application/libraries/phpqrcode/phpqrcode.php';
			QRcode::png($download[0], './resources/images/ios_qrcode.png','L',6);
			QRcode::png($download[1], './resources/images/and_qrcode.png','L',6);
		}
		$data = $this->Public->is_sql_name('zj_setsystem',"id = '1' limit 1");
		$this->load->view("admin/Systemset/setEdition.html",$data);


	}

	//意见反馈
	public function setFeedback(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setFeedback']);

		$segment=$this->uri->segment(3);
		$Sql = "SELECT * FROM zj_feedback order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data['url'] = 'Systemset/setFeedback';
		$this->load->view("admin/Systemset/setFeedback.html",$data);

	}
	public function setFeedbackEdit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setFeedback']);

		$id=$this->uri->segment(3);
		$data = $this->Public->is_sql_name('zj_feedback',"id = '$id' limit 1");
		if(empty($data)){
			error("该内容不存在！",site_url("/Systemset/setFeedback"),1);
		}else{
			$this->load->view("admin/Systemset/setFeedbackEdit.html",$data);
		}
	}
	public function setFeedbackPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setFeedback']);

		$id = $this->input->post('id');
		$content = $this->input->post('content');
		$data['text'] = $this->input->post('text');
		if($id){
			$this->db->update('zj_feedback',$data,"id = '$id'");
			$title = "【系统消息】您反馈的信息我们已经受理";
			$content = $content."\r\n  我们给您的回复：".$data['text'];
			$this->Public->informAdd($id,$title,$content);
		}
		success("回复成功！",site_url("/Systemset/setFeedback"),1);
	}
	public function setFeedbackDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setFeedback']);

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
				$this->Public->delImgAll("zj_feedback","id in($where)",'');
			}
			if(!empty($_POST['id'])){
				echo '1';
			}else{
				success("删除成功！",site_url("/Systemset/setFeedback"),1);
			}


	}
	//关于我们
	public function setAboutUs(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setAboutUs']);

		$data = $this->Public->is_sql_name('zj_aboutus',"id = '1' limit 1");
		$this->load->view("admin/Systemset/setAboutUs.html",$data);
	}
		//关于建筑
	public function setAboutBu(){
		$data = $this->Public->is_sql_name('zj_aboutus',"typeaboutus=2 limit 1");
		$this->load->view("admin/Systemset/setAboutBu.html",$data);
	}
	//法律声明
	public function setAboutFl(){
		$data = $this->Public->is_sql_name('zj_aboutus',"typeaboutus=3 limit 1");
		$data['typeaboutus1']='3';
		$this->load->view("admin/Systemset/setAboutBu.html",$data);
	}
	//服务条款
	public function setAboutFw(){
		$data = $this->Public->is_sql_name('zj_aboutus',"typeaboutus=4 limit 1");
		$data['typeaboutus1']='4';
		$this->load->view("admin/Systemset/setAboutBu.html",$data);
	}

	public function setAboutUsPost(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setAboutUs']);

		$data['content'] = $this->input->post('content',true);
		$data['moblie'] = $this->input->post('moblie',true);
		$data['username'] = $this->input->post('username',true);
		$data['mail'] = $this->input->post('mail',true);
		$data['weixin'] = $this->input->post('weixin',true);
		$data['address'] = $this->input->post('address',true);
		$typeaboutus1=$this->input->post('typeaboutus1',true);
		$data['c_time'] = time();
		if($_FILES['pic']){
		$data['pic'] = $this->Public->fileImg($_FILES['pic'],$pics);
		}
		if($typeaboutus1=="3"){
			$data['typeaboutus']=$this->input->post('typeaboutus1',true);
			$this->db->update('zj_aboutus',$data,"id = '3'");
		}elseif($typeaboutus1=="4"){
			$data['typeaboutus']=$this->input->post('typeaboutus1',true);
			$this->db->update('zj_aboutus',$data,"id = '4'");
		}else{
			$data['typeaboutus'] = $this->input->post('typeaboutus',true);
			if($data['typeaboutus']!=""){
				$this->db->update('zj_aboutus',$data,"id = '2'");
			}else{
				$this->db->update('zj_aboutus',$data,"id = '1'");
			}
		}
		//success("编辑成功！",site_url("/Systemset/setAboutUs"),1);
		exit("<script>alert('编辑成功');window.history.go(-1)</script>");
	}
	//协议设置
	public function setTreaty(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['setTreaty']);

		if(!empty($_POST)){
			$data['pourtreaty'] = $this->input->post('pourtreaty',true);
			$data['outtreaty'] = $this->input->post('outtreaty',true);
			$this->db->update('zj_setsystem',$data,'id=1');
		}
		$data = $this->Public->is_sql_name('zj_setsystem',"id = '1' limit 1");
		$this->load->view("admin/Systemset/setTreaty.html",$data);
	}
	//轮播图
	public function ad(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['ad']);
		$segment=$this->uri->segment(3);
		$Sql = "SELECT * FROM zj_liad  order by sort desc";
		$data = $this->Public->pageList($Sql,$segment);
		$this->load->view("admin/Systemset/ad.html",$data);

	}
	//添加轮播图
	public function addad(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['ad']);
		$this->load->view("admin/Systemset/addad.html",$data);
	}
	public function adedit(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Systemset']['ad']);
		$id=$this->uri->segment(3);
		$data = $this->Public->is_sql_name('zj_liad',"id="."$id limit 1");
		$this->load->view("admin/Systemset/addad.html",$data);
	}
	public function insert(){
		if($_FILES['imageurl']['error']==0){
			$str= $this->Public->fileImg($_FILES['imageurl'],$pics);
		}
		$adid = $this->input->post('adid');
		$sort = $this->input->post('sort');
		$url = $this->input->post('url');
		$title = $this->input->post('title');
		$data['title'] = $title;
		$data['url'] =$url ;
		$data['sort'] = $sort;
		if($str!=null){
			$data['imgurl'] = $str;
		}
		$data['addtime']=time();
		if($adid>0){
			$id=$this->db->update('zj_liad',$data,"id=".$adid);
		}else{
			$id=$this->db->insert('zj_liad',$data);
		}
		if($id){
			success("添加成功！",site_url("/Systemset/ad"),1);
		}else{
			exit("<script>alert('添加失败');window.history.go(-1)</script>");
		}
	}
	public function addelect(){
		$id=$this->uri->segment(3);
		$row = $this->Public->is_sql_name('zj_liad',"id = '".$id."' limit 1");
		$data = $this->Public->delImgAll('zj_liad',"id = '".$id."'",$imgpic=array("pic"));
		if($data){
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$row['imgurl'])){
				unlink($_SERVER['DOCUMENT_ROOT'].$row['imgurl']);
			}
			success("删除成功！",site_url("/Systemset/ad"),1);
		}else{
			exit("<script>alert('失败');window.history.go(-1)</script>");
		}
	}
	//删除所有
	public function deleallad(){
		$idall = $this->input->post('noticeid');
		foreach( $idall as $key => $value ){
			$row = $this->Public->is_sql_name('zj_liad',"id = '".$value."' limit 1");
			$data = $this->Public->delImgAll('zj_liad',"id = '".$value."'",$imgpic=array("pic"));
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$row['imgurl'])){
				unlink($_SERVER['DOCUMENT_ROOT'].$row['imgurl']);
			}
		}
		if($data){
			success("删除成功！",site_url("/Systemset/ad"),1);
		}else{
			exit("<script>alert('失败');window.history.go(-1)</script>");
		}
	}
	//修改管理员密码
	public function editAdmin(){
		//权限
		$data = $this->Public->is_sql_name('zj_admin',"id = '1' limit 1");
		$this->load->view("admin/Systemset/editAdmin.html",$data);
	}

	//添加用户
	public function postAdmin(){

		if(!empty($_POST)){
			$data['password'] = md5($this->input->post('password',true));
			$this->db->update('zj_admin',$data,'id=1');
		}
		success("修改成功！",site_url("/Systemset/editAdmin"),1);
	}
}
