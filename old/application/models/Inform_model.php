<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Inform_model extends CI_Model{



		function SendMsg($tel,$content){
		    $num = 2;
		    $tel = trim($tel,',');
		    $account = '13645300887';
		    $pwd = '0D569E76E97FB7B4B01D145F3C86';
		    $date = date("Y-m-d H:i:s");

		    $url = 'http://sms.1xinxi.cn/asmx/smsservice.aspx';
		    $data['name'] = $account;
		    $data['pwd'] = $pwd;
		    $data['content'] = $content;
		    $data['mobile'] = $phone;
		    $data['stime'] = $date;
		    $data['sign'] = '建筑';
		    $data['type'] = 'pt';
		    $data['extno'] = '';

		   /* $info = postSMS($url, $data);
		    return $info;*/
		    $data = http_build_query($data);
		    $url = $url.'?'.$data;
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    $info = curl_exec($ch);
		    return $info;
		}


		/**
		 * POST提交短信数据
		 */
		function postSMS($url,$data=''){
		    $row = parse_url($url);
		    $host = $row['host'];
		    $port = isset($row['port']) ? $row['port']:'80';
		    $file = $row['path'];
		    $post='';
		    while (list($k,$v) = each($data)){
		        $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
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

	}