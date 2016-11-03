<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lbasemodel extends CI_Model
{
	function __constrcut()
	{
		parent::__constrcut();
		@session_start();
	}
	private static $resources=false;
	protected function Lquery($sql,$isc=true)
	{
		if(empty($sql) && self::$resources)
		{
			return self::$resources;
		}
		if(empty($sql))
		{
			return false;
		}
		if($isc || !$resources)
		{
			self::$resources=$this->db->query($sql);
			return self::$resources;
		}
		else
		{
			return self::$resources;
		}

	}

	protected function getCount($sql=false,$isc=true)
	{
		$query=$this->Lquery($sql,$isc);
		if(empty($query)){
			return false;
		}else {
			return $query->num_rows();
		}
	}
	protected function getOne($sql=false,$isc=true)
	{
		$query=$this->Lquery($sql,$isc);
		if(empty($query)){
			return false;
		}else{
			return $query->row_array();
		}
	}
	protected function getAll($sql=false,$isc=true)
	{
		$query=$this->Lquery($sql,$isc);
		if(empty($query)){
			return false;
		}else{
			return $query->result_array();
		}
	}

	//执行插入
	protected function execInsert($table,$data)
	{
		return $this->db->insert($table,$data);
	}

	//删除
	public function execDel($tab,$where)
	{
		$sql="delete from {$tab} where 1 AND {$where} limit 1";
		return $this->Lquery($sql);
	}

	//执行更新
	protected function execUpdate($table,$data,$where='')
	{
		return $this->db->update($table,$data,$where);
	}

	//指定字段自增或者自减
	protected function execfieldUp($tab,$field,$where,$type='+',$num='1')//指定字段自增
	{
		$sql='update `'.$tab.'` set `'.$field.'`=`'.$field.'`'.$type.$num.' where '.$where;
		return $this->Lquery($sql);
	}

	//app分页查询
	protected function getAllPage($sql,$defaultSize=15,$sizeTag='size',$pageTag='p',$other='')
	{
		$_pageSize=@$_REQUEST[$sizeTag];
		$_page=@$_REQUEST[$pageTag];
		$pageSize=((!empty($_pageSize)&&intval($_pageSize)>=1)?$_pageSize:$defaultSize);
		$page=((!empty($_page)&&intval($_page)>1)?$_page:1);
		$res=$this->selectLimit($sql,$pageSize,($page-1)*$pageSize,$other);
		return $res;
	}

	private function selectLimit($sql, $numrows=-1, $offset=-1,$other)
	{
		if($offset==-1)
		{
			$sql.=' LIMIT '.$numrows .' '.$other;
		}
		else
		{
			$sql.=' LIMIT '.$offset.', '.$numrows .' '.$other;
		}
		//echo $sql;
		return $this->getAll($sql);
	}






























































	//跟据任意条件获取信息
	protected function inWhereGetInfo($tab,$file=' * ',$where=' 1 ',$ret='all'){
		$sql='select '.$file.' from '.$tab.' where '.$where;

		if($ret==='all')
		{
			return $this->getAll($sql);
		}
		else if($ret==='page')
		{
			return $this->getAllPage($sql);
		}
		else if($ret==='one')
		{
			return $this->getOne($sql);
		}
	}

}
?>
