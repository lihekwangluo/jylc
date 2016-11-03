<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

	public $uid=0;
	public $nickname = NUll;

	function __construct(){
			parent::__construct();
			//加载公用模块
			if(session_tp( "uid")){
				$this->uid = session_tp( "uid");
				$this->nickname = session_tp( "nickname");
			}
	}
}