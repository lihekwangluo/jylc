<?php
//注册用户，登陆......
class UserAction extends IndexAction{

	//引导页
	public function guidance(){
			$Gpsye = M("Gpsye");
			$list = $Gpsye->limit(1)->select();
			$pic = explode(',',$list['0']['pic']);
			get_obj_array('10000','成功！',$pic);
	}

	/*
		用户注册
		参数：
			手机号 mobile
			验证码 code
			密码1  pass1
			密码2  pass2
			邀请码 invitecode

	*/
	public function adduser(){

			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			if(!isMobile($mobile)){
				return get_obj_array('20000','请正确输入手机号！','');
			}
			$code = I('post.code')?I('post.code'):I('get.code');
			$pass1 = I('post.pass1')?I('post.pass1'):I('get.pass1');
			$pass2 = I('post.pass2')?I('post.pass2'):I('get.pass2');
			$invitecode = I('post.invitecode')?I('post.invitecode'):I('get.invitecode');
			$cidtoken = I('post.cidtoken')?I('post.cidtoken'):I('get.cidtoken');
			
			if(empty($mobile) || empty($code) || empty($pass1) || empty($pass2)){

				return get_obj_array('20000','参数不全！','');

			}else{
				$User = M("User");
				$Public = D('Public');
				$list = $User->where("mobile='$mobile'")->limit(1)->select();
				if(empty($list)){
					if($pass1 === $pass2){
						$Code = M("Code");
						$list = $Code->where("mobile='$mobile' and code='$code'")->limit(1)->select();
						if(!empty($list)){
							
							
							//注册写入数据库
							$token = getToken($mobile);
							$data = array();
							$data['token'] = $token;
							$data['mobile'] = $mobile;
							$data['pass'] = md5($pass1);
							$data['cidtoken'] = $cidtoken;
							$data['nickname'] = '用户未设置昵称';
							$data['addtime'] = time();
							$id=$User->add($data);

								if(!empty($id)){
									//注册环信
									/*$User_Model = D('User');
									$hxname = $User_Model->huanxinRegister('Janzhu_'.$id);
									if(!empty($hxname)){
										$Hxdata['hxname'] = $hxname;
										$User->where("id='$id'")->data($Hxdata)->save();
									}else{
										$User->where("id='$id'")->delete();
										return get_obj_array('20000','聊天系统注册失败！','');
									}*/
									//注册成功删除验证码
									$Code->where("mobile='$mobile'")->delete();
									//注册送积分
									$log = array();
									$log['userid'] = $id;
									$log['content'] = '新用户注册';
									$log['zhuangtai'] = 1;
									$log['status'] = 2;
									$Public->integrallog($log,'1');

									//最后判断是否有邀请码
									if($invitecode){
										//查询邀请码存在不存在
										$Invitecode = M("Invitecode");
										$list = $Invitecode->where("code = '$invitecode'")->limit(1)->select();
										if(!empty($list)){ //存在写入数据库
											
											$log = array();
											$log['userid'] = $list['0']['userid'];
											$log['content'] = '邀请注册';
											$log['zhuangtai'] = 1;
											$log['status'] = 1;
											$Public->integrallog($log,'1');
										}else{
											return get_obj_array('20000','邀请码不存在！','');
										}
									}

									return get_obj_array('10000','恭喜你注册成功，为了保证可以享受跟多服务功能请您及时完善个人信息资料！',$token);
							
								}else{
									return get_obj_array('20000','网络延迟！','');
								}

							}else{
								return get_obj_array('20000','验证码错误！','');
						}

					}else{
						return get_obj_array('20000','两次密码不一致！','');
					}
				}else{
					return get_obj_array('20000','该用户已注册！','');
				}
				
			}
	}

	/*
		用户企业验证
		参数：
			token  			用户唯一标示
			name   			用户名称
			idcard 			身份证号
			自定义名称 		企业照片,省份证
			type 			1是普通用户 2是企业用户


	*/
	public function usercard(){
			// 接收数据值
			$token = $this->uid;
			$name = I('post.name')?I('post.name'):I('get.name');
			$idcard = I('post.idcard')?I('post.idcard'):I('get.idcard');
			$type = I('post.type')?I('post.type'):I('get.type');
			$Public = D('Public');
			if(empty($token) || empty($name) || empty($idcard)|| empty($type)){

				return get_obj_array('20000','参数不全！','');

			}else{

				//用户登录判断

				$uerContent = $Public->userTokenCark($token);//," and renzheng = 0"
				if($uerContent[0]['renzheng']==1) return get_obj_array('20000','已经通过认证','');
				$imgNum = count($_FILES);
				$data = array();
				//图片上传判断
				if(($imgNum==2) && ($type==1)){
					$data['type'] = '1'; 
				}elseif(($imgNum==3) && ($type==2)){
					$data['type'] = '2'; 
				}else{
					return get_obj_array('20000','上传与认证不符合！','');
				}
				
				//图片上传
				$imgArr = $Public->imgFile();

				if($data['type'] == 1){
					$data['enterprisepic'] = '';
					$data['cardzpic'] = $imgArr['0'];
					$data['cardfpic'] = $imgArr['1'];

				}else{
					$data['enterprisepic'] = $imgArr['0'];
					$data['cardzpic'] = $imgArr['1'];
					$data['cardfpic'] = $imgArr['2'];
					
				}

				$Public->delImg($uerContent[0]['enterprisepic']);
				$Public->delImg($uerContent[0]['cardzpic']);
				$Public->delImg($uerContent[0]['cardfpic']);
				

				$data['name'] = $name;
				$data['idcard'] = $idcard;
				$User = M('User');
				$id = $uerContent[0]['id'];
				$User->where("id='$id'")->data($data)->save();
				return get_obj_array('10000',"上传成功",$token);

			}	
	}
	/*
		用户登录
		参数：
			mobile 	用户手机号
			pass 	用户密码
			version 版本

	*/
	public function userlogin(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$pass = I('post.pass')?I('post.pass'):I('get.pass');
			//$third = I('post.third')?I('post.third'):I('get.third');
			$qq = session_tp( "openid");//I("request.quid")
			$weibo = I("request.wuid");
			$weixin = I("request.cuid");
			$version = I('post.version')?I('post.version'):I('get.version');
			$terminal = I('post.terminal')?I('post.terminal'):I('get.terminal');
			if(empty($version) || empty($terminal)){
				return get_obj_array('20000','参数不全！','');
			}

			$User = M('User');
			$Public = D('Public');
			$ifexist = $User->where(" mobile='$mobile' ")->limit(1)->select();
			if(empty($ifexist)){
				return get_obj_array('20000','用户 '.$mobile.' 尚未注册');
			}
			if(empty($qq) && empty($weibo) && empty($weixin)){
				$list = $User->where("status = 1 and mobile='$mobile' and pass = '".md5($pass)."'")->limit(1)->select();
			}else{//后期添加的第三方登录
				$map = '';
				if($qq){
					$map['qq'] = $qq;
					$m = 'qq';
					$third = $qq;
				}else if($weibo){
					$map['weibo'] = $weibo;
					$m = 'weibo';
					$third = $weibo;
				}else if($weixin) {
					$map['weixin'] = $weixin;
					$m = 'weixin';
					$third = $weixin;
				}

				$list = $User->where($map)->limit(1)->select();
				
				if(empty($list)){
					$log = $fdata = array();
					//
					//注册写入数据库
					$fdata['mobile'] = $mobile;
					$fdata['pass'] = md5($pass1);
					$fdata['nickname'] = I("request.nickname")?I("request.nickname"):session_tp( "nickname");
					$fdata['cidtoken'] = $cidtoken;
					$fdata[$m] = $third;
					$fdata['addtime'] = time();
					$id=$User->add($fdata);
					if($id>0){
						/*$User_Model = D('User');
						$hxname = $User_Model->huanxinRegister('Janzhu_'.$id);
						if(!empty($hxname)){
							$Hxdata['hxname'] = $hxname;
							$User->where("id='$id'")->data($Hxdata)->save();
						}else{
							$User->where("id='$id'")->delete();
							return get_obj_array('20000','聊天系统注册失败！','');
						}*/
						//注册送积分
						$log['userid'] = $id;
						$log['content'] = '新用户注册';
						$log['zhuangtai'] = 1;
						$log['status'] = 2;
						$Public->integrallog($log,'1');
						$list = $User->where("id='$id'")->limit(1)->select();
					}else{
						return get_obj_array('20000',"登录失败",'');
					}
				}else{
					if($list['0']['status'] == 0){
						return get_obj_array('20000',"账号已被冻结",'');
					}
				}
				
			}
			
			if(empty($list)){
				return get_obj_array('20000',"登录失败",'');
			}else{
				//登录送积分
				$Public = D('Public');
				$User_Model = D('User');
				$xtime = strtotime(date('Y-m-d',time()));
				$gtime = $User_Model->getIntegralTime($list['0']['id']);
				$btime = $gtime['addtime'];
				if($xtime > $btime){ //判断是不是第二天
					$isLian = $xtime-$btime;
					$log = array();
					if($isLian <= 86400){
						$jifen = $Public->getSetIntegral('3'); //查询积分
						$log['addup'] = $gtime['addup']+1;
						if($log['addup']>=15){
							$log['num'] =  $jifen*12;
						}elseif($log['addup']>=7){
							$log['num'] =  $jifen*9;
						}elseif($log['addup']==2){
							$log['num'] =  $jifen*2;
						}elseif($log['addup']==3){
							$log['num'] =  $jifen*3;
						}else{
							$log['num'] =  $jifen*($log['addup']+1);
						}

					}
					$log['userid'] = $list['0']['id'];
					$log['content'] = '今日登录';
					$log['zhuangtai'] = 1;
					$log['status'] = 3;
					$Public->integrallog($log,'1');
				}
				//统计记录
				$User_Model->usert($list['0']['id'],$version,$terminal);
				
				$token = getToken($mobile);
				$array = array();
				$array['token'] = (string)$token;
				$User->where("id='".$list['0']['id']."'")->data($array)->save();
				$array['uid'] = (string)$list['0']['id'];	
				$array['pic'] = (string)$list['0']['pic'];								
				$array['mobile'] = (string)$list['0']['mobile'];
				$array['name'] = (string)$list['0']['name'];
				$array['nickname'] = (string)$list['0']['nickname'];
				$array['hxname'] = (string)$list['0']['hxname'];
				
				return get_obj_array('10000',"登录成功",$array);
			}
	}
	/*
		用户忘记密码
		参数：
			mobile 	用户手机号
			pass1 	用户密码
			pass2 	用户密码
			code 	验证码

	*/
	public function userforget(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$pass1 = I('post.pass1')?I('post.pass1'):I('get.pass1');
			$pass2 = I('post.pass2')?I('post.pass2'):I('get.pass2');
			$code = I('post.code')?I('post.code'):I('get.code');
			
			if(empty($mobile) || empty($pass1) || empty($pass2) || empty($code)){

				return get_obj_array('20000',"参数不全！",'');

			}else{
				if($pass1 === $pass2){
					$Code = M("Code");

						$list = $Code->where("mobile='$mobile' and code='$code'")->limit(1)->select();
						if(!empty($list)){
							$token = getToken($mobile);
							$data['pass'] = md5($pass1);
							$data['token'] = $token;
							$User = M("User");
							$User->where("mobile='".$mobile."'")->data($data)->save();
							//删除验证码
							$Code->where("mobile='$mobile'")->delete();
							return get_obj_array('10000','修改成功！',$token);
						}else{
							return get_obj_array('20000','验证码错误！','');
						}
				}else{
					return get_obj_array('20000',"两次密码不一致！",'');
				}
			}

	}
	//更换手机号
	/*
		参数：
			mobile 	旧手机号
			pass 	登录密码  
			mobile2 新手机号
			code 	验证码
	*/
	public function usermobiletrade(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$pass = I('post.pass')?I('post.pass'):I('get.pass');
			$mobile2 = I('post.mobile2')?I('post.mobile2'):I('get.mobile2');
			$code = I('post.code')?I('post.code'):I('get.code');
			if(empty($mobile) || empty($pass) || empty($mobile2) || empty($code)){

				return get_obj_array('20000',"参数不全！",'');

			}else{
				if($mobile == $mobile2){

					return get_obj_array('20000',"新手机号不能与旧手机号相同！",'');
				}

				$Code = M("Code");
				$list = $Code->where("mobile='$mobile' and code='$code'")->limit(1)->select();
				if(!empty($list)){
					$User = M('User');
					$list1 = $User->where("mobile='$mobile2'")->limit(1)->select();

					if(empty($list1)){
						$list = $User->where("status = 1 and mobile='$mobile' and pass = '".md5($pass)."'")->limit(1)->select();
						if(!empty($list)){
							$data = array();
							$data['mobile'] = $mobile2;
							$User->where("id='".$list['0']['id']."'")->data($data)->save();
							//删除验证码
							$Code->where("mobile='$mobile'")->delete();
							return get_obj_array('10000','修改成功！',$list['0']['token']);
						}else{
							return get_obj_array('20000','用户名密码不匹配！','');
						}
					}else{
						return get_obj_array('20000','新手机号已经被注册！','');
					}
					
				}else{
					return get_obj_array('20000','验证码错误！','');
				}

			}
	}

	//修改密码
	/*
		参数：
			mobile 手机号
			pass1  旧密码
			pass2  新密码
			pass3  重复新密码
	*/
	public function userupdatepass(){
			$mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$pass1 = I('post.pass1')?I('post.pass1'):I('get.pass1');
			$pass2 = I('post.pass2')?I('post.pass2'):I('get.pass2');
			$pass3 = I('post.pass3')?I('post.pass3'):I('get.pass3');
			if(empty($mobile) || empty($pass1) || empty($pass2) || empty($pass2)){

				return get_obj_array('20000','参数不全！','');
			}else{
				if($pass1 === $pass2){
					return get_obj_array('20000',"新密码和旧密码太过相似！",'');
				}else{
					if($pass2 === $pass3){
						$User = M('User');
						$list = $User->where("status = 1 and mobile='$mobile' and pass = '".md5($pass1)."'")->limit(1)->select();
						if(!empty($list)){
							$data = array();
							$data['pass'] = md5($pass2);
							$User->where("id='".$list['0']['id']."'")->data($data)->save();
							return get_obj_array('10000','修改成功！',$list['0']['token']);
						}else{
							return get_obj_array('20000','用户名密码不匹配！','');
						}
					}else{
						return get_obj_array('20000',"两次密码不一致！",'');
					}
					
				}	
			}
	}
	
	//获取个人资料
	/*
		参数：
			token 	用户唯一标示
	*/
	public function usermessage(){

			$token = $this->uid;
			
				if(empty($token)){
					return get_obj_array('20000',"参数不全！",'');
				}else{
					$Public = D('Public');
					$uerContent = $Public->userTokenCark($token);
					if(!empty($uerContent)){
						$root = array();
						$root['uid'] = (string)$uerContent['0']['id'];
						$root['pic'] = (string)$uerContent['0']['pic'];
						$root['mobile'] = (string)$uerContent['0']['mobile'];
						$root['name'] = (string)$uerContent['0']['name'];
						$root['nickname'] = (string)$uerContent['0']['nickname'];
						$root['sex'] = (string)$uerContent['0']['sex'];
						$root['chusheng'] = (string)$uerContent['0']['chusheng'];
						$root['type'] = (string)$uerContent['0']['type'];
						$root['renzheng'] = (string)$uerContent['0']['renzheng'];
						$root['enterprisepic'] = (string)$uerContent['0']['enterprisepic'];
						$root['cardzpic'] = (string)$uerContent['0']['cardzpic'];
						$root['cardfpic'] = (string)$uerContent['0']['cardfpic'];
						$root['integral'] = (string)$uerContent['0']['integral'];
						$root['price'] = (string)$uerContent['0']['price'];
						$root['idcard'] = (string)$uerContent['0']['idcard'];
						$root['address'] = (string)$uerContent['0']['address'];
						$root['rterrace'] = (string)$uerContent['0']['rterrace'];
						//查询这个用户的工种
						$User = D('User');
						$root['craft'] = $User->selectUserCraft($uerContent['0']['id']);
						$array['hxname'] = (string)$list['0']['hxname'];
						return $root;
					}else{
						return get_obj_array('20000',"验证失败",'');
					}

				}
	}

	/*
		修改个人资料
		参数：
			moblie 		第三方登录没有写手机号
			token       用户唯一标示
						头像自己定义
			nickname    名称
			chusheng    出生日期
			sex			性别
			address 	居住地址
			craftid     工种id 多个用,分开

	*/
	public function useredit(){
		$data = array();
		$token = $this->uid;
		$moblie = I('post.moblie')?I('post.moblie'):I('get.moblie');
		$nickname = I('post.nickname')?I('post.nickname'):I('get.nickname');
		$chusheng = I('post.chusheng')?I('post.chusheng'):I('get.chusheng');
		$sex = I('post.sex')?I('post.sex'):I('get.sex');
		$address = I('post.address')?I('post.address'):I('get.address');
		if(!empty($nickname)){
			$data['nickname'] = $nickname;
		}
		if(!empty($chusheng)){
			$data['chusheng'] = $chusheng;
		}
		if(!empty($sex)){
			$data['sex'] = $sex;
		}
		if(!empty($address)){
			$data['address'] = $address;
		}

		$craftid = I('post.craftid')?I('post.craftid'):I('get.craftid');
		$Public = D('Public');
		$uerContent = $Public->userTokenCark($token);
		$pic = $uerContent['0']['pic'];
		$id = $uerContent['0']['id'];
		if(empty($uerContent['0']['moblie']) && $uerContent['0']['third']){
			$data['moblie'] = $moblie;
		}
		
		if(!empty($_FILES)){
			$imgArr = $Public->imgFile();
			
			if(!empty($imgArr)){
				$data['pic'] = $imgArr['0'];
				$pic = $data['pic'];
				$Public->delImg($uerContent['0']['pic']);
			}
		}
		

		$User = M('User');
		$User->where("id='".$id."'")->data($data)->save();
		//写入工种
		if($craftid){
			$Usercraft = D('Usercraft');
			$Usercraft->where("userid='$id'")->delete();
			$craftid = explode(',',trim($craftid,','));
			foreach ($craftid as $v) {
				$data = array();
				$data['userid'] = $id;
				$data['craftid'] = $v;
				$Usercraft->add($data);
			}
		}
		
		//返回参数
		$root['token'] = (string)$token;
		$root['pic'] = $pic;
		$root['mobile'] = (string)$uerContent['0']['mobile'];
		$root['name'] = (string)$uerContent['0']['name'];
		return get_obj_array('10000',"成功",array($root));
	}
	//获取邀请码
	/*
		参数：
			token 
	*/
	public function invitecode(){

		$token = I('post.token')?I('post.token'):I('get.token');
		if(empty($token)){
			get_obj_array('20000',"参数不全！",'');
		}else{
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$Invitecode = M("Invitecode");
			$list = $Invitecode->where("userid='".$uerContent['0']['id']."'")->limit(1)->select();
			if(empty($list)){ //如果不存在则创建
				$data = array();
				$code = inviteCode($uerContent['0']['id']);
				$data['userid'] = $uerContent['0']['id'];
				$data['code'] = $code;
				$data['addtime'] = time();
				$Invitecode->add($data);
			}else{
				$code = $list['0']['code'];
			}
			get_obj_array('10000',"成功！",$code);
		}
		

	}
	//关于我们
	public function aboutus(){
		$Aboutus = M("Aboutus");
		$list = $Aboutus->where("id='1'")->limit(1)->select();
		$root = array();
		foreach($list as $key => $value) {
			$root['pic'] = (string)$value['pic'];
			$root['content'] = explode("\r\n",trim($value['content'],"\r\n"));
			$root['moblie'] = (string)$value['moblie'];
			$root['username'] = (string)$value['username'];
			$root['mail'] = (string)$value['mail'];
			$root['weixin'] = (string)$value['weixin'];
			$root['address'] = (string)$value['address'];

		}
		get_obj_array('10000',"成功！",array($root));

	}
	//版本介绍
	public function versions(){

		$Setsystem = M("Setsystem");
		$list = $Setsystem->where("id='1'")->limit(1)->select();
		$download=explode("#",$list['0']['download']);
		$result=array(
				'versions'=>$list['0']['versions'],
				'download'=>$download[1]
		);
		get_obj_array('10000',"成功！",$result);
	}

	//版本升级
	public function updatever(){

		$Setsystem = M("Setsystem");
		$list = $Setsystem->where("id='1'")->limit(1)->select();
		get_obj_array('10000',"成功！",explode("\r\n",$list['0']['versions']));
	}

	//协议
	public function treaty(){

		$Setsystem = M("Setsystem");
		$type = I('post.type')?I('post.type'):I('get.type');
		$list = $Setsystem->where("id='1'")->limit(1)->select();
		if(empty($type)){
			$root = explode("\r\n",$list['0']['pourtreaty']);
		}else{
			$root = explode("\r\n",$list['0']['outtreaty']);
		}
		
		
		get_obj_array('10000',"成功！",$root);

	}
	//传入个推 cidtoken
	public function cidtoken(){
		$token = I('post.token')?I('post.token'):I('get.token');
		$cidtoken = I('post.cidtoken')?I('post.cidtoken'):I('get.cidtoken');
		if($token || $cidtoken){
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$id = $uerContent['0']['id']; 
			$data['cidtoken'] = $cidtoken;
			$User = M('User');
			$User->where("id = '$id'")->data($data)->save();
			get_obj_array('10000',"上传成功！",$token);
		}else{
			get_obj_array('20000',"参数不全！",'');
		}
		
	}

}