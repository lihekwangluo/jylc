<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Inform extends Adminin {

	//推送信息
	public function informPush(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Inform']['informPush']);
			
		$this->load->view("admin/Inform/informPush.html",$data);
	}
	public function PushAjax(){
		//权限

		$title = $this->input->post('title',true);
		$content = $this->input->post('content',true);
		if($title){
			require_once($_SERVER['DOCUMENT_ROOT'] .'/resources/tuisong/demo.php');  //加载模板类
//			$query = $this->Public->is_sql_name('zj_user',"cidtoken !='' ",'1','cidtoken');
//			foreach($query->result_array() as $array){
//				$demo_cid = $array['cidtoken'];
//
//			}
			pushMessageToApp($title,$content);
			$this->load->view("admin/Inform/informPush.html");
		}
	}


	//短信推送
	public function informBrief(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Inform']['informBrief']);

		$this->load->view("admin/Inform/informBrief.html",$data);
	}
	public function BriefAjax(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Inform']['informBrief']);
		
		$mobile = $this->input->post('tel',true);
		$content = $this->input->post('content',true);
		if($mobile && $content){
			echo  $this->Public->ChuanglanSmsHelper($mobile,$content);
		}else{
			echo false;
		}
	}
}