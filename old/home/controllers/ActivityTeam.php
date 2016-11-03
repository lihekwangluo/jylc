<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class ActivityTeam extends Indexinit {
	public function index(){

		$this->load->model('Public_model','Public');
		$segment=$this->uri->segment(4);
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

			$other.=' AND craftid='.@$_GET['craftname'].' ';
		}
		$url .= "&value=".$_GET['value'];
		$price=@$_GET['value'];
		if($price=='0'){

		}elseif($price=='1000000'){
			$other.=' AND  price >= '.$price.' ';
		}else{
			$res=explode('-',$price);
			if(sizeof($res)=='2')
			{
				$other.=' AND  price >= '.$res[0].' ';
				if($res['1']!=0)
				{
					$other.=' AND price <= '.$res[1].' ';
				}
			}
		}
		if($_GET['num']=="yes")
		{
			$other.=' order by num desc';
		}elseif($_GET['times']=="yes"){
			$other.=' order by addtime desc';
		}
		//$data['renzheng']=$this->selectRow("zj_publish","status=4 and power=1".$other,false);
		$Sql="select * from `zj_publish` where status=2 and power=2".$other;
		if($_GET['renzheng']){
				$url .= "&renzheng=1";
				$data['renzheng'] = 1;
				$Sql="select * from `zj_publish` where status=2 and zhuangtai=1".$other;
		}
		//echo $data['renzheng'];
		$pagesize=10;

		$data=$this->Public->pageList($Sql,$this->uri->segment(3));
		$data['nav']=3;
		$num1=$this->db->query($Sql);
		$data['num1']=$num1->num_rows;
		$data['num2']=$num2->num_rows;
		$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
		$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
		$data['craft']=$this->selectRow("zj_craft"," 1 order by weights " ,false);
		$data['xiangsi']=$this->xiangsi();
		$data['search']=$this->remen();
		$data['get'] = $url;
		$data['url'] = "ActivityTeam/index";
		$data['a']=$data['query']->result_array();
		foreach( $data['a'] as $key => $value ){
			$mold=$this->selectRow("zj_mold","id='".$value['moldid']."'");
			$data['a'][$key]['moldid']=$mold['name'];
		}
		// 1���豸���⣬2�ǻ��Ҷӣ�3�Ƕ��һ4�Ƕ�����,5����	$other='';
		//$data=array("nav"=>3,'areaname'=>$_SESSION['area_name']);
		//if(!empty($_GET['city']))
		//{
		//	$other.=' AND area1='.@$_GET['city'].' ';
		//}
		//if(!empty($_GET['craftname']))
		//{
		//	$other.=' AND craftid='.@$_GET['craftname'].' ';
		//}
		//$price=@$_GET['value'];
		//$res=explode('-',$price);
		//if(sizeof($res)=='2')
		//{
		//	$other.=' AND  price='.$res[0].' ';
		//	if($res['1']!=0)
		//	{
		//		$other.=' AND price2='.$res[1].' ';
		//	}
		//}
		//if($_GET['num']=="yes")
		//{
		//	$other.=' order by num desc';
		//}elseif($_GET['times']=="yes"){
		//	$other.=' order by addtime desc';
		//}
		//$sql="select * from `zj_publish` where status=2 and power=1".$other;
		//$sql2="select * from `zj_publish` where status=2 and power=2".$other;
		//$num1=$this->db->query($sql);
		//$num2=$this->db->query($sql2);
		//$data['num1']=$num1->num_rows;
		//$data['num2']=$num2->num_rows;
		//$data['renzheng']=$this->selectRow("zj_publish","status=2 and power=1".$other,false);
		//$data['all']=$this->selectRow("zj_publish","status=2 and power=2".$other,false);
	/*	foreach( $data['renzheng'] as $key => $value ){
			$mold=$this->selectRow("zj_mold","id='".$value['moldid']."'");
			$data['renzheng'][$key]['moldid']=$mold['name'];
		}
		foreach( $data['all'] as $k => $va ){
			$mold=$this->selectRow("zj_mold","id='".$va['moldid']."'");
			$data['all'][$k]['moldid']=$mold['name'];
		}*/
		////$data['area']=$this->selectRow("zj_area","area_parent_id=0",false);
		//$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
		//$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
		//$data['craft']=$this->selectRow("zj_craft"," 1 " ,false);
		//$data['xiangsi']=$this->xiangsi();
		//$data['search']=$this->remen();
		$this->load->view("home/nav/huo-zhaodui.html",$data);
	}
	public function contentid(){
		$id=$this->uri->segment(3);
		$content=$this->selectRow("zj_publish","id='".$id."'");
		$craft=$this->selectRow("zj_craft","id='".$content['craftid']."'");
		$mold=$this->selectRow("zj_mold","id='".$content['moldid']."'");
		$area1=$this->selectRow("zj_area","area_id='".$content['area1']."'");
		$area2=$this->selectRow("zj_area","area_id='".$content['area2']."'");
		$content['area1']=$area1['area_name'];
		$content['area2']=$area2['area_name'];
		$content['craftid']=$craft['name'];
		$content['moldid']=$mold['name'];
		$content['nav']=3;
		$content['xiangsi']=$this->xiangsi();
		$content['search']=$this->remen();
		$this->load->view("home/contents/xiang_q3.html",$content);
	}
	//���Ƹ�λ
	public function xiangsi(){
		$xiangsi=$this->selectRow("zj_publish","status=2 limit 10,3",false);
		foreach( $xiangsi as $key => $value ){
			# code...
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
		}
		return $xiangsi;
	}
		//��������
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
