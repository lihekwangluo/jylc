<?php
// 本类由系统自动生成，仅供测试用途

class McommonAction extends Action {

	public $_static = null;
	public $uid = 0;
	//public $num = null;
	public $nickname = null;
	public $Login = true;
	public $pre = null;
	public $_root = null;

    public function _initialize(){
		$this->_static = WEB_HOST."/wap/public";
		$this->assign('_static_',$this->_static);
		$this->pre = C("DB_PREFIX");
		$this->_root = "/wap/index.php/";
		$this->assign("_root",$this->_root);
		
		//登陆判断
		$this->Login = isset($this->Login)?$this->Login:false;
		if(!cookie_tp('uid') || !$this->Login){
			redirect_tp($this->_root."/login");
			exit;
		}
		if(cookie_tp("uid")){
			$this->uid = cookie_tp("uid");
			$this->nickname = cookie_tp("nickname");
		}
    }
}