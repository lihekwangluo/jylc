<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class User extends Adminin {
	// 用户查看
	public function UserList(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserList']);

		$where = ' 1=1 ';
		$soso = $this->input->get('soso',true);
		$type = $this->input->get('type',true);
		$startime = $this->input->get('startime',true);
		$endtime = $this->input->get('endtime',true);
		$mobile = $this->input->get('mobile',true);
		$renzheng = $this->input->get('renzheng',true);
		if($soso){
			$where .= " and name like '%".$soso."%'";
		}
		if($type){
			$where .= " and type='".$type."'";
		}
		if($startime && $endtime){
			if(strtotime($startime) < strtotime($endtime)){
				$where .= " and addtime > '".strtotime($startime)."' and addtime < '".strtotime($endtime)."'";
			}

		}
		if($mobile){
			$where .= " and mobile='".$mobile."'";
		}

		if($renzheng==='0'){
			$where .= " and idcard='' and renzheng=0 ";
		}elseif($renzheng=='3'){
			$where .= " and idcard!='' and renzheng=0 ";
		}elseif($renzheng=='4' || $renzheng==''){

		}else{
			$where .= " and renzheng='".$renzheng."' " ;
		}
		$where .= " and id != 0 ";

		$segment=$this->uri->segment(3);
		$Sql = "SELECT * FROM zj_user WHERE ".$where." order by id desc";


		$data = $this->Public->pageList($Sql,$segment);
		$data['url'] = 'User/UserList';
		$data['get'] = "soso=$soso&startime=$startime&endtime=$endtime&type=$type&mobile=$mobile&renzheng=$renzheng";//参数
		$data['soso'] = $soso;
		$data['startime'] = $startime;
		$data['endtime'] = $endtime;
		$data['type'] = $type;
		$data['mobile'] = $mobile;
		$data['renzheng'] = $renzheng;


		$this->load->view("admin/User/UserList.html",$data);

	}
	//添加用户
	public function UserAdd(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserAdd']);

			$id=$this->uri->segment(3);
			if($id){
				$data = $this->Public->is_sql_name('zj_user',"id = '$id' limit 1");
			}
			$this->load->view("admin/User/UserAdd.html",$data);
	}
	//提交数据
	public function UserPost(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserAdd']);

			$id=$this->input->post('id');
			$mobile=$this->input->post('mobile');
			$passd=md5($this->input->post('passd'));

			if($passd){
				$data['pass']	= $passd;
			}

			if($id){
				$mo = $this->Public->is_sql_name('zj_user',"mobile = '$mobile' limit 1");
				if(empty($mo)){
					$data['mobile']	= $mobile;
				}else{
					error("手机号已存在！",site_url("/User/UserList"),1);
					exit;
				}
			}else{

				$mo = $this->Public->is_sql_name('zj_user',"mobile = '$mobile' limit 1");
				if(empty($mo)){
					$data['mobile']	= $mobile;
				}else{
					error("手机号已存在！",site_url("/User/UserList"),1);
					exit;
				}
				$data['addtime']	= time();
				$data['integral'] = 0;
				$this->db->insert('zj_user',$data);
				$user=$this->Public->is_sql_name('zj_user',"mobile = '$mobile' limit 1");
				$id=$user['id'];
				/*$hxname = $this->Public->huanxinRegister('Janzhu_'.$id);

				if(!empty($hxname)){
					$hxdata['hxname'] = $hxname;
					$this->db->update('zj_user',$hxdata,"id = '$id'");
					success("添加成功！",site_url("/User/UserAdd/$id"),1);
				}else{
					$this->db->delete('zj_user',"id = '$id'");
					success("聊天系统注册失败！",site_url("/User/UserAdd/$id"),1);
				}*/

				if(!empty($id)){
					success("注册成功！",site_url("/User/UserAdd/$id"),1);
				}else{
					success("注册失败！",site_url("/User/UserAdd/$id"),1);
				}
			}

	}
	//删除用户
	public function userDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserList']);

		$id=$this->uri->segment(3);
		$imgArr=array('pic','enterprisepic','cardzpic','cardfpic');
		//删除用户主表
		$this->Public->delImgAll('zj_user',"id = '$id'",$imgArr);

		//删除好友关系
		$this->db->delete('zj_friend',"zuserid = '$id'");
		$this->db->delete('zj_friend',"fuserid = '$id'");
		//删除环信账户
		$this->Public->huanxinDel('Janzhu_'.$id);

		success("删除成功！",site_url("/User/UserList"),1);
	}
	//查看用户
	public function userLook(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserList']);

		$id=$this->uri->segment(3);
		$data = $this->Public->is_sql_name('zj_user',"id = '$id' limit 1");
		$this->load->view("admin/User/userLook.html",$data);
	}
	//认证用户
	public function userRenzheng(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['User']['UserList']);

		$renzheng = $this->input->post('renzheng',true);
		$rterrace = $this->input->post('rterrace',true);
		$id = $this->input->post('id',true);
		if($renzheng){
			$data['renzheng'] = $renzheng;
			$title = "【系统消息】您认证信息";
			if($renzheng == 0){
				$title .= "未通过审核";
				$content = "您的认证信息未通过，请检查上传认证图片！";
			}else{
				$title .= "已通过审核";
				$content = "您认证信息已经通过认证，谢谢支持！";
			}
		}else{
			$data['rterrace'] = $rterrace;
			$title = "【系统消息】您发布的辅材信息";
			if($rterrace == 1){
				$title .= "未通过审核";
				$publishData['zhuangtai'] = 0;
				$content = "您的发布未通过，请检查上传认证图片！";
			}elseif($rterrace == 2){
				$title .= "已通过审核";
				$publishData['zhuangtai'] = 1;
				$content = "您的发布已经通过认证，您可以发布更多的辅材信息！";
			}else{
				$title .= "正在审核中";
				$publishData['zhuangtai'] = 0;
				$content = "您的发布正处于审核中...";
			}
			$this->db->update('zj_publish',$publishData,"userid = '$id'");
		}
		$this->Public->informAdd($id,$title,$content);

		if($id){
			$this->db->update('zj_user',$data,"id = '$id'");
		}
	}

	//查询未审核用户
	public function check(){
		$arr=$this->Public->is_sql_name('zj_user',"renzheng='3'",'shenhe');	
		if($arr){
			$length=count($arr);
			echo $length;
		}else{
			echo '空';
		}		
	}
}