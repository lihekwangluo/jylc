<?php
// 本类由系统自动生成，仅供测试用途

class HcommonAction extends Action {

	public $uid = 0;
	//public $num = null;
	public $nickname = null;
	public $_static = null;
	public $pre = null;
	public $_root = null;

    public function _initialize(){
    	if(session_tp("uid")){
			$this->uid = session_tp("uid");
			//$this->num = session_tp("num");
			$this->nickname = session_tp("nickname");
		}
		$this->_static = WEB_HOST."/wap/public";
		$this->assign('_static_',$this->_static);
		$this->_root = "/wap/index.php/";
		$this->assign("_root",$this->_root);
		$this->pre = C("DB_PREFIX");
    }
}