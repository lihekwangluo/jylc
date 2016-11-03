<?php

class RecordAction extends Action{

		public $token;
		public $status;
		public $fuid;
		public $price;
		public $overtime;
		public $station;
		public $startime;
		public $endtime;
		public $square;
		public $cid;
		public $content;
		public $type;
		public $mobile;
		public $name;

		function __construct(){
			parent::__construct();
			$this->token = I('post.token')?I('post.token'):I('get.token');
			$this->status = I('post.status')?I('post.status'):I('get.status');
			$this->fuid = intval(I('post.fuid')?I('post.fuid'):I('get.fuid'));
			$this->price = floatval(I('post.price')?I('post.price'):I('get.price'));
			$this->overtime = I('post.overtime')?I('post.overtime'):I('get.overtime');
			$this->station = I('post.station')?I('post.station'):I('get.station');
			$this->startime = strtotime(I('post.startime')?I('post.startime'):I('get.startime'));
			$this->endtime = strtotime(I('post.endtime')?I('post.endtime'):I('get.endtime'));
			$this->square = I('post.square')?I('post.square'):I('get.square');
			$this->cid = intval(I('post.cid')?I('post.cid'):I('get.cid'));
			$this->content = I('post.content')?I('post.content'):I('get.content');
			$this->type = intval(I('post.type')?I('post.type'):I('get.type'));
			$this->mobile = I('post.mobile')?I('post.mobile'):I('get.mobile');
			$this->name = I('post.name')?I('post.name'):I('get.name');
		}

		/*
			建立关系
			参数：

				token 		用户标示
				type 		1我与工人/2我与包工头
				//通讯录
				mobile 手机号 可以传多个用,号隔开
				name 	姓名  可以传多个用,号隔开 与手机号对应 


		*/
		public function relation(){

			if(empty($this->token) || empty($this->mobile) || empty($this->type) || empty($this->name)){
				get_obj_array('20000',"参数不全",'');
			}else{
				$mobile = explode(',',trim($this->mobile,','));
				$name = explode(',',trim($this->name,','));
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($this->token);
				foreach ($mobile as $k => $v) {
					if(isMobile($v)){
						$data = array();
						$data['zuid'] = $uerContent['0']['id'];
						$Relation = M('Relation');
						$cRelation = $Relation -> where('mobile = "'.$v.'" and zuid = "'.$data['zuid'].'" and type = "'.$this->type.'"')->limit(1)->select();
						if(empty($cRelation)){
							// $data['fuid'] = $this->fuid;
							$data['type'] = $this->type;
							$data['addtime'] = time();
							$data['mobile'] = $v;
							$data['name'] = $name[$k];
							$Relation = M('Relation');
							$Relation -> add($data);
						}
					}
					
					
				}
				$root = array(
								'token'=>$this->token,
								'type'=>(string)$this->type

						);
				get_obj_array('10000',"成功",$root);
			}
			
		}


		/*
			删除关系
			token 		用户标示
			fuid 		包工头id/用户id 不是用户表id
			status 		1是删除 2是清空
			type 		1我与工人/2我与包工头
		*/
		public function relationDel(){
				if(empty($this->token) || empty($this->fuid) || empty($this->type)){
					get_obj_array('20000',"参数不全",'');
				}else{
					$Public = D('Public');
					$uerContent = $Public->userTokenCark($this->token);
					$zuid = $uerContent['0']['id'];
					$fuid = $this->fuid;
					if($this->status == 1){
						$Relation = D('Relation');
						$Relation->where("zuid = '$zuid' and id = '$fuid' and type='".$this->type."'")->delete();
					}
					$Record = D('Record');
					$Record->where("zuid = '$zuid' and fuid = '$fuid' and type='".$this->type."'")->delete();
					get_obj_array('10000',"操作成功",$this->token);
				}
		}


		/*
			添加 记功工人
			参数：
				token 		用户标示
				status 		1记点/2包工/3借支
				fuid    	包工头id/用户id 不是用户表id
				price 		工资
				overtime    加班/小时
				station 	岗位/描述

				startime 	开始时间
				endtime 	结束时间
				square 		面积
				content 	描述
				type 		1我与工人/2我与包工头
				cid 		内容id

		*/
		public function recordadd(){

			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$zuid = $uerContent['0']['id'];
			$Record = M('Record');
			if(empty($this->cid)){
				$Relation = M('Relation');
				$RelationContet = $Relation->where('zuid = "'.$zuid.'" and id = "'.$this->fuid.'" and type="'.$this->type.'"')->limit(1)->select();
				if(empty($RelationContet)){
					get_obj_array('20000',"请添加工人或包工头！",'');
				}
			}
			
			if(!empty($this->fuid) || !empty($this->cid)){
				if(!empty($this->cid)){
					$RecordContet = $Record->where('zuid = "'.$zuid.'" and id = "'.$this->cid.'"')->limit(1)->select();
					if(!empty($RecordContet)){
						$this->status = $RecordContet['0']['status'];
					}else{
						get_obj_array('20000',"数据不存在！",'');
					}
					
				}
			
				if($this->status <= 3){ 
					$data = array();
					if(!empty($this->fuid)){
						$data['fuid'] = $this->fuid;
					}
					if(!empty($this->price)){
						if($this->status == 3){
							$data['jprice'] = $this->price;
						}else{
							$data['price'] = $this->price;
						}
						
					}
					if(!empty($this->overtime)){
						$data['overtime'] = $this->overtime;
					}
					if(!empty($this->station)){
						$data['station'] = $this->station;
					}
					if(!empty($this->startime)){
						$data['startime'] = $this->startime;
					}
					if(!empty($this->endtime)){
						$data['endtime'] = $this->endtime;
					}
					if(!empty($this->square)){
						$data['square'] = $this->square;
					}
					
					if(!empty($this->content)){
						$data['content'] = $this->content;
					}
					if(empty($this->cid)){
						$data['addtime'] = time();
						if(empty($zuid) || empty($this->fuid) || empty($this->status) || empty($this->type)){
							get_obj_array('20000',"参数不全",'');
						}
						$data['zuid'] = $zuid;
						$data['fuid'] = $this->fuid;
						$data['status'] = $this->status;
						$data['type'] = $this->type;
						$Record -> add($data);
					}else{
						$Record->where("id='".$this->cid."' and zuid = '$zuid'")->data($data)->save();
					}
					$root = array(
								'token'=>$this->token,
								'type'=>(string)$this->type?$this->type:$RecordContet['0']['type']

						);
					get_obj_array('10000',"成功",$root);
				}else{

					get_obj_array('20000',"非法请求",'');

				}
			}else{
				get_obj_array('20000',"参数不全",'');
			}

		}

		/*

			记工列表
				参数：
				token 		用户标示
				type 		1我与工人/2我与包工头
				fuid 		包工头id/用户id 不是用户表id
		*/
		public function recordList(){
			
			if(empty($this->type) || empty($this->token)){
				get_obj_array('20000',"参数不全",'');
			}
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$zuid = $uerContent['0']['id'];
			$limit = ' LIMIT ' .pageLimit();
			$Record = D('Record');
			$list = $Record->selectList($zuid,$this->type,$limit,$this->fuid);
			if(!empty($list)){
				// 数据处理
				$root = array();
				$overday = 0;
				foreach($list as $k => $v) {
					$root[$k]['cid'] = (string)$v['cid'];
					$root[$k]['fuid'] = (string)$v['fuid'];
					$root[$k]['name'] = (string)$v['name'];
					$root[$k]['price'] = (string)$v['price']?$v['price']:'0.0';
					$root[$k]['jprice'] = (string)$v['jprice']?$v['jprice']:'0.0';
					$root[$k]['status'] = 	(string)$v['status'];
					$root[$k]['startime'] = date('Y-m-d',$v['startime']);
					$root[$k]['endtime'] = date('Y-m-d',$v['endtime']);
					if($this->fuid){
						if($v['status']==1){
							$overday++;
						}
						if($v['status']!=3){
							$surplus = $v['price']-$v['jprice'];
						}
					}else{
						$surplus = $v['price']-$v['jprice'];
					}
					
					$root[$k]['surplus'] = 	(string)$surplus;
					
				}
				$list = $Record->selectY($zuid,$this->type,$this->fuid);
				$price = $list['0']['price'];
				$jprice = $list['0']['jprice'];
				$overtime = $list['0']['overtime'];
				$surplus = $price-$jprice;
				$list = array(
							'price'=>(string)$price,
							'jprice'=>(string)$jprice,
							'surplus'=>(string)$surplus,
							'type'=>(string)$this->type,
							'overtime'=>(string)$overtime,
							'overday'=>(string)$overday,
							'list'=>$root
							);
				get_obj_array('10000',"成功！",$list);
			}else{
				get_obj_array('20000',"数据不存在！",'');
			}
		}


		//获取单条数据
		public function recordmenu(){
			if(empty($this->token) || empty($this->cid)){
				get_obj_array('20000',"参数不全",'');
			}
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($this->token);
			$zuid = $uerContent['0']['id'];
			$Record = D('Record');
			$list = $Record -> selectMenu($zuid,$this->cid);
			if(!empty($list)){
				$root = array();
				foreach($list as $k => $v) {
					$root[$k]['cid'] =  (string)$v['id'];
					$root[$k]['name'] =  (string)$v['name'];
					$root[$k]['zuid'] =  (string)$v['zuid'];
					$root[$k]['fuid'] =  (string)$v['fuid'];
					$root[$k]['price'] =  (string)$v['price'];
					$root[$k]['jprice'] =  (string)$v['jprice'];
					$root[$k]['overtime'] =  (string)$v['overtime'];
					$root[$k]['station'] =  (string)$v['station'];
					$root[$k]['startime'] =  date('Y-m-d',$v['startime']);
					$root[$k]['endtime'] =   date('Y-m-d',$v['endtime']);
					$root[$k]['square'] =  (string)$v['square'];
					$root[$k]['status'] =  (string)$v['status'];
					$root[$k]['type'] =  (string)$v['type'];
					$root[$k]['content'] =  (string)$v['content'];
				}
				get_obj_array('10000',"成功",$root);
			}else{
				get_obj_array('20000',"未查询到数据",'');
			}

		}
		//exel 表格
		/*
			参数：
				token 	
				fuid 		包工头id/用户id 不是用户表id
				startime  	开始时间
				endtime 	结束时间
				type 		1我与工人/2我与包工头



		*/
		public function recordexcel(){
			if(empty($this->token) || empty($this->fuid) || empty($this->type)){
				get_obj_array('20000',"参数不全",'');
			}else{

				$Public = D('Public');
				$uerContent = $Public->userTokenCark($this->token);
				$zuid = $uerContent['0']['id'];
				$where = " and r.zuid = '".$zuid."'";
				if(!empty($this->startime) && !empty($this->endtime)){

					$where .= " and startime >= ".$this->startime." and startime <= ".$this->endtime."";
				}

				$Record = D('Record');
				$list = $Record->selectList($zuid,$this->type,'',$this->fuid,$where);
				if(!empty($list)){
					$title = $Record->selectY($zuid,$this->type,$this->fuid,$where);
					$Record->recordexcel($title,$list,$this->type);
				}else{
					get_obj_array('20000',"未查询到数据",'');
				}
				
				
			}

		}


		//获取类表
		/*
			参数：
				token 	用户唯一标示
				type 	类型
		
		*/
		public function workerJob(){

			if(empty($this->token) || empty($this->type)){
				get_obj_array('20000',"参数不全",'');
			}
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($this->token);
				$zuid = $uerContent['0']['id'];
				$Relation = D('Relation');
				$list = $Relation->where("zuid = '$zuid' and type = '".$this->type."'")->select();
				if(!empty($list)){
					$root = array();
					foreach ($list as $k => $v) {
						$root[$k]['fuid'] = (string)$v['id'];
						$root[$k]['zuid'] = (string)$v['zuid'];
						$root[$k]['type'] = (string)$v['type'];
						$root[$k]['mobile'] = (string)$v['mobile'];
						$root[$k]['name'] = (string)$v['name'];
					}
					get_obj_array('10000',"成功",$root);
				}else{
					get_obj_array('20000',"未查询到数据",'');
				}
		}

		


}