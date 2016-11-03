<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Public_model extends CI_Model{

		//菜单栏变化
		function munBian($mun){
			$t = $this->uri->segment(1);
			if($mun == $t){
				return 'current';
			}else{
				return;
			}
		}
        /*
        数据查询数据库 (单库)
        $data 数据表名
        $where条件查询
        $name 查询的字段 为空则查询全部
         */
		function is_sql_exec($data, $where = '', $name = '*')
		{

			if (!empty($data)) {

				if (!empty($where)) {
					$where = ' where ' . $where;
				}
				$sql = 'select ' . $name . ' from ' . $data . ' ' . $where;
				$query = $this->db->query($sql);
				return $query->result_array();

			} else {
				return false;
			}

		}
		/*
			数据查询数据库 (单库)
			$data 数据表名
			$where条件查询
			$is 为真则返回多条
			$name 查询的字段 为空则查询全部
		*/
		function is_sql_name($data,$where='',$is='',$name='*'){

			if(!empty($data)){
				
				if(!empty($where)){
					$where = ' where ' . $where;
				}
				$sql ='select '.$name.' from '.$data.' '.$where;
				$query = $this->db->query($sql);
				if(empty($is)){
					return $query->row_array();
				}else{
					return $query;
				}
			}else{
				return false;
			}

		}

		// 分页
	
		public function pageList($Sql='',$segment='',$pagesize='10',$pagecount='',$pageindex='',$pageall=''){
				$Sql = $this->db->page($Sql,$pagesize,$pagecount,$pageindex,$pageall,$segment);
				$data["query"]=$this->db->query($Sql);
				$data["pagecount"]=$pagecount;
				$data["pageindex"]=$pageindex;
				$data["pageall"]=$pageall;
				$data["arr"]=$this->db->page_number($pagecount,$pageindex);
				return $data;
		}
		/*
			图片删除 同时删除数据 升级版
			$data   数据表名
			$where  查询条件
			$divs   图片之间分割 默认 ,
			$imgpic 数据字段 默认pic
		*/
			public function delImgAll($data,$where,$imgpic=array('pic'),$divs=','){
				if(!empty($where)){
					if(!empty($imgpic)){
						$sql = "select * from ".$data." where " .$where;
						$query = $this->db->query($sql);
						$file = $_SERVER['DOCUMENT_ROOT'];
						foreach ($query->result_array() as $arr) {
							foreach ($imgpic as $Iv) {
								$picArr = explode($divs,$arr[$Iv]);
								foreach ($picArr as $pic){
									@unlink($file.$pic);
								}
							}
							
						}
					}
					
					$sql = "delete from ".$data." where " .$where;
					return $this->db->query($sql);
					exit;
				}
				return false;

			}
			//年龄获取
	    	public function getAge($birthday){

				$age = '0';
			    if(!empty($age)){
			        $age = date('Y', time()) - date('Y', strtotime($birthday)) - 1;  
			        if (date('m', time()) == date('m', strtotime($birthday))){  
			          
			            if (date('d', time()) > date('d', strtotime($birthday))){  
			            $age++;  
			            }  
			        }elseif (date('m', time()) > date('m', strtotime($birthday))){  
			            $age++;  
			        }  
			    
			    }
			    return $age;
			}

			/*
				图片上传
				$file 图片信息
				$pics 图片路径
			*/
			public function fileImg($file,$pics){
				$pics = $pics?$pics:'';
				if(!empty($file['name'])){
					$this->load->library("recsonclass");
					$file = $this->recsonclass->upload($file,$result,"",trim($pics,'/'));
					if($result == 'ok'){
						$pics = '/'.$file;
					}
				}
				return $pics;
			}
			//查询设备
			public function selectDevice(){
				$sql = "select id,name from zj_device";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;
			}
			//查询工种
			public function selectCraft(){
				$sql = "select id,name from zj_craft";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;

			}
			//查询项目类型
			public function selectMold(){
				$sql = "select id,name from zj_mold";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;

			}
			//查询项目类型
			public function selectAlcor(){
				$sql = "select id,name from zj_alcor";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;

			}
			//查询地区
			public function selectAddress($id='0'){
				if($id){
					$where = "area_parent_id = ".$id." ";
				}else{
					$where = "area_deep = 1 ";
					
				}
				$sql = "select area_id as id,area_name as name from zj_area where $where";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;
			}
			//用户搜素
			public function selectUsername($name){
				$sql = "select id,name from zj_user where name like '%$name%'";
				$query = $this->db->query($sql);
				$str = "<option value=''>--请选择--</option>";
				foreach ($query->result_array() as $arr) {
					$str .= "<option value='".$arr['id']."'>".$arr['name']."</option>";
				}
				return $str;
			}

			//消息给用户
			public function informAdd($id,$title,$content){
				$data['userid'] = $id;
				$data['title'] = $title;
				$data['content'] = $content;
				$data['addtime'] = time();
				$this->db->insert('zj_inform',$data);
			}

			//创蓝短信接口
			public function ChuanglanSmsHelper($mobile,$content){
					$this->load->library("chuanglansmsapi");
					$result = $this->chuanglansmsapi->sendSMS($mobile,$content,'true');
					$result = $this->chuanglansmsapi->execResult($result);
					if($result[1] != 0){
						return false;
					}else{
						return true;
					}
					
			}
			//数据库操作日志
			public function dataLogo($title){
					$data['name'] = $this->admin_username;
					$data['title'] = $title;
					$data['addtime'] = time();
					$this->db->insert('zj_datalog',$data);

			}
			


	}