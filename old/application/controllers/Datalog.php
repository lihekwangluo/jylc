<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Adminin.php";
class Datalog extends Adminin {

	//数据库展示
	public function backups(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['backups']);

		$data['query'] = $this->db->query('SHOW TABLES FROM jianzhu');
		
       $this->load->view("admin/Datalog/backups.html",$data);
	}


	//数据库恢复
	public function recover(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['recover']);

		$filepath = $_SERVER[DOCUMENT_ROOT].'/_bak/*.sql';
		$filearr = glob($filepath);
		if (!empty($filearr)) {
			foreach($filearr as $k=>$sqlfile){
				preg_match("/([0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num);
				$restore[$k]['filename'] = basename($sqlfile);
				$restore[$k]['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
				$restore[$k]['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
				$restore[$k]['pre'] = $num[1];
				$restore[$k]['number'] = $num[2];
				$restore[$k]['path'] = $_SERVER[DOCUMENT_ROOT].'_bak/';
			}
			$data['restore'] = $restore;
			$this->load->view("admin/Datalog/recover.html",$data);
		}else{
			error('没有检测到备份文件,请先备份或上传备份文件到'.$_SERVER[DOCUMENT_ROOT].'_bak/',site_url("/Datalog/backups"),3);
		}
	}

	//数据库操作日志
	public function operation(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['operation']);

			$segment=$this->uri->segment(3);
			$Sql = "SELECT * FROM zj_datalog order by id desc";
			$data = $this->Public->pageList($Sql,$segment);
			$data['url'] = 'Datalog/operation';
			$this->load->view("admin/Datalog/operation.html",$data);
	}


	//数据库备份操作1
	public function dataInsert(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['backups']);
	
		$data = trim($this->input->post('data',true),',');
		$filesize = intval($this->input->post('filesize',true));
		if ($filesize < 512) {
			error('出错了,请为分卷大小设置一个大于512的整数值！',site_url("/Datalog/backups"),3);
		}
		if(empty($data)){
			return false;
		}
		$this->Public->dataLogo('数据库备份');
		$file = $_SERVER[DOCUMENT_ROOT].'/_bak/';
		$sql = '';
		$random = mt_rand(1000, 9999);
		$data = explode(',', $data);
		$p = 1;
		foreach($data as $table){
			if($table != 'zj_datalog'){
				//查询sql
				$query = $this->Public->is_sql_name($table,'','1');
			
				$sql.= "TRUNCATE TABLE `$table`;\n";
				
				foreach($query->result_array() as $value){
					$sql.= $this->insertsql($table, $value);
					if (strlen($sql) >= $filesize*1000) {
						$filename = $file.date('Ymd').'_'.$random.'_'.$p.'.sql';
						write_file($filename,$sql);
						$p++;
						$sql='';
					}
				
				}
			}
		}
		if(!empty($sql)){
			$filename = $file.date('Ymd').'_'.$random.'_'.$p.'.sql';
			write_file($filename,$sql);
		}
		success('数据库分卷备份已完成,共分成'.$p.'个sql文件存放！',site_url("/Datalog/backups"),3);

	}

	//生成SQL备份语句
	public function insertsql($table,$row){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['backups']);
		
		$sql = "INSERT INTO `{$table}` VALUES ("; 
		$values = array(); 
		foreach ($row as $value) { 
			$values[] = "'" . mysql_real_escape_string($value) . "'"; 
		} 
		$sql .= implode(', ', $values) . ");\n"; 
		return $sql;
	}

	//导入or 删除
	public function backDel(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['recover']);

			$datadel = trim($this->input->post('datadel',true),',');
			
			if(!empty($datadel)){
				$arr = explode(',',$datadel);
				foreach($arr as $value){
					$this->Public->dataLogo('数据库备份文件'.$value.'删除');
					@unlink($_SERVER[DOCUMENT_ROOT].'/_bak/'.$value);
				}
				success('批量删除分卷文件成功！',site_url("/Datalog/backups"),3);

			}else{
				error('非法操作！',site_url("/Datalog/backups"),3);
			}
			
		
	}
	//导入
	public function back(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['recover']);

		$pre=$this->uri->segment(3);
		$fileid=$this->uri->segment(4);
		$filepath = $_SERVER[DOCUMENT_ROOT].'/_bak/';
		$filename = $pre.$fileid.'.sql';
		if(file_exists($filepath.$filename)){
			$this->Public->dataLogo('数据库备份文件'.$filename.'恢复');
			$sql = read_file($filepath.$filename);
			$sql = str_replace("\r\n", "\n", $sql); 
			foreach(explode(";\n", trim($sql)) as $query) {
				$this->db->query(trim($query));
			}
			$fileid++;
			success('第'.$fileid.'个备份文件恢复成功,准备恢复下一个,请稍等！',site_url("/Datalog/back/".$pre."/$fileid"),3);
		}else{
			success('数据库恢复成功！',site_url("/Datalog/recover"),3);
		}
		
	}

	// //下载还原 暂时不用
	// public function down(){
	// 	$this->Public->dataLogo('数据库备份文件'.$id.'下载');
	// 	$id=$this->uri->segment(3);
	// 	$filepath =  $_SERVER[DOCUMENT_ROOT].'/_bak/'.$id;
	// 	if (file_exists($filepath)) {
	// 		$filename = $filename ? $filename : basename($filepath);
	// 		$filetype = trim(substr(strrchr($filename, '.'), 1));
	// 		$filesize = filesize($filepath);
	// 		header('Cache-control: max-age=31536000');
	// 		header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
	// 		header('Content-Encoding: none');
	// 		header('Content-Length: '.$filesize);
	// 		header('Content-Disposition: attachment; filename='.$filename);
	// 		header('Content-Type: '.$filetype);
	// 		readfile($filepath);
	// 		exit;
	// 	}else{
	// 		error('出错了,没有找到分卷文件！',site_url("/Datalog/backups"),'3');
	// 	}
	// }
	//下载 zip 备份
	public function download(){
		//权限
		$this->Public->managePower($_SESSION["num_JSONPOWER_arr"]['Datalog']['recover']);

			$this->Public->dataLogo('数据库备份文件下载');
			$dir =  $_SERVER[DOCUMENT_ROOT].'/_bak/';
			$this->load->library("phpzip");
			$this->phpzip->ZipAndDownload($dir);
	}

}