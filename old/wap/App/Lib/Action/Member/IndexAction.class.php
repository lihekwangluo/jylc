<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends McommonAction {

    public function index(){
    	$vo = M("user")->field("id,nickname,mobile,pic")->find($this->uid);
    	$this->assign("vo",$vo);
		$this->display();
    }

    public function about(){
    	$this->display();
    }

    public function renzheng(){
    	if(IS_POST){
    		$user = A("Api/User");
    		$res = $user->usercard();
    		if($res===true){
    			echo true;
    		}else{
    			echo $res;
    		}
    		die;
    	}
        $vo = M("user")->find($this->uid);
        $this->assign("vo",$vo);
    	$this->assign("type",$vo['type']);
    	$this->display();
    }

    public function exchange(){
        $integral = A("Api/Integral");
        $list = $integral->productList();
        $this->assign("list",$list);
        $this->display();
    }

    public function record(){
        $integral = A("Api/Integral");
        $list = $integral->conversionList();
        $this->assign("list",$list);
        $this->display();
    }

    public function detail(){
        if(IS_POST){
            $integral = A("Api/Integral");
            $res = $integral->productbuy();
            if($res===true) ajaxmsg(1,"兑换成功");
            else ajaxmsg(0,$res);
        }
        $integral = A("Api/Integral");
        $list = $integral->productList();
        $this->assign("vo",$list[0]);
        $this->display();
    }
}