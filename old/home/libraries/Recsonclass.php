<?php 
	// if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	class Recsonclass{
	
		function upload($file,&$result,$upload=null,$file1=null,$size=null){
			//print_r($file);die();
			//自定义上传图片函数
			//print_r($file);die();
			$root=$_SERVER["DOCUMENT_ROOT"]."/";
			$data=date('Ymd',time());
			$size==""?$size=2048:$size=$size;
			$p_name=$file["name"];
			$p_type=$file["type"];
			$p_tmp=$file["tmp_name"];
			$p_error=$file["error"];
			$p_size=$file["size"];
			$extname=strtolower(substr($p_name,strrpos($p_name,".")+1,1000));
			if($upload=="" && $extname==""){
				if($file1==""){
					$result="ok";
					return "";				
				}else{
					$result="ok";
					return $file1;
				}
			}else{

				if($extname==""){
					$result="error";
					return "请选择上传文件";				
				}elseif($p_error>0){
					$result="error";
					return "系统链接超时，请重试";
				}elseif(substr_count("jpg_png_jpeg_gif",$extname)==0){
					$result="error";
					return "请上传图片文件";
				}elseif(substr_count($p_type,"image")==0){
					$result="error";
					return "请上传图片文件";
				}elseif($p_size>($size*1024)){
					$result="error";
					return "图片大小不能超过".$size."KB";
				}else{

					if(!is_uploaded_file($p_tmp)){
						$result="error";
						return "系统链接超时，请重试";			
					}else{
						if(!is_dir($root."Uploads/img/".$data)){
							mkdir($root."Uploads/img/".$data);
						}
						if(!is_dir($root."Uploads/img/".$data)){
							mkdir($root."Uploads/img/".$data);
						}
						if(!is_dir($root."Uploads/img/".$data)){
							mkdir($root."Uploads/img/".$data);
						}
						$newname=time().rand(0,99999).".".$extname;
						$newpic=$root."Uploads/img/".$data."/".$newname;
						$newurl="Uploads/img/".$data."/".$newname;
						if($file1==""){
							$newpic=$root."Uploads/img/".$data."/".$newname;
							$newurl="Uploads/img/".$data."/".$newname;						
						}else{
							$newpic=$root.$file1;
							$newurl=$file1;						
						}
						//die($newpic);
					//	die($p_tmp);
						if(move_uploaded_file($p_tmp,$newpic)){
							$result="ok";
							return $newurl;					
						}else{
							$result="error";
							return "系统链接超时，请重试";					
						}
					}
				}
			}
		}
	}

?>