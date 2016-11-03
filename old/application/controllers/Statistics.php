<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		require "Adminin.php";
class Statistics extends Adminin {

	//用户分析
	public function usert(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Statistics']['usert']);
		

		$startime = $this->input->get('startime',true)?$this->input->get('startime',true):date('Y-m-d',time());
		$endtime = $this->input->get('endtime',true)?$this->input->get('endtime',true):date('Y-m-d',time());

		$data['startime'] = $startime;
		$data['endtime'] = $endtime;
		if($startime && $endtime){
			if(strtotime($startime) >= strtotime($endtime)){
				$endtime = $startime.'23:59:59';
			}else{
				$endtime = $endtime.'23:59:59';
			}
		}
		$where = " addtime >= '".strtotime($startime)."' and addtime <= '".strtotime($endtime)."'";
		$query = $this->Public->is_sql_name('zj_usert',$where,'1');
		$t = starEnd($startime,$endtime);
		
		$list  = array();
		foreach ($query->result_array() as $a) {
			foreach ($t as $v) {
				if(($a['addtime'] >= $v['startime']) && ($a['addtime'] <= $v['endtime'])){

					$list[$v['time']]['qnum'] += 1;
					$list[$v['time']]['rnum'][$a['uid']] = 1; 
				}
			}
		}

		$data['list'] = $list;

		$this->load->view("admin/Statistics/usert.html",$data);

	}

	//用户粘度
	public function usertDetails(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Statistics']['usertDetails']);

			$startime = $this->input->get('startime',true)?$this->input->get('startime',true):date('Y-m-d',time());
			$endtime = $startime.'23:59:59';
			if(!empty($startime)){
				$where = "t.addtime <= '".strtotime($endtime)."'";
				$Sql = "SELECT max(t.addtime) as addtime,min(t.addtime) as mintime,sum(t) as t,u.id,u.name,u.nickname FROM zj_usert AS t
						INNER JOIN zj_user AS u
						ON t.uid = u.id
						WHERE $where group by u.id desc ORDER BY max(t.addtime) desc";
				$segment=$this->uri->segment(3);
				$data = $this->Public->pageList($Sql,$segment);
				$data['url'] = 'Statistics/usertDetails';
				$data['get'] = "startime=$startime";//参数
				$data['startime'] = $startime;
			}
			$this->load->view("admin/Statistics/usertDetails.html",$data);

	}
	//单个用户登录状况
	public function usertOne(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Statistics']['usertDetails']);

		$startime = $this->input->get('startime',true);
		$uid = $this->input->get('uid',true);
		if(!empty($uid)){
			$where = "t.uid = '$uid'";
			if(!empty($startime)){
				$endtime = $startime.'23:59:59';
				$where .= " and t.addtime >= '".strtotime($startime)."' and t.addtime <= '".strtotime($endtime)."' ";
			}

			$userCont = $this->Public->is_sql_name('zj_user',"id = '$uid' limit 1");
			if(!empty($userCont)){
				$Sql = "SELECT t.* FROM zj_usert as t WHERE $where order by addtime desc";
				$segment=$this->uri->segment(3);
				$data = $this->Public->pageList($Sql,$segment);
				$data['url'] = 'Statistics/usertOne';
				$data['get'] = "startime=$startime&uid=$uid";//参数
				$data['userCont'] = $userCont;
			}
		}
		
		$this->load->view("admin/Statistics/usertOne.html",$data);
	}

	// //沉默用户
	// public function silence(){
	// 	$startime = strtotime(date('Y-m-d',strtotime('-1 day')));
	// 	$Sql = "SELECT u.id,max(u.addtime) as addtime,sum(t.t) as t,u.name,u.nickname FROM zj_user as u
	// 			INNER JOIN zj_usert as t
	// 			ON t.uid = u.id
	// 			WHERE t.addtime <= '$startime' group by u.id desc";
	// 	$segment=$this->uri->segment(3);
	// 	$data = $this->Public->pageList($Sql,$segment);
	// 	$data['url'] = 'Statistics/silence';
	// 	$this->load->view("admin/Statistics/silence.html",$data);
		
	// }

	//终端属性
	public function terminal(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Statistics']['terminal']);
		
		$startime = $this->input->get('startime',true)?$this->input->get('startime',true):date('Y-m-d',time());
		$endtime = $this->input->get('endtime',true)?$this->input->get('endtime',true):date('Y-m-d',time());

		$data['startime'] = $startime;
		$data['endtime'] = $endtime;
		if($startime && $endtime){
			if(strtotime($startime) >= strtotime($endtime)){
				$endtime = $startime.'23:59:59';
			}else{
				$endtime = $endtime.'23:59:59';
			}
		}
		$where = " addtime >= '".strtotime($startime)."' and addtime <= '".strtotime($endtime)."'";
		$query = $this->Public->is_sql_name('zj_usert',$where,'1');
		$t = starEnd($startime,$endtime);
		
		$list  = array();
		foreach ($query->result_array() as $a) {
			foreach ($t as $v) {
				if(($a['addtime'] >= $v['startime']) && ($a['addtime'] <= $v['endtime'])){

					if($a['terminal'] =='android'){
						$list[$v['time']]['android'] += 1; 
					}elseif($a['terminal'] =='ios'){
						$list[$v['time']]['ios'] += 1; 
					}else{
						$list[$v['time']]['pc'] += 1; 
					}
				}
			}
		}

		$data['list'] = $list;

		$this->load->view("admin/Statistics/terminal.html",$data);
		
	}


		

}