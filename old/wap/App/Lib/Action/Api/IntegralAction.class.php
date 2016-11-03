<?php
//积分规则，积分商品，积分商品交易......
class IntegralAction extends IndexAction{
	//积分规则
	public function integralrule(){
		$Setintegral = M("Setintegral");
		$vo = $Setintegral->where("id = '1'")->find();
		$root = explode("\r\n",trim($vo['content'],"\r\n"));
		//get_obj_array('10000','成功！',array((object)$root));
		return $root;
	}

	public function getIntegral(){
		$token = I("token");
		$Public = D('Public');
		$uerContent = $Public->userTokenCark($token);
		get_obj_array('10000','成功！',$uerContent[0]['integral']);
	}
	//积分商品列表
	//id 商品id
	public function productList(){
		$Product = M("Product");
		$productid = intval(I('post.productid')?I('post.productid'):I('get.productid'));
		if($productid>0){

			$list = $Product->where("id='$productid'")->limit('1')->select();
		}else{
			
			$limit = pageLimit();
			$list = $Product->order('id desc')->limit($limit)->select();
		}
		
		if(!empty($list)){
			foreach ($list as $key => $value) {
				$list[$key]['pid'] = (string)$value['id'];
				$list[$key]['title'] = (string)$value['title'];
				$list[$key]['pic'] = (string)$value['pic'];
				$list[$key]['integral'] = (string)$value['integral'];
				$list[$key]['num'] = (string)$value['num'];
				$list[$key]['addtime'] = (string)date('Y-m-d',$value['addtime']);
				$list[$key]['snum'] = (string)$value['snum'];
				$list[$key]['content'] = explode("\r\n",trim($value['content'],"\r\n"));
			}
			//get_obj_array('10000','成功！',$list);
			return $list;
		}else{
			return get_obj_array('20000','数据不存在','');
		}

	}
	//积分商品购买
	/*
		参数：
			token 		用户唯一标示
			productid   商品id
			num 		兑换数量
			username 	兑换人姓名
			mobile 		兑换人手机号
			address     兑换人地址
			address2    兑换人详细地址
	*/
	public function productbuy(){

			$productid = I('post.productid')?I('post.productid'):I('get.productid');
			$num = intval(I('post.num')?I('post.num'):I('get.num'));
			$token = $this->uid;
			$username = I('post.username')?I('post.username'):I('get.username');
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$address = I('post.address')?I('post.address'):I('get.address');
			$address2 = I('post.address2')?I('post.address2'):I('get.address2');
			$num = $num>0?$num:'1';

			if(empty($productid) || empty($num) || empty($token) || empty($username) || empty($mobile) || empty($address) || empty($address2)){
				return get_obj_array('20000','参数不全！','');
			}else{
				$Public = D('Public');
				$Product = M('Product');
				$uerContent = $Public->userTokenCark($token);
					$productList = $Product->where("id = '$productid'")->limit(1)->select();
					$zintegral =  $productList['0']['integral']*$num;
					if(!empty($productList)){
						if($uerContent['0']['integral']>=$zintegral){ //判断积分

							if($productList['0']['snum']>=$num){ //判断数量
								//组合交易数据
								$array = array();
								$array['userid'] = $uerContent['0']['id'];
								$array['content'] = '兑换'.$productList['0']['title'];
								$array['zhuangtai'] = 0;
								$array['status'] = 4;
								$array['productid'] = $productList['0']['id'];
								$array['mobile'] = $mobile;
								$array['address'] = $address;
								$array['text'] = $address2;
								$array['num'] = $zintegral;
								$array['username'] = $username;
								$array['number'] = $num;
								$Public->integrallog($array);
								$Product = M();
								$sql = "update zj_product set snum = snum-$num where id= '".$productList['0']['id']."'";
								$Product->query($sql);
								return get_obj_array('10000','交易成功',$token);
							}else{
								return get_obj_array('20000','数量不足','');
							}
						
						}else{
							return get_obj_array('20000','用户积分不足！','');
						}
					}else{
						return get_obj_array('20000','商品不存在！','');
					}
						

			}
			
	}
	//用户获取兑换积分列表
	/*
		参数：
			token 		用户唯一标示
	*/
	public function conversionList(){
			$token = $this->uid;
			$id = I('post.id')?I('post.id'):I('get.id');
			if(empty($token)){
				return get_obj_array('20000','参数不全！','');
			}else{
				$root = array();
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				$Integrallog = M('Integrallog');
				if($id>0){

					$list = $Integrallog->where("id = '$id' and sendout != 0 and status = '4' and userid ='".$uerContent['0']['id']."'")->limit('1')->select();
				}else{
					
					
					$limit = pageLimit();
					$sql = "SELECT i.*,p.pic FROM zj_integrallog as i 
							INNER JOIN zj_product as p
							ON i.productid = p.id
							WHERE i.sendout != 0 and i.status = '4' and i.userid ='".$uerContent['0']['id']."' group by i.id desc limit ".$limit;
					$Integrallog = M();
					$list = $Integrallog->query($sql);
				}

				if(!empty($list)){
					foreach($list as $key => $value) {
						$root[$key]['cid'] = (string)$value['id'];
						$root[$key]['productid'] = (string)$value['productid'];
						$root[$key]['userid'] = (string)$value['userid'];
						$root[$key]['content'] = (string)$value['content'];
						$root[$key]['zhuangtai'] = (string)$value['zhuangtai'];
						$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
						$root[$key]['num'] = (string)$value['num'];
						$root[$key]['username'] = (string)$value['username'];
						$root[$key]['mobile'] = (string)$value['mobile'];
						$root[$key]['address'] = (string)$value['address'];
						$root[$key]['address2'] = (string)$value['text'];
						$root[$key]['sendout'] = (string)$value['sendout'];
						$root[$key]['pic'] = (string)$value['pic'];
					
					}
					return $root;
				}else{
					return get_obj_array('20000','数据不存在','');
				}
				
			}
	}
	//获取积分详情
	public function integralList(){
		$token = I('post.token')?I('post.token'):I('get.token');

		$limit = pageLimit();

		if(empty($token)){
			get_obj_array('20000','参数不全！','');
		}else{
			$root = array();
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$Integrallog = M('Integrallog');
			$list = $Integrallog->where("sendout != 0 and userid ='".$uerContent['0']['id']."'")->order('id desc')->limit($limit)->select();
			if(!empty($list)){
				foreach ($list as $key => $value) {
					$root[$key]['content'] = (string)$value['content'];
					$root[$key]['zhuangtai'] = (string)$value['zhuangtai'];
					$root[$key]['addtime'] = date('Y-m-d H:i',$value['addtime']);
					$root[$key]['num'] = $value['num'];
				}
				return $root;
			}else{
				return get_obj_array('20000','数据不存在','');
			}
		}

	}
	//积分提交
	/*
			token 登录唯一标示
			mark 标示为
				space 	空间分享：新浪微博，微信朋友圈，QQ空间
				friend 	好友分享：微信好友，qq 好友
				project 职位分享

	*/

	public function integralSub(){

			$token = I('post.token')?I('post.token'):I('get.token');
			$mark = I('post.mark')?I('post.mark'):I('get.mark');
			if(empty($token) || empty($mark)){
					get_obj_array('20000','参数不全！','');
			}else{
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				$data = array();
				if($mark == 'space'){
					$data['content'] = '空间分享';
					$data['status'] = '6';
				}elseif($mark == 'friend'){
					$data['content'] = '好友分享';
					$data['status'] = '7';
				}elseif($mark == 'project'){
					$data['content'] = '职位分享';
					$data['status'] = '8';
				}else{
					get_obj_array('20000','非法请求！','');
				}

				$User_Model = D('User');
				$xtime = strtotime(date('Y-m-d',time()));
				$gtime = $User_Model->getIntegralTime($uerContent['0']['id'],$data['status']);
				$btime = $gtime['addtime']?$gtime['addtime']:'0';
				if($xtime > $btime){ //判断是不是第二天
					$data['userid'] = $uerContent['0']['id'];
					$data['zhuangtai'] = '1';
					$Public->integrallog($data,'1');
				}
				get_obj_array('10000','分享成功！',$token);
			}	

	}

}