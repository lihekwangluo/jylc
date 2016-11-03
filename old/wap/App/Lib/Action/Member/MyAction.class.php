<?php
// 本类由系统自动生成，仅供测试用途
class MyAction extends McommonAction {

    public function index(){
        if(IS_POST){
            $user = A("Api/User");
            $res = $user->useredit();
            if($res===true) ajaxmsg(1,"修改成功");
            else ajaxmsg(0,$res);
        }
        $user = A("Api/User");
        $vo = $user->usermessage();
    	$this->assign("vo",$vo);
        $t_list = M("craft")->field("id,name")->where("status=1")->order("id")->select();
        $this->assign("t_list",$t_list);
		$this->display();
    }

    public function publish(){
    	if(IS_POST){
    		$page = intval($_POST['page'])?intval($_POST['page']):1;
    		$demand = A("Api/Demand");
			$_POST['userid'] = $this->uid;
			$list = $demand->publishList();
			
			if(!is_array($list)) {
				exit(json_encode(array("status"=>0,"message"=>"没有了")));
			}else{
				$this->assign("list",$list);
				$html = $this->fetch("ajax_lists");
				$data = array();
				$data['status'] = 1;
				$data['message'] = "获取成功";
				$data['info'] = $html;
				$data['next'] = $page+1;
				exit(json_encode($data));
			}
    	}
    	$demand = A("Api/Demand");
		$_POST['userid'] = $this->uid;
		$list = $demand->publishList();
		$this->assign("list",$list);
    	$this->display();
    }

    public function delpubish(){
        $demand = A("Api/Demand");
        $res = $demand->publishDel();
        if($res===true) ajaxmsg(1,"删除成功");
        else ajaxmsg(0,$res);
    }

    public function suggest(){
    	if(IS_POST){
    		$feedback = A("Api/Feedback");
    		$res = $feedback->feedbackadd();
    		if($res===true) ajaxmsg(1,"提交成功");
    		elseif($res===false) ajaxmsg(0,"提交失败，请稍后再试");
    		else ajaxmsg(0,$res);
    	}
    	$this->display();
    }

    public function score(){
    	$score = M("user")->getFieldById($this->uid,"integral");
    	$integral = A("Api/Integral");
    	$list = $integral->integralrule();
    	$this->assign("score",$score);
    	$this->assign("list",$list);
    	$this->display();
    }

    // public function score1(){
    //     $score = M("user")->getFieldById($this->uid,"integral");
    //     $integral = A("Api/Integral");
    //     $list = $integral->integralrule();
    //     var_dump($list);die;       
    // }

    public function collect(){
        if (!$_GET['sort']) $_GET['sort'] = 1;
        $demand = A("Api/Demand");
        $list = $demand->collectList();
        $this->assign("sort",$_GET['sort']?intval($_GET['sort']):1);
        $this->assign("list",$list);
        $this->display();
    }

}