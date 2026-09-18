// JavaScript Document
/// Created by: Ayant P. Orcasitas
/// Date Created: 12-Dec-2011
/// Remarks:
/// Reference: The setCookie and  getCookie were copied from sample in the web

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);

	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i,x,y,arrCookies=document.cookie.split(";");
	for (i=0;i<arrCookies.length;i++)
	{
		x=arrCookies[i].substr(0,arrCookies[i].indexOf("="));
		y=arrCookies[i].substr(arrCookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		
		if (x==c_name)	
		{
			return unescape(y);
		}
	}	
}

function changeLang($val) 
{
	 if (getCookie("lang")==$val) return;
	setCookie("lang",$val,null);
	window.location.reload();
}

function clickLabel(){
	$(function(){
		$(document).ready(function() {
			$("label").click(function(e){if(e.ctrlKey) 	getLabelLanguage(this);});
			$(":button").click(function(e){if(e.ctrlKey) getLabelLanguage(this);});
			$(":submit").click(function(e){if(e.ctrlKey) getLabelLanguage(this);});
					
		});
	});

}

$(function(){
	$(document).ready(function() {
		$("input :button,:submit").click(function(e){			
			if(e.ctrlKey) return false;
		});
	});
});
	
$(function(){
	$(document).ready(function() {
		$("a").click(function(e){			
			if(e.ctrlKey) return false;
		});
	});
});		

function getLabelLanguage(ctrl){

	//alert(ctrl.type.toUpperCase());
	
	var oldObj= document.getElementById("labelDiv");		
	if(oldObj!=null) document.body.removeChild(oldObj);
	
	var lbl=document.createElement("div");
	lbl.id="labelDiv";
	
	
	var args=(ctrl.id).split("-");
	var appName='';
	var labelID='';
	var labelName='';

	appName=args[0];
	labelID=args[1];		
	labelName=ctrl.name==null?'':ctrl.name;
	
	document.body.appendChild(lbl);
//	alert('AppName:'+appName+'  LabelID:'+labelID+'  LabelName:'+labelName);

	$("#labelDiv").load("http://apps.nkym.co.jp/nkymERP/cont.label.utility/index",{'AppName':appName,'LabelID': labelID,'LabelName':labelName},function(response, status, xhr) {
		if (status == "error") {
			var msg = "Sorry but there was an error: ";
			$("#error").html(msg + xhr.status + " " + xhr.statusText);
		}
	}); 			
		
	$(document).ready(function() {
		$("#labelDiv").dialog({
			title: args[1],
			width:500,
			height:600,
			modal:true,
			close: function(event, ui) {
				 $(this).dialog("destroy");
			},
			buttons: [
				{
					id:'bLabelAccept',
					text:'Ok',
					click:function(){

						var lblArr={};
						$('#labelDiv textarea').each(function(){
							if(this.id !=null ){
								lblArr[this.id]=this.value;	
							}							
						});

						$('#labelDiv input').each(function(){
							if(this.id !=null && this.value !=null){
								lblArr[this.id]=this.value;
							}							
						});					
//						alert(JSON.stringify(lblArr));
//						alert(document.getElementById(ctrl.id));
						$.post("http://apps.nkym.co.jp/nkymERP/cont.label.utility/save",lblArr,function(data){
							if(ctrl.tagName=='INPUT') ctrl.value=data.trim();
							else ctrl.innerHTML=data.trim();
						});						

						$(this).dialog('close');
						$(this).dialog("destroy");
					}					
				},
				{
					id:'bLabelCancel',
					text:'Cancel',
					click:function(){
						$(this).dialog('close');
						$(this).dialog("destroy");
					}
				},						
			]
		});	
		return false;			        		
	});
}
