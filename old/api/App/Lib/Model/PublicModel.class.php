<?php

class PublicModel extends Model {

	//积分日志 在减去的时候要提前判断本函数不做判断
	/*
		userid		用户id
		content 	描述
		zhuangtai 	增加还是减少
		status 		积分类别 1是邀请/2是注册/......	

	*/
	public function integrallog($arr,$d='1'){
			if(empty($arr['num'])){
				$data['num'] = $this->getSetIntegral($arr['status']);
			}else{
				$data['num'] = $arr['num'];
			}
			$data['userid'] = $arr['userid'];
			$data['content'] = $arr['content'];
			$data['zhuangtai'] = $arr['zhuangtai'];
			$data['status'] = $arr['status'];
			if(!empty($arr['addup'])){
				$data['addup'] = $arr['addup'];
			}
			
			$data['addtime'] = time();
			if($arr['status'] == 4){
				$data['productid'] = $arr['productid'];
				$data['username'] = $arr['username'];
				$data['mobile'] = $arr['mobile'];
				$data['address'] = $arr['address'];
				$data['text'] = $arr['text'];
				$data['num'] = $arr['num']; //如果是商品从新写入积分
				$data['number'] = $arr['number'];
			}
			$Integrallog = M("Integrallog"); 
			
			$Integrallog->add($data);
			if($d == '1'){
				//给对应的用户加积分或减去
				if($data['zhuangtai'] == 1){ //增加
					$sql = "UPDATE zj_user SET integral = integral+'".$data['num']."' where id = '".$data['userid']."'";
				}else{//减去
					$sql = "UPDATE zj_user SET integral = integral-'".$data['num']."' where id = '".$data['userid']."'";
				}
				$User = M();
				$User->query($sql);
			}
			
			
	}
	//获取设置的积分
	public function getSetIntegral($i){
			$Setintegral = M('Setintegral');
			$list = $Setintegral->where("id = 1 ")->limit(1)->select();
			if($i==1){
				$t = $list['0']['invitation'];
			}elseif($i==2){
				$t = $list['0']['register'];
			}elseif($i==3){
				$t = $list['0']['login'];
			}elseif($i==6){
				$t = $list['0']['kongjian'];
			}elseif($i==7){
				$t = $list['0']['haoyou'];
			}elseif($i==8){
				$t = $list['0']['zhiwei'];
			}else{
				$t = 0;
			}
			return $t;
	}
	//用户登陆
	public function userTokenCark($token,$where=''){
		
		$User = M('User');
		$list = $User->where("status = 1 and token='$token' ".$where)->limit(1)->select();
		if(empty($list)){
			get_obj_array('20000','登陆失败！','');
		}else{
			return $list;
		}
	}
	//图片压缩
	public function imgFiles($pic){
		// 指定文件路径和缩放比例
		$filename = $pic;
		$percent = 0.5;
		// 获取图片的宽高
		list($width, $height) = getimagesize($filename);
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
		// 创建一个图片。接收参数分别为宽高，返回生成的资源句柄
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		//获取源文件资源句柄。接收参数为图片路径，返回句柄
		$source = imagecreatefromjpeg($filename);
		// 将源文件剪切全部域并缩小放到目标图片上。前两个为资源句柄
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		// 输出给浏览器
		$img = imagejpeg($thumb);
		echo $img;
		
				
	}
	//图片上传
	public function imgFile($key=''){
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();
		$upload->maxSize = 32922000;
		$upload->allowExts = explode(',', 'jpg,png,jpeg');
		$imgurl = '../Uploads/img/'.date("Ymd").'/';
		$upload->savePath = '../Uploads/img/'.date("Ymd").'/';
		if (!$upload->upload()){
			get_obj_array('20000','图片上传失败！'.$upload->getErrorMsg(),'');
		}else{
			$uploadList = $upload->getUploadFileInfo();
			$arr = array();
			foreach($uploadList as $v) {
				if($key){
					$arr[$v['key']] = trim($imgurl,'..').$v['savename'];
				}else{
					$arr[] = trim($imgurl,'..').$v['savename'];
				}
				
			}
			return $arr;
		}
	}
	//删除图片
	public function delImg($url){
		if(!empty($url)){
			$arr = explode(',', 'jpg,gif,png,jpeg');
			$urlhou = pathinfo($url);
			$urlhou = $urlhou['extension'];
			if(in_array($urlhou,$arr)){
				unlink($_SERVER['DOCUMENT_ROOT'].$url);
			}
		}
		
		
	}

	/*
			图片删除 同时删除数据 升级版
			$data   数据表名
			$where  查询条件
			$divs   图片之间分割 默认 ,
			$imgpic 数据字段 默认pic
		*/
		public function delImgAll($data,$where,$imgpic=array('pic'),$divs=','){
			$Data = M();
			if(!empty($where)){
				if(!empty($imgpic)){
					$sql = "select * from ".$data." where " .$where;
					$query = $Data->query($sql);
					$file = $_SERVER['DOCUMENT_ROOT'];
					foreach ($query as $arr) {
						foreach ($imgpic as $Iv) {
							$picArr = explode($divs,$arr[$Iv]);
							foreach ($picArr as $pic){
								@unlink($file.$pic);
							}
						}
						
					}
				}
				
				$sql = "delete from ".$data." where " .$where;
				return$Data->query($sql);
				exit;
			}
			return false;

		}
		//去除敏感字
		public function delSensitivity($str){
			$Setsystem = M('Setsystem');
			$list = $Setsystem -> where('id = 1')->limit('1')->select();
			$sensitivity = explode(',',$list['0']['sensitivity']);
			return str_replace($sensitivity,' ',$str);

		}
		//创蓝短信接口
		public function ChuanglanSmsHelper($mobile,$content){
				import("ORG.Clsms.ChuanglanSmsApi");
				$clapi  = new ChuanglanSmsApi();
				$result = $clapi->sendSMS($mobile,$content,'true');
				$result = $clapi->execResult($result);
				if($result[1] != 0){
					get_obj_array('20000','验证码获取失败,请稍后再试！','0');
				}
				
		}

public Function Litpic($Image)
	{

		$Image="..".$Image;
		Copy($Image, Str_Replace(".jpg", "_litpic.jpg", $Image));
		$Image = Str_Replace(".jpg", "_litpic.jpg", $Image);
		//取得文件的类型,根据不同的类型建立不同的对象
		$ImgInfo = GetImageSize($Image);


		Switch ($ImgInfo[2]) {
			Case 1:
				$Img = @ImageCreateFromGIF($Image);
				Break;
			Case 2:
				$Img = @ImageCreateFromJPEG($Image);
				Break;
			Case 3:
				$Img = @ImageCreateFromPNG($Image);
				Break;
		}

		$pic_width = ImagesX($Img);
		$pic_height = ImagesY($Img);

		$maxheight = '400';
		$maxwidth = '700';

		if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
			if ($maxwidth && $pic_width > $maxwidth) {
				$widthratio = $maxwidth / $pic_width;
				$resizewidth_tag = true;
			}

			if ($maxheight && $pic_height > $maxheight) {
				$heightratio = $maxheight / $pic_height;
				$resizeheight_tag = true;
			}

			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio)
					$ratio = $widthratio;
				else
					$ratio = $heightratio;
			}

			if ($resizewidth_tag && !$resizeheight_tag)
				$ratio = $widthratio;
			if ($resizeheight_tag && !$resizewidth_tag)
				$ratio = $heightratio;

			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
		}

//		IF ($h / $w >= 1) { //高比较大
//			$Dw = '400';
//			$Dh = '700';
//			if(!$h<$Dh){
//
//				$nImg = ImageCreateTrueColor($Dw, $Dh);
//				$height = $h * $Dw / $w;
//				$IntNH = $height - $Dh;
//				ImageCopyReSampled($nImg, $Img, 0, -$IntNH / 1.8, 0, 0, $Dw, $height, $w, $h);
//			}
//
//		} Else {   //宽比较大
//			$Dw = '700';
//			$Dh = '400';
//			if(!$w<$Dw) {
//				$nImg = ImageCreateTrueColor($Dw, $Dh);
//				$width = $w * $Dh / $h;
//				$IntNW = $width - $Dw;
//				ImageCopyReSampled($nImg, $Img, -$IntNW / 1.8, 0, 0, 0, $width, $Dh, $w, $h);
//			}
//		}

		$newim = imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($newim,$Img,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);

		ImageJpeg($newim, $Image);
		$litpic=substr($Image,2);
		return array(
			'litpic'=>$litpic,
			'height'=>(int)$newheight,
			'width'=>(int)$newwidth
		);
	}

	public Function Litpic2($Image)
	{

		$Image="..".$Image;

		$ImgInfo = GetImageSize($Image);


		Switch ($ImgInfo[2]) {
			Case 1:
				$Img = @ImageCreateFromGIF($Image);
				Break;
			Case 2:
				$Img = @ImageCreateFromJPEG($Image);
				Break;
			Case 3:
				$Img = @ImageCreateFromPNG($Image);
				Break;
		}

		$pic_width = ImagesX($Img);
		$pic_height = ImagesY($Img);

		$litpic=substr($Image,2);
		return array(
				'litpic'=>$litpic,
				'height'=>(int)$pic_height,
				'width'=>(int)$pic_width
		);
	}
}