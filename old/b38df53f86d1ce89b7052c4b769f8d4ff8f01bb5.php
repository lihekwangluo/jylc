<?php

//----------------------------------------------------------------------
//函数:调整图片尺寸或生成缩略图
//返回:True/False
//参数:
  $Image ; //需要调整的图片(含路径)
  $Dw=450 ; //调整时最大宽度;缩略图时的绝对宽度
  $Dh=450 ; //调整时最大高度;缩略图时的绝对高度
  $Type=2 ; //1,调整尺寸; 2,生成缩略图
$path='img/';//路径
$phtypes=array(
  'img/gif',
  'img/jpg',
  'img/jpeg',
  'img/bmp',
  'img/pjpeg',
  'img/x-png'
);
Function Img($Image)
{
    echo $Image;
    Copy($Image, Str_Replace(".", "_litpc.", $Image));
    echo $Image;
    $Image = Str_Replace(".", "_litpc.", $Image);
    echo $Image;
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

    $w = ImagesX($Img);
    $h = ImagesY($Img);


    IF ($h / $w >= 1) { //高比较大
        $Dw = 400;
        $Dh = 700;
        $nImg = ImageCreateTrueColor($Dw, $Dh);
        $height = $h * $Dw / $w;
        $IntNH = $height - $Dh;
        ImageCopyReSampled($nImg, $Img, 0, -$IntNH / 1.8, 0, 0, $Dw, $height, $w, $h);
    } Else {   //宽比较大
        $Dw = 700;
        $Dh = 400;
        $nImg = ImageCreateTrueColor($Dw, $Dh);
        $width = $w * $Dh / $h;
        $IntNW = $width - $Dw;
        ImageCopyReSampled($nImg, $Img, -$IntNW / 1.8, 0, 0, 0, $width, $Dh, $w, $h);
    }
    ImageJpeg($nImg, $Image);
    Return True;
}

?>
<html><body>
<form method="post" enctype="multipart/form-data" name="form1">
 <table>
  <tr><td>上传图片</td></tr>
  <tr><td><input type="file" name="photo" size="20" /></td></tr>
 <tr><td><input type="submit" value="上传"/></td></tr>
 </table>
 允许上传的文件类型为:<?=implode(', ',$phtypes)?></form>
<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
  if (!is_uploaded_file($_FILES["photo"][tmp_name])){
   echo "图片不存在";
   exit();
  }
  if(!is_dir('img')){//路径若不存在则创建
   mkdir('img');
  }
  $upfile=$_FILES["photo"];
  $pinfo=pathinfo($upfile["name"]);
  $name=$pinfo['basename'];//文件名
  $tmp_name=$upfile["tmp_name"];
  $file_type=$pinfo['extension'];//获得文件类型
  $showphpath=$path.$name;

  if(in_array($upfile["type"],$phtypes)){
   echo "文件类型不符！";
   exit();
   }
  if(move_uploaded_file($tmp_name,$path.$name)){
  echo "成功！";
 Img($showphpath);
  }
  echo "<img src=\"".$showphpath."\" />";
 }
?>
</body>
</html>