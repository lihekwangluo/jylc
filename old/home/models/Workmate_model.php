<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workmate_model extends CI_Model{

	//删除回复
	public function delReply($id){
		$sql ="select id from zj_workmatereply where pid in($id) and type = 2";
			$query = $this->db->query($sql);
			foreach($query->result_array() as $value) {
				$this->delReply($value['id']);
				$this->db->delete('zj_workmatereply',"id = ".$value['id']." and type = 2");
			}
			$this->db->delete('zj_workmatereply',"id in($id) and type = 2");
	}
}
