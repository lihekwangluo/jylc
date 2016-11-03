<?php
@session_start();
class Indexinit extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url'); //url加载辅助函数
		$this->load->helper('array');//加载函数
		$this->load->database(); //数据库类
		$this->load->library("session");
		$_SESSION['area_name']=empty($_SESSION['area_name'])?"北京":$_SESSION['area_name'];
	}
	/*
		数据查询数据库 (单库)
		$table 数据表名
		$where条件查询
		$is 为真则返回多条
		$name 查询的字段 为空则查询全部
	*/

	public function cklogin(){
		if(!$_SESSION['uid']){
			exit("<script>alert('请登录'); window.location.href='".site_url('Lilogin/login')."';</script>");
		}
	}

	function selectRow ($table,$where='',$is=true,$name='*'){

		if(!empty($table)){

			if(!empty($where)){
				$where = ' where ' . $where;
			}
			$sql ='select '.$name.' from '.$table.' '.$where;
		//echo "<pre>";
		//echo $sql;
			$query = $this->db->query($sql);
			if($is==true){
				return $query->row_array();
			}else{
				return $query->result_array();
			}
		}else{
			return false;
		}
	}
	//分页
	 public	function selectLimit($Sql='',$segment='',$pagesize='10',$pagecount='',$pageindex='',$pageall=''){
		  $Sql = $this->db->page($Sql,$pagesize,$pagecount,$pageindex,$pageall,$segment);
			$data["query"]=$this->db->query($Sql);
			$data["pagecount"]=$pagecount;
			$data["pageindex"]=$pageindex;
			$data["pageall"]=$pageall;
			$data["arr"]=$this->db->page_number($pagecount,$pageindex);
			return $data;
	 }
}
