<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demand_model extends CI_Model{

			
			//辅材模板

			//设备出租
			public function mRentOut($arr){
				$str = "<p><span style='color:red'>*</span><span>业主名称：</span><input type='text' name='owner' id='owner' value='".$arr['owner']."' /></p><p><span style='color:red'>*</span><span>司 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 机：</span><input type='radio' value='0' name='driver' checked/> 无<input type='radio' value='1' name='driver' ";
				if($arr['driver'] == 1){
					$str .= "checked";
				}
				$str .= "/> 有</p><p><label>图 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 片：</label>".$this->mImgHtml($arr['pic'])."</p><p><span style='color:red'>*</span><span>设备名称：</span><input name='device' type='text' id='device' style='width: 200px' value='".$this->selectCategory($arr['deviceid'],'2')."' readonly='readonly'><input name='deviceid' type='hidden' id='deviceid' value='".$arr['deviceid']."' ></p><p><span style='color:red'>*</span><span>数 &nbsp;&nbsp;&nbsp;&nbsp; 量：</span><input type='text' name='num' id='num' value='".$arr['num']."' /> 台</p><p><span style='color:red'>*</span><span>规格型号：</span><input type='text' name='model' id='model' value='".$arr['model']."' /></p>";
				return $str;

			}

			// 活找队 <p><span>队伍规模：</span><input name='num' type='text' id='num' value='".$arr['num']."'/></p>

			public function mWorkTeam($arr){

				$str = "<p><span style='color:red'>*</span><span>工种要求：</span><input name='craft' type='text' id='craft' style='width: 200px' value='".$this->selectCategory($arr['craftid'],'1')."' readonly='readonly'><input type='hidden' name='craftid' id='craftid' value='".$arr['craftid']."' /></p><p><span style='color:red'>*</span><span>项目类型：</span><input name='mold' type='text' id='mold' style='width: 200px' value='".$this->selectCategory($arr['moldid'],'3')."' readonly='readonly'><input type='hidden' name='moldid' id='moldid' value='".$arr['moldid']."' /></p><p><span style='color:red'>*</span><span>工程总价：</span><input name='price' type='text' id='price' value='".round($arr['price']/10000,2)."' /> 万</p>";
				return $str;

			}

			//队找活

			public function mTeamWork($arr){

				$str = "<p><span style='color:red'>*</span><span>队伍人数：</span><input name='num' type='text' id='num' value='".$arr['num']."'/> 人</p><p><span style='color:red'>*</span><span>工 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 种：</span><input name='craft' type='text' id='craft' style='width: 200px' value='".$this->selectCategory($arr['craftid'],'1')."' readonly='readonly'><input type='hidden' name='craftid' id='craftid' value='".$arr['craftid']."' /></p>";

				return $str;
			}

			//队找人

			public function mTeamPerson($arr){

				$str = "<p><span style='color:red'>*</span><span>人 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 数：</span><input type='text' name='num' id='num' value='".$arr['num']."'> 人</p><p><span style='color:red'>*</span><span>年 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 龄：</span><input type='text' name='age1' id='age1' value='".$arr['age1']."' style='width:50px'> - <input type='text' name='age2' id='age2' value='".$arr['age2']."' style='width:50px'> </p><p><span style='color:red'>*</span><span>工 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 种：</span><input name='craft' type='text' id='craft' style='width: 200px' value='".$this->selectCategory($arr['craftid'],'1')."' readonly='readonly'><input type='hidden' name='craftid' id='craftid' value='".$arr['craftid']."' /></p><p><span style='color:red'>*</span><span>工资待遇：</span><input type='text' name='price' id='price' value='".$arr['price']."' style='width:50px'> - <input type='text' name='price2' id='price2' value='".$arr['price2']."' style='width:50px'> 天</p>";
				return $str;

			}

			//辅材

			public function mAlcorAdd($arr){
				
				if($arr['type'] == 1){
					$i = 1;
				}else{
					$i = 3;
				}
					$str = "<label>附加资料：</label>".$this->mImgHtml($arr['terracepic'],'terracepic',$i);


                    $str .= "<p><label>图 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 片：</label>".$this->mImgHtml($arr['pic'])."</p><p><span style='color:red'>*</span><span>店铺名称：</span><input type='text' id='shopname' name='shopname' value='".$arr['shopname']."' /></p><p><span style='color:red'>*</span><span>服务范围：</span> <input type='text' id='alcor' name='alcor' value='".$this->selectCategory($arr['alcorid'],'4')."' /><input type='hidden' id='alcorid' name='alcorid' value='".$arr['alcorid']."' ></p>";
                    $str .= "<p><span style='color:red'>*</span><span>服务类型：</span><input type='radio' value='1' name='ptype' ";
                    if($arr['type'] == 1){
                        $str .= "checked";
                    }
                    $str .="/> 厂家<input type='radio' value='2' name='ptype' ";

                    if($arr['type'] == 2){
                        $str .= "checked";
                    }
                    $str .= "/> 商家</p>";
                    return $str;

			}

			//
			public function mImgHtml($arr,$name='pic',$y='9'){
				$arr = explode(',',$arr);
				$str = '';
				for ($i=1; $i <=$y; $i++){
					if(!empty($arr[$i-1])){
						$str .="<img width='200px' height='100px' src='".$arr[$i-1]."'><br/>";
					}
					$str .= "<input type='file' value='' name='".$name.$i."' /><br/>";
				}
				return $str;

			}

			//分类查询
			/*
				id

			*/
			public function selectCategory($id,$t){
					//$id = intval($id);
					$str = '';
					if(!empty($id)){
						if($t == '1'){
							$data = "zj_craft";
						}elseif($t == '2'){
							$data = "zj_device";
						}elseif($t == '3'){
							$data = "zj_mold";
						}elseif($t == '4'){
							$data = "zj_alcor";
						}
						$sql = "select id,name from $data where id in (".$id.")";
						$query = $this->db->query($sql);
						
						foreach ($query->result_array() as $value) {

							$str .= $value['name'].' ';
						}
					}
					return $str;
			}

}