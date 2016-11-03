<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LInvitecode_model extends CI_Model{
	private static $file=' * ';
	private static $tab=' `zj_invitecode` ';
	private static $tab2='invitecode ';


	private function createCode($id){
		return chr(rand(97, 122)).chr(rand(97, 122)).rand(100,999).chr(rand(97, 122)).chr(rand(97, 122)).$id;
	}
	public function invitecode2($id){
			$sql='select '.self::$file.' from '.self::$tab.' where userid="'.$id.'"';
			$query=$this->db->query($sql);
			if(empty($query)){
				$data = array();
				$code = $this->createCode($id);
				$data['userid'] = $id;
				$data['code'] = $code;
				$data['addtime'] = time();
				$this->db->insert(self::$tab2,$data);
				return $this->invitecode2();
				exit;
			}
			$list=$query->row_array();
			if(empty($list)){ //如果不存在则创建
				$data = array();
				$code = $this->createCode($id);
				$data['userid'] = $id;
				$data['code'] = $code;
				$data['addtime'] = time();
				$this->db->insert(self::$tab2,$data);
				return $this->invitecode2();
				exit;
			}else{
				return $list['code'];
			}
	}
		//环信注册
	public function huanxinRegister($hxname){
		include_once './home/libraries/Recson.class.php';
		//固定
		$options['client_id'] = 'YXA6t0o2oJpVEeW1DLXywiX-lw';
    $options['client_secret'] = 'YXA6eLIbiKUovCYcNGAZZlxk7zoORPk';
    $options['org_name'] = 'lihewangluo';
    $options['app_name'] = 'janzhu';
		$Easemob=new Easemob($options);
		$EasemobCount = $Easemob->openRegister(array("username"=>$hxname,"password"=>'JianZhu_5F3A64'));
		$EasemobCount = json_decode($EasemobCount,true);
		if(!empty($EasemobCount['duration'])){
		    return $hxname;
		}else{
			return 'false';
		}
	}
		/*
		userid		用户id
		content 	描述
		zhuangtai 	增加还是减少
		status 		积分类别 1是邀请/2是注册/......

	*/
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
			$this->db->insert("zj_Integrallog",$data);
			if($d == '1'){
				//给对应的用户加积分或减去
				if($data['zhuangtai'] == 1){ //增加
					$sql = "UPDATE zj_user SET integral = integral+'".$data['num']."' where id = '".$data['userid']."'";
				}else{//减去
					$sql = "UPDATE zj_user SET integral = integral-'".$data['num']."' where id = '".$data['userid']."'";
				}
				$query=$this->db->query($sql);
			}


	}
	//获取设置的积分
	public function getSetIntegral($i){
			$sql="select * from `zj_setintegral` where id=1";
			$list=$this->db->query($sql)->row_array();
			if($i==1){
				$t = $list['invitation'];
			}elseif($i==2){
				$t = $list['register'];
			}elseif($i==3){
				$t = $list['login'];
			}elseif($i==6){
				$t = $list['kongjian'];
			}elseif($i==7){
				$t = $list['haoyou'];
			}elseif($i==8){
				$t = $list['zhiwei'];
			}else{
				$t = 0;
			}
			return $t;
	}
}
