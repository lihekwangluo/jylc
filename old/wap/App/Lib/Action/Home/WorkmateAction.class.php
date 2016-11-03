<?php
// 本类由系统自动生成，仅供测试用途
class WorkmateAction extends HcommonAction {

	public function index(){
		if(IS_POST){
            $page = intval($_POST['page'])?intval($_POST['page']):1;
            $workmate = A("Api/Workmate1");
            $list = $workmate->workmateList();
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
        $work = A("Api/Workmate1");
        $list = $work->workmateList();
        $this->assign("list",$list);
        $this->assign("status",intval($_GET['status']));
        $this->display();
	}

    public function detail(){
        $id = intval(I("get.id"));
        $vo = M("workmate")->find($id);
        $vo['addtime'] = (string)date('Y-m-d H:i',$vo['addtime']);
        $vo['pics'] = explode(",",$vo['pic']);
        if($vo['userid']) $vo['nickname'] = M("user")->getFieldById($vo['userid'],"nickname");
        $this->assign("vo",$vo);
        $this->display();
    }
}