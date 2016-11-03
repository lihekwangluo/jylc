<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends HcommonAction {

	public function index(){
		if(IS_POST){
			$status = intval($_POST['status']);
			$page = intval($_POST['page'])?intval($_POST['page']):1;
			if(in_array($status,array(1,2,3,4,5))) $list = $this->getList($status);
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

		//热门搜索
		$Searchthe = M('searchthe');
		$s_list = $Searchthe->where("LENGTH(name)>= 6")->field('name')->order('num desc')->limit(19)->select();
		$this->assign("s_list",$s_list);
		//获取1级地区
		$a_list = M("area")->field("area_id as id,area_name")->where("area_deep=1")->order("area_id")->select();
		$this->assign("a_list",$a_list);
		//获取工种列表
		$t_list = M("craft")->field("id,name")->where("status=1")->order("weights,id")->select();
		$this->assign("t_list",$t_list);
		$this->assign("word",cookie_tp("history"));
		$this->display();
	}

	public function getList($status){
		$demand = A("Api/Demand");
		$_POST['status'] = $status;
		$info = $demand->publishList();
		return $info;
	}
	public function search(){
    	if(IS_POST){
    		$page = intval($_POST['page'])?intval($_POST['page']):1;
    		$demand = A("Api/Demand");
			$list = $demand->publishList();
			
			if(!is_array($list)) {
				exit(json_encode(array("status"=>0,"message"=>"没有了")));
			}else{
				$this->assign("list",$list);
				$html = $this->fetch("ajax_search");
				$data = array();
				$data['status'] = 1;
				$data['message'] = "获取成功";
				$data['info'] = $html;
				$data['next'] = $page+1;
				exit(json_encode($data));
			}
    	}

    	if(!empty($_GET['soso'])){
    		$history = cookie_tp("search");
			if(count($history)<=6){
				$history[] = I("request.soso");
				cookie_tp("history",$history);
			}
			$demand = A("Api/Demand");
			$list = $demand->publishList();
			$this->assign("list",$list);
			$this->assign("title",I("request.soso"));
    	}
    	$this->display();
    }

    public function forgetpwd(){
    	if(IS_POST){
    		$user = A("Api/User");
    		$res = $user->userforget();
    		if($res===true) ajaxmsg(1,"修改成功");
    		else ajaxmsg(0,$res);
    	}
    	$this->display();
    }
}