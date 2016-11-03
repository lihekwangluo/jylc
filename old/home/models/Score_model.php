<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Score_model extends CI_Model{

		public function integrallog($arr,$d='1'){
			if(empty($arr['num'])){
				$data['num'] = $this->getSetIntegral($arr['status']);
			}else{
				$data['num'] = $arr['num'];
			}
			$data['userid'] = $arr['userid'];
			$data['content'] = $arr['content'];
			$data['zhuangtai'] = $arr['zhuangtai'];
			$data['status'] = $arr['status'];
			if(!empty($arr['addup'])){
				$data['addup'] = $arr['addup'];
			}
			
			$data['addtime'] = time();
			if($arr['status'] == 4){
				$data['productid'] = $arr['productid'];
				$data['username'] = $arr['username'];
				$data['mobile'] = $arr['mobile'];
				$data['address'] = $arr['address'];
				$data['text'] = $arr['text'];
				$data['num'] = $arr['num']; //如果是商品从新写入积分
				$data['number'] = $arr['number'];
			}
			
			$this->db->insert("zj_integrallog",$data);
			
			if($d == '1'){
				//给对应的用户加积分或减去
				if($data['zhuangtai'] == 1){ //增加
					$sql = "UPDATE zj_user SET integral = integral+'".$data['num']."' where id = '".$data['userid']."'";
				}else{//减去
					$sql = "UPDATE zj_user SET integral = integral-'".$data['num']."' where id = '".$data['userid']."'";
				}
				$this->db->query($sql);
			}
		}

		//获取设置的积分
		public function getSetIntegral($i){
				$list  = $this->db->query("select * from zj_etintegral where id=1 limit 1")->row_array();
				if($i==1){
					$t = $list['0']['invitation'];
				}elseif($i==2){
					$t = $list['0']['register'];
				}elseif($i==3){
					$t = $list['0']['login'];
				}elseif($i==6){
					$t = $list['0']['kongjian'];
				}elseif($i==7){
					$t = $list['0']['haoyou'];
				}elseif($i==8){
					$t = $list['0']['zhiwei'];
				}else{
					$t = 0;
				}
				return $t;
		}
		//用户登陆
		public function userTokenCark($token,$where=''){
			
			$list = $this->db->query("select * from zj_user where id='$token' limit 1")->row_array();
			if(empty($list)){
				return false;
			}else{
				return $list;
			}
		}

	}