<?php
//工友圈
defined('BASEPATH') OR exit('No direct script access allowed');
		require "Adminin.php";
class Workmate extends Adminin {

	//工友圈列表
	public function WorkmateList(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateList']);

			$where = ' 1=1 ';
			$soso = $this->input->get('soso',true);
			$startime = $this->input->get('startime',true);
			$endtime = $this->input->get('endtime',true);

			if($soso){
				$where .= " and u.name like '%".$soso."%'";
			}
			if($startime && $endtime){
				if(strtotime($startime) < strtotime($endtime)){
					$where .= " and w.addtime > '".strtotime($startime)."' and w.addtime < '".strtotime($endtime)."'";
				}

			}
			$segment=$this->uri->segment(3);
			$Sql = "SELECT w.id,w.userid,w.title,w.pic,w.address,w.addtime,w.status,u.name FROM zj_workmate as w
					LEFT JOIN zj_user as u
					ON u.id = w.userid
					WHERE ".$where." group by w.id desc";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Workmate/WorkmateList';
			$data['get'] = "soso=$soso&startime=$startime&endtime=$endtime";//参数
			$data['soso'] = $soso;
			$data['startime'] = $startime;
			$data['endtime'] = $endtime;

			$this->load->view("admin/Workmate/WorkmateList.html",$data);
	}

	//查看
	public function WorkmateLook(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateList']);

			$id=$this->uri->segment(3);
			if(!empty($id)){
				$sql = "SELECT w.id,w.userid,w.content,w.pic,w.address,w.addtime,w.status,u.name FROM zj_workmate as w
				LEFT JOIN zj_user as u
				ON u.id = w.userid
				WHERE w.id = '$id' group by w.id desc limit 1";
				$query = $this->db->query($sql);
				$data = $query->row_array();
			}

			$this->load->view("admin/Workmate/WorkmateLook.html",$data);
	}
	//删除
	public function WorkmateDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateList']);

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
				$this->Public->delImgAll("zj_workmate","id in($where)");
				$this->Public->delImgAll("zj_workmatereply","workmateid in($where)");
			}
			if(!empty($_POST['id'])){
				echo '1';
			}else{
				success("删除成功！",site_url("/Workmate/WorkmateList"),1);
			}
	}

	//发布子女教育
	public function WorkmateTeach(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateTeach']);


			if(!empty($_POST)){
				$data['title']=$this->input->post('title',true);
				$data['content'] = str_replace("\r\n",'',$this->input->post('content',true));
				$data['address'] = $this->input->post('address',true)?$this->input->post('address',true):'保密';

				if(!empty($_FILES)){

					$litpic=array();
					$pic = '';
					for($i=0;$i<count($_FILES)-1;$i++) {
						$pic .= $this->Public->fileImg($_FILES['pic'.$i],'').',';

					}
					$data['pic'] = trim($pic,',');
					$imgArr=explode(',',$data['pic']);

					for($i=0;$i<=count($imgArr)-1;$i++) {
						array_push($litpic,$this->Public->Litpic($imgArr[$i]));

					}
					$data['litpic'] = json_encode($litpic);
				}

				$data['userid'] = 0;
				$data['video']=$this->input->post('video',true);
				if (!preg_match("/^(http|ftp):/", $data['video'])) {
						$data['video'] = 'http://' . $data['video'];
				}
				$data['addtime'] = time();
				$data['status'] = $this->input->post('status',true);
				$this->db->insert('zj_workmate',$data);
				header("Location:WorkmateList");

			}
			$this->load->view("admin/Workmate/WorkmateTeach.html",$data);
	}

	//评论
	public function WorkmateReply(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateReply']);

			$where = ' type=2 ';
			$soso = $this->input->get('soso',true);
			$startime = $this->input->get('startime',true);
			$endtime = $this->input->get('endtime',true);

			if($soso){
				$where .= " and content like '%".$soso."%'";
			}
			if($startime && $endtime){
				if($startime < $endtime){
					$where .= " and addtime > '".strtotime($startime)."' and addtime < '".strtotime($endtime)."'";
				}

			}
			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_workmatereply where $where order by id desc";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Workmate/WorkmateList';
			$data['get'] = "soso=$soso&startime=$startime&endtime=$endtime";//参数
			$data['soso'] = $soso;
			$data['startime'] = $startime;
			$data['endtime'] = $endtime;
			$this->load->view("admin/Workmate/WorkmateReply.html",$data);
	}

	//删除
	public function WorkmateReplyDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Workmate']['WorkmateReply']);

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
				$this->load->model('Workmate_model','Workmate'); //公用model

				$this->Workmate->delReply($where);
			}
			if(!empty($_POST['id'])){
				echo '1';
			}else{
				success("删除成功！",site_url("/Workmate/WorkmateReply"),1);
			}
	}


}
