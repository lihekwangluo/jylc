<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Shebei extends Indexinit {
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

			$other.=' AND deviceid='.@$_GET['craftname'].' ';
		}
		$url .= "&value=".$_GET['value'];
		if(!empty($_GET['value']))
		{
			$other.=' AND driver='.@$_GET['value'].' ';
		}
		if($_GET['num']=="yes")
		{
			$other.=' order by num desc';
		}elseif($_GET['times']=="yes"){
			$other.=' order by addtime desc';
		}
		$Sql="select * from `zj_publish` where status=1 and power=2".$other;
		if($_GET['renzheng']){
				$url .= "&renzheng=1";
				$data['renzheng'] = 1;
				$Sql="select * from `zj_publish` where status=1 and zhuangtai=1".$other;
		}
		$pagesize=10;
		$data=$this->Public->pageList($Sql,$this->uri->segment(3));
		$data['nav']=6;
		$num1=$this->db->query($Sql);
		$data['num1']=$num1->num_rows;
		$data['num2']=$num2->num_rows;
		$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
		$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
		$data['device']=$this->selectRow("zj_device"," 1 " ,false);
		$data['xiangsi']=$this->xiangsi();
		$data['search']=$this->remen();
		$data['get'] = $url;
		$data['url'] = "Shebei/index";


		// 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
	//	$data=array("nav"=>6,'areaname'=>$_SESSION['area_name']);
	//	$other='';
	//	if(!empty($_GET['city']))
	//	{
	//		$other.=' AND area1='.@$_GET['city'].' ';
	//	}
	//	if(!empty($_GET['craftname']))
	//	{
	//		$other.=' AND deviceid='.@$_GET['craftname'].' ';
	//	}
	//	//$price=@$_GET['value'];
	//	//$res=explode('-',$price);
	//	//if(sizeof($res)=='2')
	//	//{
	//	//	$other.=' AND  price='.$res[0].' ';
	//	//	if($res['1']!=0)
	//	//	{
	//	//		$other.=' AND price2='.$res[1].' ';
	//	//	}
	//	//}
	//	if(!empty($_GET['value']))
	//	{
	//		$other.=' AND driver='.@$_GET['value'].' ';
	//	}
	//	if($_GET['num']=="yes")
	//	{
	//		$other.=' order by num desc';
	//	}elseif($_GET['times']=="yes"){
	//		$other.=' order by addtime desc';
	//	}
	//	$sql="select * from `zj_publish` where status=3 and power=1".$other;
	//	$sql2="select * from `zj_publish` where status=3 and power=2".$other;
	//	$num1=$this->db->query($sql);
	//	$num2=$this->db->query($sql2);
	//	$data['num1']=$num1->num_rows;
	//	$data['num2']=$num2->num_rows;
	//	$data['renzheng']=$this->selectRow("zj_publish","status=1 and power=1".$other,false);
	//	$data['all']=$this->selectRow("zj_publish","status=1 and power=2".$other,false);
	//	//$data['area']=$this->selectRow("zj_area","area_parent_id=0",false);
	//	$data['area']=$this->selectRow("zj_area","area_parent_id=0 limit 0,7",false);
	//	$data['area1']=$this->selectRow("zj_area","area_parent_id=0 limit 7,10000",false);
	//	$data['device']=$this->selectRow("zj_device"," 1 " ,false);
	//	$data['xiangsi']=$this->xiangsi();
	//	$data['search']=$this->remen();
		$this->load->view("home/nav/shebei.html",$data);
	}
	public function contentid(){
		$id=$this->uri->segment(3);
		$content=$this->selectRow("zj_publish","id='".$id."'");
		$alcorid=$this->selectRow("zj_device","id='".$content['deviceid']."'");
		$area1=$this->selectRow("zj_area","area_id='".$content['area1']."'");
		$area2=$this->selectRow("zj_area","area_id='".$content['area2']."'");
		$content['area1']=$area1['area_name'];
		$content['area2']=$area2['area_name'];
		$content['deviceid']=$alcorid['name'];
		$content['nav']=6;
		$content['imgage']=explode(",",$content['pic']);
		$content['xiangsi']=$this->xiangsi();
		$content['search']=$this->remen();
		$this->load->view("home/contents/xiang_q5.html",$content);
	}
	//相似岗位
	public function xiangsi(){
		$xiangsi=$this->selectRow("zj_publish","status=1 limit 10,3",false);
		foreach( $xiangsi as $key => $value ){
			# code...
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
			$device=$this->selectRow("zj_device","id='".$value['deviceid']."'");
			$xiangsi[$key]['deviceid']=$device['name'];
		}
		return $xiangsi;
	}
			//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
	public function jubao(){
		//信息与描述不符  信息已过期  联系电话不对 联系电话不对 敏感信息 垃圾广告
		$id=$this->uri->segment(3);
		$pulish=$this->selectRow("zj_publish","id='".$id."'");
		$checkbox1=$this->input->post("checkbox[1]");
		$checkbox2=$this->input->post("checkbox[2]");
		$checkbox3=$this->input->post("checkbox[3]");
		$checkbox4=$this->input->post("checkbox[4]");
		$checkbox5=$this->input->post("checkbox[5]");
		$checkbox6=$this->input->post("checkbox[6]");
		$reason="";
		if($checkbox1=="on"){
			$reason.='信息与描述不符,';
		}
		if ($checkbox2=="on"){
			$reason.='信息已过期,';
		}
		if ($checkbox3=="on"){
			$reason.='联系电话不对,';
		}
		if ($checkbox4=="on"){
			$reason.='敏感信息,';
		}
		if ($checkbox5=="on"){
			$reason.='信息已过期,';
		}
		if ($checkbox6=="on"){
			$reason.='垃圾广告,';
		}
		$reason=trim($reason,",");
		if($_SESSION['uid']==null || empty($_SESSION['uid']) || $_SESSION['uid']==""){
			header("location:".site_url("Lilogin/login"));
		}else{
			$array=array(
				"userid"=>$_SESSION['uid'],
				"reason"=>$reason,
				"publishid"=>$pulish['userid'],
				"addtime"=>time()
			);
			$re=$this->db->insert("zj_reason",$array);
			if($re){
				exit("<script>alert('举报成功');window.history.back(-1);</script>");
			}else{
				exit("<script>alert('举报失败');window.history.back(-1);</script>");
			}
		}
	}
}
