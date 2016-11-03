<?php
// 本类由系统自动生成，仅供测试用途
class PublishAction extends HcommonAction {

	public function index(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}
		$this->display();
	}

	public function duizhaoren(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}
		if(IS_POST) $this->post();
		$this->get_gz();
		$this->display();
	}

	public function huozhaodui(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}
		if(IS_POST) $this->post();
		$this->get_gz();
		$this->get_item();
		$this->display();
	}

	public function duizhaohuo(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}

		//判断用户是否认证
		$User= A("Api/User");
		$array=$User->usermessage($this->uid);
		$renzheng=$array['renzheng'];
		$url= $this->_root."/Member/index/renzheng";
		//echo $url;exit;
		switch ($renzheng) {
			case '1':
				$this->display();
				break;
			case '2':
				echo "<script>alert('您的资料审核未通过，请重新审核');location.href='$url'</script>";
				break;
			case '3':
				echo "<script>alert('您的资料正在审核中，请稍后')</script>";
				break;
			default :
				echo "<script>alert('您的资料审核未通过，请重新审核');location.href='$url'</script>";
				break;
		}
		if(IS_POST) $this->post();
		$this->get_gz();
		//$this->display();
	}

	public function fucai(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}
		$User= A("Api/User");
		$array=$User->usermessage($this->uid);
		$renzheng=$array['renzheng'];
		$url= $this->_root."/Member/index/renzheng";
		//echo $url;exit;
		switch ($renzheng) {
			case '1':
				$this->display();
				break;
			case '2':
				echo "<script>alert('您的资料审核未通过，请重新审核');location.href='$url'</script>";
				break;
			case '3':
				echo "<script>alert('您的资料正在审核中，请稍后')</script>";
				break;
			default :
				echo "<script>alert('您的资料审核未通过，请重新审核');location.href='$url'</script>";
				break;
		}
		if(IS_POST) {			
			$demand = A("Api/Demand");
			$res = $demand->publish();
			if($res===true) echo true;
			else echo $res;
			exit;
		}
		$this->get_gz();
		$this->get_alcor();
		//$this->display();
	}

	public function shebei(){
		if(!$this->uid){
			redirect_tp( $this->_root."/login");
			exit;
		}
		if(IS_POST) $this->post();
		$this->get_device();
		$this->display();
	}

	public function collect(){
		if(!$this->uid) exit("请登录");
		if(IS_POST){
			$demand = A("Api/Demand");
			$res = $demand->collect();
			exit($res);
		}
	}

	public function edit(){//1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$demand = A("Api/Demand");
		$arr = $demand->publishList();
		//var_dump($arr);die;
		if(!is_array($arr)) exit("没有了");
		if($arr[0]['status']==1) {
			$tpl = "shebei";
			$this->get_device();
		}
		else if($arr[0]['status']==2) {
			$tpl = "huozhaodui";
			$this->get_gz();
			$this->get_item();
		}
		else if($arr[0]['status']==3) {
			$tpl = "duizhaohuo";	
			$this->get_gz();
		}
		else if($arr[0]['status']==4) {
			$tpl = "duizhaoren";
			$this->get_gz();
		}
		else if($arr[0]['status']==5) {
			$tpl = "fucai";
			$this->get_alcor();
		}
		$this->assign("vo",$arr[0]);
		$this->display($tpl);
	}

	public function jubao(){
		if(IS_POST){
			$demand = A("Api/Demand");
			$res = $demand->reason();
			if($res===true) ajaxmsg(1,"举报成功");
			else ajaxmsg(0,$res);
		}
		$this->assign("pid",intval($_GET['pid']));
		$this->assign("title",I("get.title"));
		$this->display();
	}

	public function regin(){
        $name = isset($_GET['name'])?$_GET['name']:0;
        $id = intval($_GET['id']);
        if($id) {
            $alist = M("area")->field("area_id,area_name")->where("area_parent_id={$id}")->select();
        }else{
            $alist = M("area")->field("area_id,area_name")->where("area_deep=1")->select();
        }
        $html = '';
        foreach ($alist as $key => $v) {
            $html .= "<option value=".$v['area_id'].">".$v['area_name']."</option>";
        }
        ajaxmsg(1,"OK",$html);
    }

	public function detail(){
		$demand = A("Api/Demand");
		$vo = $demand->publishList();
		if(!is_array($vo)) exit("<script>alert('数据有误');window.history.go(-1);</script>");
		if(is_array($vo[0]['craft'])) {
			$craft = '';
			foreach ($vo[0]['craft'] as $key => $v) {
				$craft .= $v['name']." ";
			}
			$vo[0]['craft'] = $craft;
		}
		//var_dump($vo[0]);die;
		$this->assign("vo",$vo[0]);
		$this->display();
	}

	public function other(){
        if(IS_POST){
            $page = intval($_POST['page'])?intval($_POST['page']):1;
            $demand = A("Api/Demand");
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
        $list = $demand->publishList();
        $this->assign("list",$list);
        $this->display();
    }

	protected function post(){
		$demand = A("Api/Demand");
		$res = $demand->publish();
		if($res===true) ajaxmsg(1,"发布成功");
		else ajaxmsg(0,$res);
	}

	protected function get_gz(){
		$t_list = M("craft")->field("id,name")->where("status=1")->order("weights,id ")->select();
		$this->assign("t_list",$t_list);
	}

	protected function get_item(){
		$i_list = M("mold")->field("id,name")->where("status=1")->select(); 
		$this->assign("i_list",$i_list);
	}

	protected function get_device(){
		$i_list = M("device")->field("id,name")->where("status=1")->select();
		$this->assign("d_list",$i_list);
	}

	protected function get_alcor(){
		$a_list = M("alcor")->field("id,name")->where("status=1")->select();
		$this->assign("a_list",$a_list);
	}
}