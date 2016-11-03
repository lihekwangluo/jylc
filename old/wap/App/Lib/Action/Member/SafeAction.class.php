<?php
// 本类由系统自动生成，仅供测试用途
class SafeAction extends McommonAction {

    public function index(){
		$this->display();
    }

    public function fixmobile(){
    	if(IS_POST){
    		$user = A("Api/User");
    		$res = $user->usermobiletrade();
    		if($res===true) ajaxmsg(1,"修改成功");
    		else ajaxmsg(0,$res);
    	}
    	$this->display();
    }

    public function fixpassword(){
    	if(IS_POST){
    		$user = A("Api/User");
    		$res = $user->userupdatepass();
    		if($res===true) ajaxmsg(1,"修改成功");
    		else ajaxmsg(0,$res);
    	}
    	$this->display();
    }

}