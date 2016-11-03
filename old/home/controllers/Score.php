<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Score extends Indexinit {
	public function index(){
		$this->load->model('Public_model','Public'); //公用model
		$segment=$this->uri->segment(3);
		$Sql = "SELECT * FROM zj_product  order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data['nav'] = 1;
		$data['areaname'] = $_SESSION['area_name'];
		$data['url'] = "score/index";
		$data['search']=$this->remen();
		$this->load->view("home/score/index.html",$data);
	}

	public function detail(){
		$this->load->model('Public_model','Public'); //公用model
		$id=$this->uri->segment(3);
		$data = array();
		if($id>0){
			$data = $this->Public->is_sql_name('zj_product',"id='$id'");
		}
		$data['search']=$this->remen();
		$this->load->view("home/score/detail.html",$data);
	}

	public function exchange(){
		$productid = $this->input->post('productid',true);
		$num = $this->input->post('num',true);
		$uid = $_SESSION['uid'];
		$username = $this->input->post('username',true);
		$mobile = $this->input->post('mobile',true);
		$address = $this->input->post('address',true);
		$address2 = $this->input->post('address2',true);
		$num = $num>0?$num:'1';

		if(empty($productid) || empty($num) || empty($uid) || empty($username) || empty($mobile) || empty($address) || empty($address2)){
			$data = array();
			$data['status'] = 0;
			$data['message'] = "请先写完整再提交";
			exit(json_encode($data));
 		}else{
			$this->load->model('Score_model','Score');
			$uerContent = $this->Score->userTokenCark($uid);
			$productList = $this->db->query("select * from zj_product where id= '$productid' limit 1")->row_array();

			$zintegral =  $productList['integral']*$num;
			if(!empty($productList)){
				if($uerContent['integral']>=$zintegral){ //判断积分

					if($productList['snum']>=$num){ //判断数量
						//组合交易数据
						$array = array();
						$array['userid'] = $uerContent['id'];
						$array['content'] = '兑换'.$productList['title'];
						$array['zhuangtai'] = 0;
						$array['status'] = 4;
						$array['productid'] = $productList['id'];
						$array['mobile'] = $mobile;
						$array['address'] = $address;
						$array['text'] = $address2;
						$array['num'] = $zintegral;
						$array['username'] = $username;
						$array['number'] = $num;
						$this->Score->integrallog($array);
						$sql = "update zj_product set snum = snum-$num where id= '".$productList['id']."'";
						$this->db->query($sql);
						$data = array(
							'status'=>1,
							'message'=>"兑换成功",
						);
						exit(json_encode($data));
					}else{
						$data = array(
							'status'=>0,
							'message'=>"数量不足",
						);
						exit(json_encode($data));
					}

				}else{
					$data = array(
						'status'=>0,
						'message'=>"用户积分不足！",
					);
					exit(json_encode($data));
				}
			}else{
				$data = array(
					'status'=>0,
					'message'=>"商品不存在！",
				);
				exit(json_encode($data));
			}
		}
	}

	public function ajax(){
		$this->load->model('Public_model','Public'); //公用model
		//权限
		$id = $this->input->post('id',true);
		$type = "area";
		if($type == 'area'){
			echo $this->Public->selectAddress($id);
		}elseif($type == 'Xusername'){
			echo $this->Public->selectUsername($id);
		}
	}
				//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
