<?php
//工种操作
class CraftAction extends IndexAction{
	//获取工种
	/*
		参数：
			craftid 获取一个

	*/
	public function craftget(){
		$craftid = I('post.craftid')?I('post.craftid'):I('get.craftid');
		$cate = I('post.cate')?I('post.cate'):I('get.cate');
		$ptype = I('post.ptype')?I('post.ptype'):I('get.ptype');
		$cate = $cate?$cate:'1';
		if($cate == '1'){
			$t = "Craft";
		}elseif($cate == '2'){
			$t = "Device";
		}elseif($cate == '3'){
			$t = "Mold";
		}elseif($cate == '4'){
			$t = "Alcor";
		}

		$where = '';
		
		if(!empty($craftid)){
			$where = " and id = '$craftid'";
		}
		if($t=='Alcor'){
			$where .= " and ptype = '$ptype'";
		}
		//查询工种
		$Craft = M($t);
		$order = $cate == '1' ? 'weights,id':'id';
		$list = $Craft->where("status = 1".$where)->order($order)->select();
		$root = array();
		foreach ($list as $key => $value) {
			$root[$key]['cid'] = (string)$value['id'];
			$root[$key]['name'] = (string)$value['name'];
		}
		
		if(!empty($root)){
			return $root;
			//get_obj_array('10000',"成功！",$root);
		}else{
			return get_obj_array('20000',"未查询到数据！",'');
		}
	}
	
}