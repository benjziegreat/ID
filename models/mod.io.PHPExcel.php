<?php
	include('../libs/EXPORT_EXCEL_CLASS/PHPExcel_1.8.0_pdf/Classes/PHPExcel.php');
	include('../libs/EXPORT_EXCEL_CLASS/PHPExcel_1.8.0_pdf/Classes/PHPExcel/IOFactory.php');

	set_time_limit(0);
	ini_set('memory_limit','8249M');
        
	$FILE_N = $_POST["FILE_NAME"]==""?$_POST["WORKSHEET_NAME"]:$_POST["FILE_NAME"];
	$WORKSHEET_NAME = $_POST["WORKSHEET_NAME"];

	$COLUMNS=json_decode($_POST["COLUMNS"],true);
	$QUERY=$_POST["QUERY"];
	$DATABASE=$_POST["DATABASE"];
	$HOST=$_POST["HOST"];
	$USER=$_POST["USER"];
	$PASS=$_POST["PASSWORD"];
	$FORMATS = json_decode($_POST["COLUMNS_FORMATS"],true);
	$HASTOTAL = json_decode($_POST["COLUMNS_TOTAL"],true);
	$HEADERS = json_decode($_POST["HEADERS"],true);
	$ALIGNMENTS = json_decode($_POST["ALIGNMENTS"],true);

	$CONTENT_TEXT_COLOR = $_POST["CONTENT_TEXT_COLOR"];
	$CONTENT_BACKGROUND_COLOR = $_POST["CONTENT_BACKGROUND_COLOR"];
	$HEADER_BACKGROUND_COLOR = $_POST["HEADER_BACKGROUND_COLOR"];
	$HEADER_TEXT_COLOR = $_POST["HEADER_TEXT_COLOR"];
        $LETTERFREEZ = $_POST["LETTERFREEZ"];
        $AUTOFILTER = $_POST["AUTOFILTER"];
        
        $VALUE_BLANK=$_POST["VALUE_BLANK"];
        $VALUE_COLOR=json_decode($_POST["VALUE_COLOR"],true);
        $VALUE_COLOR_NAME=$_POST["VALUE_COLOR_NAME"];
        $HAS_COLOR_CONDITION=$_POST["HAS_COLOR_CONDITION"];
        $VALUE_COLOR_BLANK=$_POST["VALUE_COLOR_BLANK"];
        
        $COLUMNWIDTH = json_decode($_POST["COLUMNWIDTH"],true);

	$xCol = getCOLUMN_AB(count($COLUMNS));

	$xPHPExcel = new PHPExcel();
	$xPHPExcel->getProperties()
		->setCreator("Nelson Gabriel Cañete")
	 	->setLastModifiedBy("Nelson Gabriel Cañete")
	 	->setTitle("Office 2007 XLSX REPORT Document")
	 	->setSubject("Office 2007 XLSX REPORT Document")
	 	->setDescription("REPORT document for Office 2007 XLSX, generated using PHP classes.")
	 	->setKeywords("office 2007 openxml php")
	 	->setCategory("Report result file");

// 	$xWriter = PHPExcel_IOFactory::createWriter($xPHPExcel, 'Excel5');
//	$xWriter->save($FILE_N.'.xls');
//
//	$xPHPExcel = PHPExcel_IOFactory::load($FILE_N.'.xls');

 	$xPHPExcel->setActiveSheetIndex(0);

 	$lastColspan = 0;
	if(count($HEADERS)>0){
		foreach($HEADERS as $key=>$value){
			foreach ($value["COLUMNS"] as $indx => $vlx) {
				if(count($value["COLUMNS"]) == 1){
					$xPHPExcel->getActiveSheet()
					->setCellValue($xCol[$indx].($key+1), $vlx["NAME"]);
					$xPHPExcel->getActiveSheet()->mergeCells(($xCol[$indx].($key+1)).":".($xCol[($indx)+(int)$vlx["COLSPAN"]].($key+1)));
                                        $xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx].($key+1)).":".($xCol[($indx)+(int)$vlx["COLSPAN"]].($key+1)))->getAlignment()->setWrapText(true);
					if((int)$vlx["BORDER"] == 1){
						$xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx].($key+1)).":".($xCol[($indx)+(int)$vlx["COLSPAN"]].($key+1)))->applyFromArray(
								array(
									'font'    => array(
										'bold'      => true
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
									),
									'borders' => array(
										'top'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'left'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'right'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'bottom'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				)
									),
									'fill' => array(
							 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
							  			'rotation'   => 90,
							 			'startcolor' => array(
							 				'argb' => 'AA528B8B'
							 			),
							 			'endcolor'   => array(
							 				'argb' => 'AAFFFAF0'
							 			)
							 		)
								)
						);
					}else{
						$xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx].($key+1)).":".($xCol[($indx)+(int)$vlx["COLSPAN"]].($key+1)))->applyFromArray(
								array(
									'font'    => array(
										'bold'      => true
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
									),
									'fill' => array(
							 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
							  			'rotation'   => 90,
							 			'startcolor' => array(
							 				'argb' => 'AA528B8B'
							 			),
							 			'endcolor'   => array(
							 				'argb' => 'AAFFFAF0'
							 			)
							 		)
								)
						);
					}
				}else{
					$xPHPExcel->getActiveSheet()
					->setCellValue($xCol[$indx+$lastColspan].($key+1), $vlx["NAME"]);
					$xPHPExcel->getActiveSheet()->mergeCells(($xCol[$indx+$lastColspan].($key+1)).":".($xCol[$indx+($lastColspan)+(int)$vlx["COLSPAN"]].($key+1)));
                                        $xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx+$lastColspan].($key+1)).":".($xCol[$indx+($lastColspan)+(int)$vlx["COLSPAN"]].($key+1)))->getAlignment()->setWrapText(true);
					if((int)$vlx["BORDER"] == 1){
						$xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx+$lastColspan].($key+1)).":".($xCol[$indx+($lastColspan)+(int)$vlx["COLSPAN"]].($key+1)))->applyFromArray(
								array(
									'font'    => array(
										'bold'      => true
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
									),
									'borders' => array(
										'top'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'left'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'right'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				),
						 				'bottom'     => array(
						 					'style' => PHPExcel_Style_Border::BORDER_THIN
						 				)
									),
									'fill' => array(
							 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
							  			'rotation'   => 90,
							 			'startcolor' => array(
							 				'argb' => 'AA528B8B'
							 			),
							 			'endcolor'   => array(
							 				'argb' => 'AAFFFAF0'
							 			)
							 		)
								)
						);
					}else{
						$xPHPExcel->getActiveSheet()->getStyle(($xCol[$indx+$lastColspan].($key+1)).":".($xCol[$indx+($lastColspan)+(int)$vlx["COLSPAN"]].($key+1)))->applyFromArray(
								array(
									'font'    => array(
										'bold'      => true
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
									),
									'fill' => array(
							 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
							  			'rotation'   => 90,
							 			'startcolor' => array(
							 				'argb' => 'AA528B8B'
							 			),
							 			'endcolor'   => array(
							 				'argb' => 'AAFFFAF0'
							 			)
							 		)
								)
						);
					}
					$lastColspan += (int)$vlx["COLSPAN"];
				}
			}
                        if($key==count($HEADERS)-1){
                            $xPHPExcel->getActiveSheet()->getRowDimension($key+1)->setRowHeight(30);
                        }
		}
	}
        
	foreach($COLUMNS as $indx => $cl){
		$xPHPExcel->getActiveSheet()
		->setCellValue($xCol[$indx].(count($HEADERS)+1), $cl);
		$xPHPExcel->getActiveSheet()->getStyle($xCol[$indx].(count($HEADERS)+1))->applyFromArray(
				array(
					'font'    => array(
						'bold'      => false,
						'size'=>10
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'top'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'left'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'right'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'bottom'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				)
					),
					'fill' => array(
			 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			  			'rotation'   => 90,
			 			'startcolor' => array(
			 				'argb' => '0000AA'
			 			),
			 			'endcolor'   => array(
			 				'argb' => 'AAFFFAF0'
			 			)
			 		)
				)
		);

//		$xPHPExcel->getActiveSheet()->getColumnDimension($xCol[$indx])->setAutoSize(true);
                if($indx==0){
                    $xPHPExcel->getActiveSheet()->getColumnDimension($xCol[$indx])->setAutoSize(true);
                }else{
                    $xPHPExcel->getActiveSheet()->getColumnDimension($xCol[$indx])->setWidth((int)($COLUMNWIDTH[$indx]));
                }
	}

	$xPHPExcel->getActiveSheet()->freezePane($LETTERFREEZ.(count($HEADERS)+2));

	$xPHPExcel->getActiveSheet()->getStyle("A1:".$xCol[count($COLUMNS)-1].(count($HEADERS)+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$xPHPExcel->getActiveSheet()->getStyle("A1:".$xCol[count($COLUMNS)-1].(count($HEADERS)+1))->getFill()->getStartColor()->setARGB($HEADER_BACKGROUND_COLOR);

	$xPHPExcel->getActiveSheet()->getStyle("A1:".$xCol[count($COLUMNS)-1].(count($HEADERS)+1))->getFont()->getColor()->setARGB($HEADER_TEXT_COLOR);
	$xPHPExcel->getActiveSheet()->getStyle("A1:".$xCol[count($COLUMNS)-1].(count($HEADERS)+1))->getFont()->setBold(true);
	$xPHPExcel->getActiveSheet()->getStyle("A1:".$xCol[count($COLUMNS)-1].(count($HEADERS)+1))->getFont()->setSize(10);

	$con = mysql_connect($HOST,$USER,$PASS);
    mysql_query("set character set 'utf8'",$con);
    mysql_query("set names 'utf8'",$con);
	$db = mysql_select_db($DATABASE,$con);
	$result = mysql_query($QUERY,$con);

	$lastRow = 1+(count($HEADERS)+1);
	$cntrx = 0;
	$recs = 0;

//	$arrData = array();
//        print_r($QUERY);
//        while($row=mysql_fetch_array($result,MYSQL_ASSOC))
	while($row=mysql_fetch_assoc($result)){
//		array_push($arrData,$row);
		foreach($row as $xxx => $yyy) {
			if($FORMATS[$cntrx]=="Number"){
				if((int)$yyy==(int)$VALUE_BLANK){
					$yyy='';
				}
			}

			$xPHPExcel->getActiveSheet()->setCellValue($xCol[$cntrx].($lastRow), $yyy);
			$xPHPExcel->getActiveSheet()->getStyle($xCol[$cntrx].($lastRow))->applyFromArray(
				array(
					'alignment' => array(
						'horizontal' => strtolower($ALIGNMENTS[$cntrx]),
						'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'top'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'left'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'right'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				),
		 				'bottom'     => array(
		 					'style' => PHPExcel_Style_Border::BORDER_THIN
		 				)
					)
				)
			);
                        if($HAS_COLOR_CONDITION){
                            if(in_array($yyy, $VALUE_COLOR)){
                                $xPHPExcel->getActiveSheet()->getStyle($xCol[$cntrx].($lastRow))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $xPHPExcel->getActiveSheet()->getStyle($xCol[$cntrx].($lastRow))->getFill()->getStartColor()->setARGB('FF'.$VALUE_COLOR_NAME);
                                if($VALUE_COLOR_BLANK){
                                    $xPHPExcel->getActiveSheet()->setCellValue($xCol[$cntrx].($lastRow), '');
                                }else{
                                    $xPHPExcel->getActiveSheet()->setCellValue($xCol[$cntrx].($lastRow),mb_convert_encoding($yyy, 'sjis-win'));
//                                    iconv('SHIFT-sjis', 'UTF-8', $yyy)
                                }
                            }
                        }
			$cntrx++;
		}
		$lastRow++;
		$cntrx=0;
		$recs++;
	}

	// $xPHPExcel->getActiveSheet()->getStyle("A".(count($HEADERS)+2).":".($xCol[count($COLUMNS)-1]).(($recs)+count($HEADERS)+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$xPHPExcel->getActiveSheet()->getStyle("A".(count($HEADERS)+2).":".($xCol[count($COLUMNS)-1]).(($recs)+count($HEADERS)+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	//COMPUTE IF HAS TOTAL
	if(count($HASTOTAL) > 0){
		foreach ($HASTOTAL as $key => $value) {
			if($value){
				$xPHPExcel->getActiveSheet()->setCellValue($xCol[$key].(($recs)+count($HEADERS)+2), '=IF(SUM('.($xCol[$key].(count($HEADERS)+2)).":".($xCol[$key].(($recs)+count($HEADERS)+1)).')=0,"",SUM('.($xCol[$key].(count($HEADERS)+2)).":".($xCol[$key].(($recs)+count($HEADERS)+1)).'))');
				$xPHPExcel->getActiveSheet()->getStyle($xCol[$key].(($recs)+count($HEADERS)+2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				$xPHPExcel->getActiveSheet()->getStyle($xCol[$key].(($recs)+count($HEADERS)+2))->getFont()->setBold(true);

				$xPHPExcel->getActiveSheet()->getStyle($xCol[$key].(($recs)+count($HEADERS)+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$xPHPExcel->getActiveSheet()->getStyle($xCol[$key].(($recs)+count($HEADERS)+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			}
		}
	}
        if((int)$AUTOFILTER==1){
            $xPHPExcel->getActiveSheet()->setAutoFilter("A".(count($HEADERS)+1).":".($xCol[count($COLUMNS)-1]).(count($HEADERS)+1));
        }
	$xPHPExcel->getActiveSheet()->setTitle($WORKSHEET_NAME);

	mysql_free_result($result);
	mysql_close($con);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$FILE_N.'.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');

	$xWRITER = PHPExcel_IOFactory::createWriter($xPHPExcel, 'Excel5');
	$xWRITER->save('php://output');

	function getCOLUMN_AB($LIMIT){
		$str1 = "A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z";
		$str2 = "AA|AB|AC|AD|AE|AF|AG|AH|AI|AJ|AK|AL|AM|AN|AO|AP|AQ|AR|AS|AT|AU|AV|AW|AX|AY|AZ";
		$str3 = "BA|BB|BC|BD|BE|BF|BG|BH|BI|BJ|BK|BL|BM|BN|BO|BP|BQ|BR|BS|BT|BU|BV|BW|BX|BY|BZ";
		$str4 = "CA|CB|CC|CD|CE|CF|CG|CH|CI|CJ|CK|CL|CM|CN|CO|CP|CQ|CR|CS|CT|CU|CV|CW|CX|CY|CZ";
		$str5 = "DA|DB|DC|DD|DE|DF|DG|DH|DI|DJ|DK|DL|DM|DN|DO|DP|DQ|DR|DS|DT|DU|DV|DW|DX|DY|DZ";
		$str6 = "EA|EB|EC|ED|EE|EF|EG|EH|EI|EJ|EK|EL|EM|EN|EO|EP|EQ|ER|ES|ET|EU|EV|EW|EX|EY|EZ";
		$str7 = "FA|FB|FC|FD|FE|FF|FG|FH|FI|FJ|FK|FL|FM|FN|FO|FP|FQ|FR|FS|FT|FU|FV|FW|FX|FY|FZ";
		$str8 = "GA|GB|GC|GD|GE|GF|GG|GH|GI|GJ|GK|GL|GM|GN|GO|GP|GQ|GR|GS|GT|GU|GV|GW|GX|GY|GZ";
		$str9 = "HA|HB|HC|HD|HE|HF|HG|HH|HI|HJ|HK|HL|HM|HN|HO|HP|HQ|HR|HS|HT|HU|HV|HW|HX|HY|HZ";
		$str10 ="IA|IB|IC|ID|IE|IF|IG|IH|II|IJ|IK|IL|IM|IN|IO|IP|IQ|IR|IS|IT|IU|IV|IW|IX|IY|IZ";
		$str11 ="JA|JB|JC|JD|JE|JF|JG|JH|JI|JJ|JK|JL|JM|JN|JO|JP|JQ|JR|JS|JT|JU|JV|JW|JX|JY|JZ";
		$str12 ="KA|KB|KC|KD|KE|KF|KG|KH|KI|KJ|KK|KL|KM|KN|KO|KP|KQ|KR|KS|KT|KU|KV|KW|KX|KY|KZ";
		$str13 ="LA|LB|LC|LD|LE|LF|LG|LH|LI|LJ|LK|LL|LM|LN|LO|LP|LQ|LR|LS|LT|LU|LV|LW|LX|LY|LZ";
		$str14 ="MA|MB|MC|MD|ME|MF|MG|MH|MI|MJ|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ";
		$str15 ="NA|NB|NC|ND|NE|NF|NG|NH|NI|NJ|NK|NL|NM|NN|NO|NP|NQ|NR|NS|NT|NU|NV|NW|NX|NY|NZ";
		$str16 ="OA|OB|OC|OD|OE|OF|OG|OH|OI|OJ|OK|OL|OM|ON|OO|OP|OQ|OR|OS|OT|OU|OV|OW|OX|OY|OZ";
		$str17 ="PA|PB|PC|PD|PE|PF|PG|PH|PI|PJ|PK|PL|PM|PN|PO|PP|PQ|PR|PS|PT|PU|PV|PW|PX|PY|PZ";
		$str18 ="QA|QB|QC|QD|QE|QF|QG|QH|QI|QJ|QK|QL|QM|QN|QO|QP|QQ|QR|QS|QT|QU|QV|QW|QX|QY|QZ";
		$str19 ="RA|RB|RC|RD|RE|RF|RG|RH|RI|RJ|RK|RL|RM|RN|RO|RP|RQ|RR|RS|RT|RU|RV|RW|RX|RY|RZ";
		$str20 ="SA|SB|SC|SD|SE|SF|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SP|SQ|SR|SS|ST|SU|SV|SW|SX|SY|SZ";
		$str21 ="TA|TB|TC|TD|TE|TF|TG|TH|TI|TJ|TK|TL|TM|TN|TO|TP|TQ|TR|TS|TT|TU|TV|TW|TX|TY|TZ";
		$str22 ="UA|UB|UC|UD|UE|UF|UG|UH|UI|UJ|UK|UL|UM|UN|UO|UP|UQ|UR|US|UT|UU|UV|UW|UX|UY|UZ";
		$str23 ="VA|VB|VC|VD|VE|VF|VG|VH|VI|VJ|VK|VL|VM|VN|VO|VP|VQ|VR|VS|VT|VU|VV|VW|VX|VY|VZ";
		$str24 ="WA|WB|WC|WD|WE|WF|WG|WH|WI|WJ|WK|WL|WM|WN|WO|WP|WQ|WR|WS|WT|WU|WV|WW|WX|WY|WZ";
		$str25 ="XA|XB|XC|XD|XE|XF|XG|XH|XI|XJ|XK|XL|XM|XN|XO|XP|XQ|XR|XS|XT|XU|XV|XW|XX|XY|XZ";
		$str26 ="YA|YB|YC|YD|YE|YF|YG|YH|YI|YJ|YK|YL|YM|YN|YO|YP|YQ|YR|YS|YT|YU|YV|YW|YX|YY|YZ";
		$str27 ="ZA|ZB|ZC|ZD|ZE|ZF|ZG|ZH|ZI|ZJ|ZK|ZL|ZM|ZN|ZO|ZP|ZQ|ZR|ZS|ZT|ZU|ZV|ZW|ZX|ZY|ZZ";

		$strs = array();
		if($LIMIT < 26){
			$strs = explode("|", $str1);
		}else if($LIMIT >= 26 && $LIMIT < (26*2)){
			$strs = explode("|", $str1."|".$str2);
		}else if($LIMIT >= (26*2) && $LIMIT < (26*3)){
			$strs = explode("|", $str1."|".$str2."|".$str3);
		}else if($LIMIT >= (26*3) && $LIMIT < (26*4)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4);
		}else if($LIMIT >= (26*4) && $LIMIT < (26*5)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5);
		}else if($LIMIT >= (26*5) && $LIMIT < (26*6)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6);
		}else if($LIMIT >= (26*6) && $LIMIT < (26*7)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7);
		}else if($LIMIT >= (26*7) && $LIMIT < (26*8)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8);
		}else if($LIMIT >= (26*8) && $LIMIT < (26*9)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9);
		}else if($LIMIT >= (26*9) && $LIMIT < (26*10)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10);
		}else if($LIMIT >= (26*10) && $LIMIT < (26*11)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11);
		}else if($LIMIT >= (26*11) && $LIMIT < (26*12)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12);
		}else if($LIMIT >= (26*12) && $LIMIT < (26*13)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13);
		}else if($LIMIT >= (26*13) && $LIMIT < (26*14)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14);
		}else if($LIMIT >= (26*14) && $LIMIT < (26*15)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15);
		}else if($LIMIT >= (26*15) && $LIMIT < (26*16)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16);
		}else if($LIMIT >= (26*16) && $LIMIT < (26*17)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17);
		}else if($LIMIT >= (26*17) && $LIMIT < (26*18)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18);
		}else if($LIMIT >= (26*18) && $LIMIT < (26*19)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19);
		}else if($LIMIT >= (26*19) && $LIMIT < (26*20)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20);
		}else if($LIMIT >= (26*20) && $LIMIT < (26*21)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21);
		}else if($LIMIT >= (26*21) && $LIMIT < (26*22)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22);
		}else if($LIMIT >= (26*22) && $LIMIT < (26*23)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22."|".$str23);
		}else if($LIMIT >= (26*23) && $LIMIT < (26*24)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22."|".$str23."|".$str24);
		}else if($LIMIT >= (26*24) && $LIMIT < (26*25)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22."|".$str23."|".$str24."|".$str25);
		}else if($LIMIT >= (26*25) && $LIMIT < (26*26)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22."|".$str23."|".$str24."|".$str25."|".$str26);
		}else if($LIMIT >= (26*26) && $LIMIT < (26*27)){
			$strs = explode("|", $str1."|".$str2."|".$str3."|".$str4."|".$str5."|".$str6."|".$str7."|".$str8."|".$str9."|".$str10."|".$str11."|".$str12."|".$str13."|".$str14."|".$str15."|".$str16."|".$str17."|".$str18."|".$str19."|".$str20."|".$str21."|".$str22."|".$str23."|".$str24."|".$str25."|".$str26."|".$str27);
		}

		return $strs;
	}
?>