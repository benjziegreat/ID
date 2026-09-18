function setContextMenu(rightClickableClassName,contextMenuID){ 
            
			if(!($('#'+contextMenuID).hasClass("vmenu"))){
			    $('#'+contextMenuID).addClass("vmenu");
			}
			
			$('.'+rightClickableClassName).unbind('contextmenu');
			
			$('.'+rightClickableClassName).bind('contextmenu',function(e){
				
				$(".vmenu").hide();
			    var $cmenu = $($('#'+contextMenuID));
				if($(this).attr("role")=='gridcell'){
				  //alert($(this).parents("tr").length);
				  jQuery('#'+$(this).parents("table").attr("id")).jqGrid('setSelection',$(this).parents("tr").first().index());
				}

				var menuBottom   = (parseInt($('#'+contextMenuID).css("height").replace('px',''),10)+parseInt(e.pageY,10));
				var screenHeight = $(window).height();
				
				if((screenHeight - menuBottom)<0){
				  var menuTop = e.pageY + screenHeight - menuBottom - 6;
				}else{
				  var menuTop = e.pageY;
				}
				

			    $($('#'+contextMenuID)).css({ left: e.pageX + 2, top: menuTop, zIndex: '101' }).show();
				
				$($('#'+contextMenuID)).first("*").keyup(function(e){
				    if (e.keyCode == 27) { $('#'+contextMenuID).hide(); }
				});
				
			    return false;
			});
			 
			$(document).keyup(function(e){
			    if (e.keyCode == 27) { $('#'+contextMenuID).hide(); }
			});

			 $('*').bind('contextmenu',function(e){
			    var $cmenu = $($('#'+contextMenuID));
				if(!$(this).hasClass(rightClickableClassName)){
				  $cmenu.hide();
				  
				  //return false;
				}
			 }).click(function(e){ 
			   if( $(this).parents('.vmenu').length==0 ){
				   var $cmenu = $($('#'+contextMenuID));
				   $cmenu.hide(); 
			   }
			 });

 
			 $('#'+contextMenuID+' .first_li').on('click',function() {
		        event.stopPropagation();
                if( !($(this).find(".inner_li").length>0) ){
					$('#'+contextMenuID).hide();
				}
			 });
 
			 $('#'+contextMenuID+' .inner_li').on('click',function() {
					$('#'+contextMenuID).hide();
			 });

 
			$(".first_li , .sec_li, .inner_li span").hover(
			    function () {
			        if ( $(this).find('.inner_li').length >0 ){
					    $($(this).find('.inner_li').get(0)).show();
						
						var screenHeight = $(window).height();
						if( (screenHeight - ($($(this).find('.inner_li').get(0)).offset().top + $($(this).find('.inner_li').get(0)).height())) < 0 ){
					        $($(this).find('.inner_li').get(0)).css("top", ($($(this).find('.inner_li').get(0)).position().top - $($(this).find('.inner_li').get(0)).height() + $(this).height())+"px");
						}else{
							$($(this).find('.inner_li').get(0)).css("top", ($(this).position().top+$(this).height())+"px");
						}
					}
					
			    }, 
			    function () {
			        if ( $(this).find('.inner_li').length >0 ){

						var screenHeight = $(window).height();
						if( $(this).offset().top != $($(this).find('.inner_li').get(0)).offset().top+2 ){
							$($(this).find('.inner_li').get(0)).css("top", ($(this).position().top+$(this).height())+"px");
						}
					}
				    $(this).find('.inner_li').hide();
			});
			
			$(".first_li").each(function(index, element) {
                if($(element).find(".inner_li").length>0){
				  $(element).addClass("vmenu_haschild");
				}
            });
			
}

function enableContextMenuItem(itemClass){
	$("."+itemClass).removeClass("vmenu_dispan");
	$("."+itemClass).each(function(index, element) {
        if($(element).attr("onclick")){
		    var oldClick = $(element).attr("onclick")+'';
			oldClick = oldClick.replace("event.stopPropagation();return false;",'');
			$(element).removeAttr("onclick");
			    $(element).attr("onclick",oldClick);
		}
    });
}

function disableContextMenuItem(itemClass){
	$("."+itemClass).removeClass("vmenu_dispan");
	$("."+itemClass).addClass("vmenu_dispan");
	$("."+itemClass).each(function(index, element) {
        if($(element).attr("onclick")){
            var oldClick = $(element).attr("onclick")+'';
		    oldClick = oldClick.replace("event.stopPropagation();return false;",'');
		    $(element).removeAttr("onclick");
		   $(element).attr("onclick","event.stopPropagation();return false;"+oldClick);
		}
    });
}
