<?php

function SendMsg($tel,$content,$type=''){
    $num = 2;
    if($type){
        $phone=implode(',',$tel);
    }else{
        $phone=$tel;
    }

    $account = '';
    $pwd = '';
    $date = date("Y-m-d H:i:s");

    //$content = iconv("utf-8","gbk",$content."[Ç©Ãû]");
    //$content = urlencode($content);
    //$url = "http://sms.1xinxi.cn/asmx/smsservice.aspx?name=".$account."&pwd=".$pwd."&content=".$content."&mobile=".$phone."&stime=".$date."&sign=Ç©Ãû&type=pt&extno=";

    $url = 'http://sms.1xinxi.cn/asmx/smsservice.aspx';
    $data['name'] = $account;
    $data['pwd'] = $pwd;
    $data['content'] = $content;
    $data['mobile'] = $phone;
    $data['stime'] = $date;
    $data['sign'] = 'ÅûÈø½Ö';
    $data['type'] = 'pt';
    $data['extno'] = '';

    $info = postSMS($url, $data);
    return $info;

}

function postSMS($url,$data=''){
    $row = parse_url($url);
    $host = $row['host'];
    $port = $row['port'] ? $row['port']:80;
    $file = $row['path'];
    $post='';
    while (list($k,$v) = each($data)){
        $post .= rawurlencode($k)."=".rawurlencode($v)."&";	//×ªURL±ê×¼Âë
    }
    $post = substr( $post , 0 , -1 );
    $len = strlen($post);
    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
    if (!$fp) {
        return "$errstr ($errno)\n";
    } else {
        $receive = '';
        $out = "POST $file HTTP/1.1\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Content-Length: $len\r\n\r\n";
        $out .= $post;
        fwrite($fp, $out);
        while (!feof($fp)) {
            $receive .= fgets($fp, 128);
        }
        fclose($fp);
        $receive = explode("\r\n\r\n",$receive);
        unset($receive[0]);
        return implode("",$receive);
    }

}




function getToken($nikeName){
    $key = "nj@twg".strtotime(date('Y-m-d H:i:s')).rand('0','99999');
   // $nikeName = "LG002";
    $data = $nikeName .",".$key;
    return  base64_encode(md5($data));
}

function get_obj_array($code,$message,$_array,$type = 0){
    $result_array = array("code"=>$code,"message"=>$message,"resultCode"=>$_array);
	// echo preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))",json_encode($result_array));
	//echo 100;die();
    echo json_encode($result_array);
    exit;
}

function pageLimit(){
    $page = I('post.page')?I('post.page'):I('get.page');
    $page = $page?$page:'1';
    $pagesize = I('post.pagesize')?I('post.pagesize'):I('get.pagesize');
    $pagesize=$pagesize?$pagesize:'20';
    return $limit = (($page-1)*$pagesize).",".$pagesize;
}


function getAge($birthday){
    $age = '0';
    if(!empty($age)){
        $age = date('Y', time()) - date('Y', strtotime($birthday)) - 1;
        if (date('m', time()) == date('m', strtotime($birthday))){

            if (date('d', time()) > date('d', strtotime($birthday))){
            $age++;
            }
        }elseif (date('m', time()) > date('m', strtotime($birthday))){
            $age++;
        }

    }
    return $age;

}

function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}

function inviteCode($id){
    return chr(rand(97, 122)).chr(rand(97, 122)).rand(100,999).chr(rand(97, 122)).chr(rand(97, 122)).$id;
}