<?php
//地区
class AreaAction extends Action{

	public function getarea(){
		$where = '';
		$pid =  I('post.pid')?I('post.pid'):I('get.pid');
		$sort =  I('post.sort')?I('post.sort'):I('get.sort');
		$id =  I('post.id')?I('post.id'):I('get.id');
		if($pid == 'all'){
			$where = '1=1';
		}else{
			if(empty($pid)){ 
				$where  = " area_deep = '1' order by area_s";
			}else{
				$where  = " area_parent_id = '$pid' and area_deep != '1' order by area_s";
			}
			if(!empty($id)){
				$where  = " area_id = '$id' limit 1";
			}
		}
		
		$sql = "select * from zj_area where " . $where;
		$Area = M(); 
		$list=$Area->query($sql);
		if(@$sort){
			$arrt = array();
			$array =array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			foreach ($array as $v) {
				foreach ($list as $t) {
					if($v == $t['area_s']){
						$arrt[$v][] = $t;
					}
				}
			}
			$list = $arrt;
		}

		if(empty($list)){
		   get_obj_array('10000',"未查询到数据",array());
		}else{
		   get_obj_array('10000',"成功",$list);
		}
	}

	public function areaContain(){
		$Area = M(); 
		$sql = "select * from zj_area where area_deep = 1";
		$list=$Area->query($sql);
		$i = 1;
		foreach($list as $key => $value) {
				$sql = "select * from zj_area where area_parent_id = '".$value['area_id']."'";
				$list[$i] = $value;
				$list[$i]['find'] = $Area->query($sql);
				$i++;
		}
		$list['0']['area_id'] = '';
		$list['0']['area_name'] = '全部';
		$list['0']['area_parent_id'] = '0';
		$list['0']['area_sort'] = '0';
		$list['0']['area_deep'] = '0';
		$list['0']['area_s'] = '0';
		$list['0']['find']['0']['area_id'] = '';
		$list['0']['find']['0']['area_name'] = '全部';
		$list['0']['find']['0']['area_parent_id'] = '0';
		$list['0']['find']['0']['area_sort'] = '0';
		$list['0']['find']['0']['area_deep'] = '0';
		$list['0']['find']['0']['area_s'] = '0';
		get_obj_array('10000',"成功",$list);
	}
}