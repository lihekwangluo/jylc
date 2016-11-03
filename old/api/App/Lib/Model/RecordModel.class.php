<?php

class RecordModel extends Model {

	//我与工人/包工头
	public function selectList($uid,$type,$limit,$fuid='',$where=''){
		$S = M();
		if($fuid){
			$group = 'd.id';
			$where .= " and r.id = $fuid";
		}else{
			$group = 'r.id';
			
		}
		$sql = "SELECT d.id as cid,r.id as fuid,r.name,sum(d.price) as price,sum(d.jprice) as jprice,d.status,d.startime,d.endtime  FROM zj_relation as r
				left JOIN zj_record as d
				ON r.id = d.fuid
				WHERE r.zuid = '$uid' $where and r.type = '$type' group by $group desc" ;
		$list = $S->query($sql.$limit);
		return $list;
	}
	//查询余额综合
	public function selectY($uid,$type,$fuid='',$where=''){
		$S = M();

		if(!empty($fuid)){
			$where .= " and r.id = $fuid";
		}

		$sql = "SELECT sum(d.price) as price,sum(d.jprice) as jprice,sum(d.overtime) as overtime FROM zj_relation as r
				left JOIN zj_record as d
				ON r.id = d.fuid
				WHERE r.zuid = '$uid' $where  and r.type = '$type' group by r.zuid desc" ;
		$list = $S->query($sql);
		return $list;
	}

	public function selectMenu($uid,$id){
		$S = M();
		$sql = "SELECT d.*,r.name FROM zj_relation as r
				left JOIN zj_record as d
				ON r.zuid = d.zuid
				WHERE d.zuid = '$uid' and d.id='$id' limit 1";
		$list = $S->query($sql);
		return $list;
	}

	public function recordexcel($title,$arr,$type){

		
		import("ORG.PHPExcel.PHPExcel");
		$PHPExcel = new PHPExcel(); //加载类，直接可以网上下载
		if($type == 1){
			$g = '工人';
		}else{
			$g = '包工头';
		}
		$name = $arr['0']['name']?$arr['0']['name']:'未知';
		$fileName = '我与'.$name.$g;
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
        $PHPExcel->getActiveSheet()->setCellValue('A4', $title['0']['price']);
        $PHPExcel->getActiveSheet()->setCellValue('B4', $title['0']['jprice']);
        $PHPExcel->getActiveSheet()->setCellValue('C4', $title['0']['price'] - $title['0']['jprice']);
        $PHPExcel->getActiveSheet()->setCellValue('D4', $title['0']['overtime']);
        $PHPExcel->getActiveSheet()->setCellValue('E4', $title['0']['overday']);
        //表头标题2
        $PHPExcel->getActiveSheet()->setCellValue('A5', '类型');
        $PHPExcel->getActiveSheet()->setCellValue('B5', '资金');
        $PHPExcel->getActiveSheet()->setCellValue('C5', '日期');
        //内容2
     	$i = 6;
        foreach ($arr as $k => $v) {
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
        $PHPExcel->getActiveSheet()->getStyle('A1:E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
        //所有垂直居中
        $PHPExcel->getActiveSheet()->getStyle('A1:E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
        //设置单元格边框
        $PHPExcel->getActiveSheet()->getStyle('A3:E'.$i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        //设置自动换行
        $PHPExcel->getActiveSheet()->getStyle('A3:E'.$i)->getAlignment()->setWrapText(true);

        
        
        //保存为2003格式
        $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
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