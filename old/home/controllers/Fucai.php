<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Fucai extends Indexinit {
	public function index(){

		$this->load->model('Public_model','Public');
		$segment=$this->uri->segment(4);
		// 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$data=array("nav"=>2,'areaname'=>$_SESSION['area_name']);

		$other='';
		$url = '';
		$url .= "city=".$_GET['city'];

		if(!empty($_GET['city']))
		{

			$other.=' AND area1='.@$_GET['city'].' ';
		}
		$url .= "&craftname=".$_GET['craftname'];
		if(!empty($_GET['craftname']))
		{

			$other.=' AND alcorid='.@$_GET['craftname'].' ';
		}
		$url .= "&value=".$_GET['value'];
		if(!empty($_GET['value']))
		{
			$other.=' AND alcorid='.@$_GET['value'].' ';
		}
		if($_GET['num']=="yes")
		{
			$other.=' order by num desc';
		}elseif($_GET['times']=="yes"){
			$other.=' order by addtime desc';
		}
		$Sql="select * from `zj_publish` where status=5 and power=2".$other;
		if($_GET['renzheng']){
				$url .= "&renzheng=1";
				$data['renzheng'] = 1;
				$Sql="select * from `zj_publish` where status=5 and zhuangtai=1".$other;
		}
		$pagesize=10;
		$data=$this->Public->pageList($Sql,$this->uri->segment(3));
		$data['nav']=5;
		$num1=$this->db->query($Sql);
		$data['num1']=$num1->num_rows;
		$data['num2']=$num2->num_rows;
		//$data['all']=$this->selectRow("zj_publish","status=4 and power=2".$other,false);
		//$this->db->query($sql2);
		$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
		$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
		$data['craft']=$this->selectRow("zj_craft"," 1 " ,false);
		$data['alcor']=$this->selectRow("zj_alcor","" ,false);
		//$data['alcor1']=$this->selectRow("zj_alcor","ptype=1" ,false);
		$data['xiangsi']=$this->xiangsi();
		$data['search']=$this->remen();
		$data['get'] = $url;
		$data['url'] = "Fucai/index";
		$data['a']=$data['query']->result_array();
		foreach( $data['a'] as $key => $value ){
			$alcor=$this->selectRow("zj_alcor","id='".$value['alcorid']."'");
			$data['a'][$key]['alcorid']=$alcor['name'];
		}


		//// 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		//$data=array("nav"=>5,'areaname'=>$_SESSION['area_name']);
		//	$other='';
		//if(!empty($_GET['city']))
		//{
		//	$other.=' AND area1='.@$_GET['city'].' ';
		//}
		////ptype  厂家为0商家为1
		//if(!empty($_GET['craftname']))
		//{
		//	$other.=' AND alcorid='.@$_GET['craftname'].' ';
		//}
		//if(!empty($_GET['value']))
		//{
		//	$other.=' AND alcorid='.@$_GET['value'].' ';
		//}
		////$price=@$_GET['value'];
		////$res=explode('-',$price);
		////if(sizeof($res)=='2')
		////{
		////	$other.=' AND  price='.$res[0].' ';
		////	if($res['1']!=0)
		////	{
		////		$other.=' AND price2='.$res[1].' ';
		////	}
		////}
		//if($_GET['num']=="yes")
		//{
		//	$other.=' order by price desc';
		//}elseif($_GET['times']=="yes"){
		//	$other.=' order by addtime desc';
		//}
		//$sql="select * from `zj_publish` where status=5 and power=1".$other;
		//$sql2="select * from `zj_publish` where status=5 and power=2".$other;
		//$num1=$this->db->query($sql);
		//$num2=$this->db->query($sql2);
		//$data['num1']=$num1->num_rows;
		//$data['num2']=$num2->num_rows;
		//$data['renzheng']=$this->selectRow("zj_publish","status=5 and power=1".$other,false);
		//$data['all']=$this->selectRow("zj_publish","status=5 and power=2".$other,false);
		//foreach( $data['renzheng'] as $key => $value ){
		//	$alcor=$this->selectRow("zj_alcor","id='".$value['alcorid']."'");
		//	$data['renzheng'][$key]['alcorid']=$alcor['name'];
		//}
		//foreach( $data['all'] as $key => $value ){
		//	$alcor=$this->selectRow("zj_alcor","id='".$value['alcorid']."'");
		//	$data['all'][$key]['alcorid']=$alcor['name'];
		//}
		////$data['area']=$this->selectRow("zj_area","area_parent_id=0",false);
		//$data['alcor']=$this->selectRow("zj_alcor","ptype=0" ,false);
		//$data['alcor1']=$this->selectRow("zj_alcor","ptype=1" ,false);
		//$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
		//$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
		//$data['xiangsi']=$this->xiangsi();
		//$data['search']=$this->remen();
		$this->load->view("home/nav/fucai.html",$data);
	}
	public function contentid(){
		$id=$this->uri->segment(3);
		$content=$this->selectRow("zj_publish","id='".$id."'");
		$alcorid=$this->selectRow("zj_alcor","id='".$content['alcorid']."'");
		$area1=$this->selectRow("zj_area","area_id='".$content['area1']."'");
		$area2=$this->selectRow("zj_area","area_id='".$content['area2']."'");
		$content['area1']=$area1['area_name'];
		$content['area2']=$area2['area_name'];
		$content['alcorid']=$alcorid['name'];
		$content['nav']=5;
		$content['imgage']=explode(",",$content['pic']);
		$content['xiangsi']=$this->xiangsi();
		$content['search']=$this->remen();
		$this->load->view("home/contents/xiang_q4.html",$content);
	}
	//相似岗位
	public function xiangsi(){
		$xiangsi=$this->selectRow("zj_publish","status=5 limit 10,3",false);
		foreach( $xiangsi as $key => $value ){
			# code...
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
			$alcor=$this->selectRow("zj_alcor","id='".$value['alcorid']."'");
			$xiangsi[$key]['alcorid']=$alcor['name'];
		}
		return $xiangsi;
	}
			//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
