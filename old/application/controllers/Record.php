<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Record extends Adminin {


		//列表
		public function RecordList(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Record']['RecordList']);
			
			$where = ' 1=1 ';
			$mobile1 = $this->input->get('mobile1',true);
			$mobile2 = $this->input->get('mobile2',true);
			$type = $this->input->get('type',true);
			$startime = $this->input->get('startime',true);
			$endtime = $this->input->get('endtime',true);
			if($mobile1){
				$where .= " and u.mobile = '$mobile1'";
			}
			if($mobile2){
				$where .= " and r.mobile = '$mobile2'";
			}
			if($type){
				$where .= " and r.type = '$type'";
			}
			if($startime && $endtime){
				if(strtotime($startime) < strtotime($endtime)){
					$where .= " and r.addtime >= '".strtotime($startime)."' and r.addtime <= '".strtotime($endtime)."'";
				}
			}
			$segment=$this->uri->segment(3);
			$sql = "SELECT r.*,u.mobile as umobile,u.name as uname,sum(d.price) as price,sum(d.jprice) as jprice FROM zj_relation as r
					INNER JOIN zj_user as u
					ON r.zuid = u.id
					left JOIN zj_record as d
					ON r.id = d.fuid and r.type = r.type
					WHERE $where group by r.id desc";
			$data = $this->Public->pageList($sql,$segment);
			$data['url'] = 'Record/RecordList';
			$data['get'] = "mobile1=$mobile1&startime=$startime&endtime=$endtime&type=$type&mobile2=$mobile2";//参数
			$data['mobile1'] = $mobile1;
			$data['mobile2'] = $mobile2;
			$data['startime'] = $startime;
			$data['endtime'] = $endtime;
			$data['type'] = $type;
			
			$this->load->view("admin/Record/RecordList.html",$data);
		}

		//产看详情
		public function RecordDetails(){
			//权限
			$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Record']['RecordList']);

				$zuid = $this->input->get('zuid');
				$fuid = $this->input->get('fuid');
				$type = $this->input->get('type');
				$Execl = $this->input->get('Execl');
				$startime = $this->input->get('startime',true);
				$endtime = $this->input->get('endtime',true);
				if(empty($zuid) || empty($fuid) || empty($type)){
					error("非法请求！",site_url("/Record/RecordList"),2);
				}else{
					$data = array();
					
					if(empty($startime) && empty($endtime)){
						$y=date("Y",time());
						$m=date("m",time());
						$t0=date('t');           // 本月一共有几天
						$startime = date('Y-m-d',mktime(0,0,0,$m,1,$y));        // 创建本月开始时间 
						$endtime = date('Y-m-d',mktime(23,59,59,$m,$t0,$y));       // 创建本月结束时间
					}
					if(strtotime($startime) < strtotime($endtime)){
						$where = " r.addtime >= '".strtotime($startime)."' and r.addtime <= '".strtotime($endtime)."'";
					}
					$where .= " and r.zuid = '$zuid' and r.fuid='$fuid' and r.type='$type' group by r.id desc";
					$sql = "SELECT r.*,u.name as uname,n.name FROM zj_record AS r
							INNER JOIN zj_user as u 
							ON r.zuid = u.id
							INNER JOIN zj_relation as n
							ON r.zuid = n.zuid
							WHERE $where";
					$query = $this->db->query($sql);
					$price = $jprice = $overtime = $overday = '';
					$root =array();
					foreach($query->result_array() as $array){

						$root[] = $array;
						$price += $array['price'];
						$jprice += $array['jprice'];
						$overtime += $array['overtime'];
						$overday += $array['overday'];
						
					}
					$data['query'] = $root;
					$data['price'] = $price;
					$data['jprice'] = $jprice;
					$data['overtime'] = $overtime;
					$data['overday'] = $overday;
					$data['zuid'] = $zuid;
					$data['fuid'] = $fuid;
					$data['type'] = $type;
					$data['startime'] = $startime;
					$data['endtime'] = $endtime;
					if(empty($Execl)){
						$this->load->view("admin/Record/RecordDetails.html",$data);
					}else{
						$this->load->model('Record_model','Record'); //公用model
						$this->Record->recordexcel($data,$type,$startime,$endtime);
					}
					
				}
		}

		// //下载excel
		// public function RecordExcel(){

		// }


}