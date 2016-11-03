<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Record_model extends CI_Model{

	function recordexcel($title,$type,$startime,$endtime){


		include($_SERVER[DOCUMENT_ROOT].'/application/libraries/PHPExcel.php');
		$PHPExcel = new PHPExcel(); //加载类，直接可以网上下载

		if($type == 1){
			$g = '工人 ';
		}else{
			$g = '包工头 ';
		}
		$name = $title['query']['0']['name']?$title['query']['0']['name']:'未知';
		$fileName = $title['query']['0']['uname'].' 与 '.$name.$g.'('.$startime.' 至 '.$endtime.')';
        //填入主标题
       $PHPExcel->getActiveSheet()->setCellValue('A1',$fileName);
        //填入副标题
       $PHPExcel->getActiveSheet()->setCellValue('A2', '明细表(导出日期：'.date('Y-m-d',time()).')');
        //填入表头1
       $PHPExcel->getActiveSheet()->setCellValue('A3', '应付金额');
       $PHPExcel->getActiveSheet()->setCellValue('B3', '借支金额');
       $PHPExcel->getActiveSheet()->setCellValue('C3', '剩余金额');
       $PHPExcel->getActiveSheet()->setCellValue('D3', '加班工时');
       $PHPExcel->getActiveSheet()->setCellValue('E3', '点工天数');
        //内容1
       $PHPExcel->getActiveSheet()->setCellValue('A4', $title['price']);
       $PHPExcel->getActiveSheet()->setCellValue('B4', $title['jprice']);
       $PHPExcel->getActiveSheet()->setCellValue('C4', $title['price'] - $title['jprice']);
       $PHPExcel->getActiveSheet()->setCellValue('D4', $title['overtime']);
       $PHPExcel->getActiveSheet()->setCellValue('E4', $title['overday']);
        //表头标题2
       $PHPExcel->getActiveSheet()->setCellValue('A5', '类型');
       $PHPExcel->getActiveSheet()->setCellValue('B5', '资金');
       $PHPExcel->getActiveSheet()->setCellValue('C5', '日期');
        //内容2
     	$i = 6;
        foreach ($title['query'] as $k => $v) {
        	if($v['status'] == 1){
				$t = '点工';
			}elseif($v['status'] == 2){
				$t = '包工';
			}elseif($v['status'] == 3){
				$t = '借支';
				$v['price'] =  $v['jprice'];
			}
        	$PHPExcel->getActiveSheet()->setCellValue('A'.$i, $t);
        	$PHPExcel->getActiveSheet()->setCellValue('B'.$i, $v['price']);
        	$PHPExcel->getActiveSheet()->setCellValue('C'.$i, date('Y年m月d日',$v['startime']));
        	if($v['status'] == 3){
        		$PHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getfont()->getColor()->setARGB('FFFF0000');
        	}
        	//设置每一行行高
           $PHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
            $i++;

        }
        //合并单元格
       $PHPExcel->getActiveSheet()->mergeCells('A1:E1');
       $PHPExcel->getActiveSheet()->mergeCells('A2:E2');
        //设置单元格宽度
       $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
       $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
       $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
       $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
       $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        //设置表头行高
       $PHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
       $PHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(22);
       $PHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
       $PHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
        //设置字体样式
       $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
       $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
       $PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

       $PHPExcel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
       $PHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setBold(true);
       $PHPExcel->getActiveSheet()->getStyle('A5:E5')->getFill()->getStartColor()->setARGB("048E14");
         //设置字体样式
       $PHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('宋体');
       $PHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

        
       $PHPExcel->getActiveSheet()->getStyle('A6:E'.$i)->getFont()->setSize(10);
        //设置居中
       $PHPExcel->getActiveSheet()->getStyle('A1:E'.$i)->getAlignment()->setHorizontal(phpexcel_Style_Alignment::HORIZONTAL_CENTER);
            
        //所有垂直居中
       $PHPExcel->getActiveSheet()->getStyle('A1:E'.$i)->getAlignment()->setVertical(phpexcel_Style_Alignment::VERTICAL_CENTER);
            
        //设置单元格边框
       $PHPExcel->getActiveSheet()->getStyle('A3:E'.$i)->getBorders()->getAllBorders()->setBorderStyle(phpexcel_Style_Border::BORDER_THIN);
        
        //设置自动换行
       $PHPExcel->getActiveSheet()->getStyle('A3:E'.$i)->getAlignment()->setWrapText(true);

        $PHPExcel->createSheet(); 
        
        include($_SERVER[DOCUMENT_ROOT].'/application/libraries/PHPExcel/Writer/Excel5.php');
        //保存为2003格式
        $objWriter = new phpexcel_Writer_Excel5($PHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        
        //多浏览器下兼容中文标题
        $encoded_filename = urlencode($fileName);
        $ua = $_SERVER["HTTP_USER_AGENT"];
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xls"');
        } else if (preg_match("/Firefox/", $ua)) {
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xls"');
        } else {
            header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
        }
        
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
	}
}