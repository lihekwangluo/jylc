<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lilogin extends CI_Controller {
	function __construct(){
			@session_start();
			parent::__construct();
			$this->load->helper('url'); //url加载辅助函数
			$this->load->database(); //数据库类
	}
	public function login(){
		$this->load->view("home/login/login.html");
	}
	public function sub(){
		$username = $this->input->post('uname',true);
		$password = md5($this->input->post('password',true));
		if(is_numeric($username)){
			$sql = "SELECT id,name,mobile FROM zj_user where mobile = '$username' and pass = '$password'";
		}else{
			$sql = "SELECT id,name,mobile FROM zj_user where nickname = '$username' and pass = '$password'";
		}
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			$array=$query->row_array();
			$_SESSION["admin_author"]['admin_id']=$array['id'];
			$_SESSION["admin_author"]['admin_username']=$array['name'];
			$_SESSION["admin_author"]['admin_mobile']=$array['mobile'];
			$_SESSION["admin_author"]['admin_status']='1';
			header("location:".site_url("Index/index"));
		}else{
			exit("<script>alert('账号或密码错误');window.history.go(-1)</script>");
		}

	}

	public function logout(){
			unset($_SESSION["admin_author"]['admin_id']);
			unset($_SESSION["admin_author"]['admin_username']);
			unset($_SESSION["admin_author"]['admin_status']);
			header("location:".site_url("admin/login"));
		}
	public function register(){
		$this->load->view("home/login/zhuce.html");
	}
	public function submint(){
		$mobile=$this->input->post("mobile");
		$password=$this->input->post("password");
		$pass=$this->input->post("pass");
		$invitation=$this->input->post("invitation");
		$xoopscaptcha=$this->input->post("xoopscaptcha");
		if($password===$pass){
			$data = array(
	       'mobile' => $mobile,
	       'pass' => $password,
	     );
			$id=$this->db->insert('zj_user', $data);
			if(!empty($id)){
				//注册环信
				$this->load->model("LInvitecode_model",'LInvitecode');
				$hxname=$this->LInvitecode->huanxinRegister('Janzhu_'.$id);
				var_dump($hxname);
				die();
				if(!empty($hxname)){
					$Hxdata['hxname'] = $hxname;
					$this->db->update("zj_user","id='".$id."'");
					$this->LInvitecode->invitecode2($id);
				}else{
					$this->db->delete("zj_user","id='".$id."'");
					exit("<script>alert('注册失败');window.history.go(-1)</script>");
				}
				$log = array();
				$log['userid'] = $id;
				$log['content'] = '新用户注册';
				$log['zhuangtai'] = 1;
				$log['status'] = 2;
				$this->LInvitecode->integrallog($log,'1');
				if(!empty($invitation)){
					$sql="select * from `zj_invitecode` where code='".$invitation."'";
					$query=$this->db->query($sql);
					$invitationid=$query->row_array();
					if($invitationid){
						$log = array();
						$log['userid'] = $list['0']['userid'];
						$log['content'] = '邀请注册';
						$log['zhuangtai'] = 1;
						$log['status'] = 1;
						$this->User_Model->integrallog($log,'1');
					}else{
						exit("<script>alert('邀请码不存在');window.history.go(-1)</script>");
					}
				}
			}else{
				//exit("<script>alert('注册失败');window.history.go(-1)</script>");
				show_error('注册失败1',500);
			}
		}else{
			exit("<script>alert('两次输入的密码不一致');window.history.go(-1)</script>");
		}
	}
}
