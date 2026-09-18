<?php

	//$datefrom 	= isset($_GET["datefrom"]) ? $_GET["datefrom"] : date("Y-m-t",'2004-01-01');
	$datefrom 	= isset($_GET["datefrom"]) ? date("Y-m-t",strtotime($_GET["datefrom"])) : date("Y-m-t",strtotime('2004-01-01'));
	$dateto 	= isset($_GET["dateto"]) ? date("Y-m-t",strtotime($_GET["dateto"])) : date("Y-m-t");
	
	
	$yearspan  	= (date('Y', strtotime($dateto)) - date('Y', strtotime($datefrom)))+1; 
	
	$syear 		= date('Y', strtotime($datefrom));
	$ssmonth 	= (date('m', strtotime($datefrom)))+0;
	$thismonth 	= date('m',strtotime($dateto));
	$thisyear  	= date('Y', strtotime($dateto));
	

    $isstart=0;
	for($i=0;$i<$yearspan;$i++){
		$runyear			= $syear + $i;
		$data[$i]['name'] 	= $runyear;		
		if($runyear==$thisyear){
				$smonthn = 1;
				$datas = array();
				for($z=0;$z<$thismonth;$z++){
					$datas[$z] = $smonthn+$z;			
					$a = $smonthn+$z;
					echo "$runyear ---> equal->$a";
				}					
				
		} else { 
			if(($isstart+0)==0){
				$datas = array();
				for($z=($ssmonth-1);$z<12;$z++){
					$datas[$z] = $ssmonth++;			
				}				
			} else { 
				$datas = array();
				$smonth = 1;
				for($z=0;$z<12;$z++){
					$datas[$z] = $smonth + $z;			
				}
			}
		}
		$isstart=1;
		$data[$i]['categories'] 	= "[".implode(",",$datas)."]";		
	}
	$xaxis = json_encode($data);
	$xaxis = str_replace('"','',$xaxis);	
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>売上推移グラフ</title>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<link rel="stylesheet" type="text/css" href="../../includes/jquery/themes-1.6rc5/base/ui.all.css" />

<script type='text/javascript' src='chart/js/jquery-1.4.3.min.js'></script>

<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/external/jquery.bgiframe-2.1.1.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../includes/jquery-ui-1.8.2/ui/jquery.ui.dialog.js"></script>
<script language="javascript">

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

$(function(){

$(document).ready(function() {
        chartOption1 = {
				chart: {
					renderTo: 'container',
					type: 'line'
				},
				title: {
					text: 'エキスポート売上推移グラフ',
					x: -20 //center
				   ,style: {
					 fontSize: '25px'
					,color: 'black'
				   }					
				},
				xAxis: {
					categories: <?=$xaxis?>
				},
				yAxis: {
					min: 0,
					title: {
						text: '売上推移'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}],
					labels: {
						align: 'left',
						x: 0,
						y: -2,
						formatter: function () {
							var val = this.value; 
				            return val.formatMoney(2,'.',',');
				        }
					}				
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ (this.y).formatMoney(2,'.',',');
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: []
        };
		 loadJasonToChart(chartOption1);		
		

        chartOption2 = {
				chart: {
					renderTo: 'containerlocal',
					type: 'line'
				},
				title: {
					text: '	ローカル売上推移グラフ',
					x: -20 //center
				   ,style: {
					 fontSize: '25px'
					,color: 'black'
				   }					
				},
				xAxis: {
					categories: <?=$xaxis?>
				},
				yAxis: {
					min: 0,
					title: {
						text: '売上推移'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}],
					labels: {
						align: 'left',
						x: 0,
						y: -2,
						formatter: function () {
							var val = this.value; 
				            return val.formatMoney(2,'.',',');
				        }
					}				
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ (this.y).formatMoney(2,'.',',');
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: []
        };
		loadJasonToChart2(chartOption2);	


 chartOption3 = {
				chart: {
					renderTo: 'containertotal',
					type: 'line'
				},
				title: {
					text: '	合計売上推移グラフ',
					x: -20 //center
				   ,style: {
					 fontSize: '25px'
					,color: 'black'
				   }					
				},
				xAxis: {
					categories: <?=$xaxis?>
				},
				yAxis: {
					min: 0,
					title: {
						text: '売上推移'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}],
					labels: {
						align: 'left',
						x: 0,
						y: -2,
						formatter: function () {
							var val = this.value; 
				            return val.formatMoney(2,'.',',');
				        }
					}				
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							this.x +': '+ (this.y).formatMoney(2,'.',',');
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: []
        };
		loadJasonToChart3(chartOption3);			
       	
		
});


$(".is-date").datepicker({ 
						   dateFormat  : 'yy-mm-dd'
						   ,changeYear: true
						   ,changeMonth: false
						   ,disabled   : true
						   ,dayNamesMin: ['日', '月', '火', '水', '木', '金', '土']
						   ,monthNames : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
						   ,onClose    : function(dateText, inst) { if($(this).attr("id")=="estcon_sdate"){ $(this).datepicker('destroy'); $(this).change(); } }
});


});   


function loadJasonToChart(chartOption1){

  $.getJSON(
    "ntcsalesgraphjson.php?datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&istype=0",
	function(jsonReturn){
	  	var series1;
		var vals2 = new Array();
		$(jsonReturn).each(function(index,value) {
			var vals  = value['data'].split(',');
			$.each(vals,function(index,value){
				vals[index] = parseFloat(value,10);				
			});
			series1 = { name: value['name'],data: vals };
			chartOption1.series.push(series1);
			
		});
		 var chart1 = new Highcharts.Chart(chartOption1);
  });
}

function loadJasonToChart2(chartOption2){

  $.getJSON(
    "ntcsalesgraphjson.php?datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&istype=1",
	function(jsonReturn){
	  	var series1;
		var vals2 = new Array();
		$(jsonReturn).each(function(index,value) {
			var vals  = value['data'].split(',');
			$.each(vals,function(index,value){
				vals[index] = parseFloat(value,10);				
			});
			series1 = { name: value['name'],data: vals };
			chartOption2.series.push(series1);
			
		});
		 var chart2 = new Highcharts.Chart(chartOption2);
  });
}

function loadJasonToChart3(chartOption3){

  $.getJSON(
    "ntcsalesgraphjson.php?datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&istype=2",
	function(jsonReturn){
	  	var series1;
		var vals2 = new Array();
		$(jsonReturn).each(function(index,value) {
			var vals  = value['data'].split(',');
			$.each(vals,function(index,value){
				vals[index] = parseFloat(value,10);				
			});
			series1 = { name: value['name'],data: vals };
			chartOption3.series.push(series1);
			
		});
		 var chart3 = new Highcharts.Chart(chartOption3);
  });
}


function showgraph(){
	var datefrom = $("#datefrom").val();
	var dateto = $("#dateto").val();
	document.location.href="ntcgraphsales.php?datefrom="+datefrom+"&dateto="+dateto;
	
}

function switchnow(){
	var switchto = $("#switchto").val();
	if(switchto=="monthly"){
		document.location.href="ntcgraphsales.php";
	}
	if(switchto=="yearly"){
		document.location.href="ntcgraphsalesyear.php";
	}	
}

function numberWithCommas(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
}

</script>
<script type="text/javascript" src="chart/js/highcharts.js"></script>
<!-- <script type="text/javascript" src="chart/js/modules/exporting.js"></script> -->
<script type="text/javascript" src="chart/js/grouped-categories.js"></script>
<style type="text/css">
#menuBar{
	position: absolute;
	top: 0px;
	left:0px;
	z-index: 99;
	
	-moz-border-radius: 0px px 5px 5px;
	-webkit-border-radius: 0px 0px 5px 5px;
	border-radius: 0px px 5px 5px;
	
	background-color: #CC1122;
	border: #666666 thin solid;
	
	width:99.9%;
	height: 2em;
	overflow: visible;
	padding: 3px;
}
</style>
</head>

<body>
<div id="menuBar">
<table width="100%">
<tr>
<td width="50%" align="left">
<input type="text" readonly="readonly" id="datefrom" name="datefrom" class="is-date" value="<?=$datefrom?>" size="12" style="text-align:center" /> ～
<input type="text" readonly="readonly" id="dateto" name="dateto" class="is-date" value="<?=$dateto?>" size="12" style="text-align:center" />
<input type="button" value=" GO " onclick="showgraph()"  /> 
</td>
<td align="right">
	<select id="switchto" name="switchto" onchange="switchnow()">
		<option value="yearly"> 毎年 </option>	
		<option value="monthly" selected="selected"> 毎月 </option>
	</select>
</td>
</tr>
</table>
</div>
<div id="container" style="width: 100%; position: relative; top:3em;left:0px; height: 800px; margin: 0 auto"></div><br /><br />
<div id="containerlocal" style="width: 100%; position: relative; top:3em; left:0px; height: 800px; margin: 0 auto"></div> <br /><br />
<div id="containertotal" style="width: 100%; position: relative; top:3em; left:0px; height: 800px; margin: 0 auto"></div> <br /><br />

</body>
</html>
