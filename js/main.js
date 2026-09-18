/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var developers;
var ok = false;
var today = $.datepicker.formatDate('yy-mm-dd', new Date());
var prev;
var curr = today;
 var DateDiff = {
    inDays: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000));
    },

    inWeeks: function(d1, d2) {
        var t2 = d2.getTime();
        var t1 = d1.getTime();

        return parseInt((t2-t1)/(24*3600*1000*7));
    },

    inMonths: function(d1, d2) {
        var d1Y = d1.getFullYear();
        var d2Y = d2.getFullYear();
        var d1M = d1.getMonth();
        var d2M = d2.getMonth();

        return (d2M+12*d2Y)-(d1M+12*d1Y);
    },

    inYears: function(d1, d2) {
        return d2.getFullYear()-d1.getFullYear();
    }

}
$(document.documentElement).keyup(function (event) {
    // handle cursor keys
    if (event.keyCode == 37) {
        // go left
        
        prev = new Date(curr);
        
        prev.setDate(prev.getDate()-1);
        curr = $.datepicker.formatDate('yy-mm-dd', prev);
        $("#txtPrjTimelineManagerDatePicker").val(curr);
        
        //refreshDailyView(curr);
        refreshDeveloperTask(curr)
    } else if (event.keyCode == 39) {
        // go right
        
        next = new Date(curr);
        
        next.setDate(next.getDate()+1);
               
        
        var tday = new Date();
        
        
        if(next==tday){
            curr = today;
            $("#txtPrjTimelineManagerDatePicker").val(today);
            //refreshDailyView(today) ;
            refreshDeveloperTask(today)
            
        }
        else if(next>tday){
            curr = today;
            $("#txtPrjTimelineManagerDatePicker").val(today);
            refreshDeveloperTask(today)
        }
        else{
            curr = $.datepicker.formatDate('yy-mm-dd', next);
            $("#txtPrjTimelineManagerDatePicker").val(curr);
            //refreshDailyView(curr);
            refreshDeveloperTask(curr)
        }
        
    }
});
$(window).resize(function(){
    $('#MainDiv').position({
                    my: "center top",
                    at: "center top",
                    of: $(window)
                });
   $('#MainDiv').css('top','0px');
});
 $(document).ready(function(){

                $("#MainTabs").tabs();
                $("#MainTabs").show();
                $("input:button").button();
                $('#MainDiv').position({
                    my: "center top",
                    at: "center top",
                    of: $(window)
                });
                $('#MainDiv').css('top','0px');
                

                
                
                getDeveloperDetails();
                getDeveloperTasks('','',1);
                //showDailyView(today);
                showDevelopers();
                showDeveloperTask(today);
                
                
                $("#prjTimelineDeveloperFormNewDiv").dialog({
                    autoOpen:false,
                    width:550,
                    resizable:false,
                    modal:true,
                    title:'Add a New Task',
                    buttons:{
                        'Save':function(){
                            var FileData = new FormData();
                            FileData.append('POSTPARAM[ProjectName]',$("#prjName").val());
                            FileData.append('POSTPARAM[ProjectModuleName]',$("#prjModName").val());
                            FileData.append('ProjectAttachment',$("#prjOrderSheet").prop('files')[0]);
                            FileData.append('POSTPARAM[ProjectStart]',$("#prjDateStart").val());
                            $.ajax({
                                url:"models/mod.prj.timeline.php?ACTION=InsertUpdateTask",
                                data:FileData,
                                type:"POST",                               
                                contentType:false,
                                cache:false,
                                processData:false,
                                success:function(data){
                                    if(data=="success"){
                                        alert("Success");
                                        refreshDevelopments('');
                                        refreshDeveloperTask(today);
                                        closeDialog("prjTimelineDeveloperFormNewDiv");
                                    }else{
                                        alert("Please Contact Your System Administrator");
                                    }
                                }
                               
                            });
                        },
                        'Close':function(){
                            $(this).dialog('close');
                        }                        
                    },
                    close:function(){
                        $("#prjTimelineDeveloperFormNewForm")[0].reset();
                    }
                });
                
                
                $("#editFormDiv").dialog({
                    autoOpen:false,
                    width:450,
                    resizable:false,
                    modal:true,
                    title:'Edit Profile',
                    buttons:[
                        {
                        id:'btnSaveProfile',
                        text:'Save',
                        click:function(){
                           var FileData = new FormData();
                           var data = $(this).children('form').serializeArray();
                            $.each(data,function(i,v){
                                var x = v.name.replace("developer","");
                                FileData.append('POSTPARAM['+x+']',v.value);
                                
                            });
                             FileData.append('PhotoAttachment',$("#developerPic").prop('files')[0]);
                              $.ajax({
                                url:"models/mod.prj.timeline.php?ACTION=UpdateAccount",
                                data:FileData,
                                type:"POST",  
                                cache:false,
                                contentType:false,
                                processData:false,
                                success: function(jsonReturn){
                                    if (jsonReturn == "Success"){
                                        alert("Saved!");
                                        refreshDeveloperDetails()
                                        refreshDeveloperTask(today);
                                        closeDialog("editFormDiv");
                                    }
                                    else{
                                        alert("Failed!");
                                    }
                                }
                            });
                        }
                    },
                    {
                        id:'btnCancelSaveProfile',
                        text:'Cancel',
                        click:function(){
                            $(this).dialog('close');
                        }
                    }
                ],
                    close:function(){
                        $(this).children('form')[0].reset();
                        $("#divPdcStockImageMain").empty();
                    }
                });
   
                
                $("#btnPrjTimelineDeveloperFormNew").click(function(){
                    $("#prjTimelineDeveloperFormNewDiv").dialog("open");
                });
                
                $("#btnEmpProfileEdit").click(function(){
                    getDeveloperDetailsJsonArray();
                    $("#btnSaveProfile").button({
                       disabled:false
                    });
                    $("#editFormDiv").dialog("open");
                    
                });
                
                $("#btnSaveProfile").click(function(){
                   $(this).button({
                       disabled:true
                   });
                });
                
                $("#btnPrjTimelineDeveloperFormLogout").click(function(){
                    doLogout();                    
                });
                
                $("#btnPrjTimelineDeveloperFormAll").click(function(){
                    refreshDevelopments('');
                });
                
                $("#txtPrjTimelineDeveloperFormDatePicker").datepicker({
                    maxDate:0,
                    defaultDate:1,
                    dateFormat:'yy-mm-dd',
                    showButtonPanel: true
                }).change(function(){
                    $("#prjTimelineDeveloperFormExistingDiv").empty();
                    getDeveloperTasks('',$(this).val(),1);
                });
                
                $("#txtPrjTimelineManagerDatePicker").datepicker({
                    maxDate:0,
                    defaultDate:1,
                    dateFormat:'yy-mm-dd',
                    showButtonPanel: true
                }).change(function(){
                   refreshDeveloperTask($(this).val());
                });
                
                
                                
               
                
                
                
                                
                $("#txtPrjTimelineDeveloperFormDatePicker,#txtPrjTimelineManagerDatePicker").val($.datepicker.formatDate('yy-mm-dd', new Date()));
                $("#prjDateStart").datepicker({maxDate:0, dateFormat:'yy-mm-dd'});
                $("#developerDateHired").datepicker({dateFormat: "yy-mm-dd" , maxDate: '0'}).val();
                $("#developerDateSep").datepicker({dateFormat: "yy-mm-dd" , minDate: '0'}).val();
               
               
                
            });
            
            function closeDialog(id){
                $("#"+id+"").dialog("close");
            }
            
            function getDeveloperDetails(id,divID){
                id = id==undefined? '' : id;
                divID= divID==undefined? 'prjTimelineDeveloper' : divID;
                $.getJSON(
                    "models/mod.prj.timeline.php?ACTION=GetDeveloperDetails",
                    {GETPARAM:id},
                    function(jsonDetails){
                        var developer = profileTemplate(jsonDetails[0]);
                        var newDiv = document.createElement('div');
                        $(newDiv).attr('class','EmpProfile')
                        $(newDiv).append(developer);
                        $(newDiv).appendTo("#"+divID);                       
                     
                       
                    }
                    
                );
                
            }

            function getDeveloperDetailsJsonArray(){
                $.getJSON(
                    "models/mod.prj.timeline.php?ACTION=GetDeveloperDetails",
                    function(jsonDetails){
                        
                        $("#developerID").val(jsonDetails[0].EmpID);
                        $("#developerName").val(jsonDetails[0].EmpName);
                        $("#developerPassword").val(jsonDetails[0].EmpPass);
                        $("#developerCellNo").val(jsonDetails[0].CellNo);
                        $("#developerDateHired").val(jsonDetails[0].DateHired);
                        $("#developerDateSep").val(jsonDetails[0].DateSep);
                        $("#developerPicName").val(jsonDetails[0].EmpPic);
                        
                        var imgWidth;
                        var imgHeight;
            
                        var imgPdcStockInfoThumb = "imgPdcStockInfoThumb";
                        $("#" + imgPdcStockInfoThumb).remove();
    
                        var img = document.createElement('img');
                        img.id = imgPdcStockInfoThumb;
                        $(img).css('visibility','none');
                        img.src = 'developerPIC/'+jsonDetails[0].EmpPic;
            
                        document.body.appendChild(img);
    
                        img.onload = function() {
                            imgWidth = img.offsetWidth;
                            imgHeight = img.offsetHeight;
                
                            createImgCanvas(img, imgWidth, imgHeight, 'canvasPdcStockInfoMain', $('#divPdcStockImageMain')); 
                            createImgCanvas(img, imgWidth, imgHeight, 'canvasPdcStockInfoThumb', $('#divPdcStockImageThumb')); 
                            showStockImageCanvasRatio();
                
                            $("#" + imgPdcStockInfoThumb).remove();
                        }
                        
                    }
                );
            }
            
            function getDeveloperTasks(id,date,option,divID){
                divID = divID==undefined? 'prjTimelineDeveloperFormExistingDiv': divID;
                $.getJSON(
                "models/mod.prj.timeline.php?ACTION=GetDeveloperTasks",
                {
                    GETPARAM:{
                        'EmpID':id,
                        'Date':date
                    }
                },
                function(data){
                    if(data.length==0){
                        return;
                    }
                    
                    for(var i =0,v;v=data[i];i++){
                         if(v.ReportDate==null){
                            continue;
                         }
                        var task = developerFormViewTemplate(v,option);
                        
                        $(task).appendTo("#"+divID);
                        $("<br/>").appendTo("#"+divID);
                        
                    }
                                       
                    
                    
                    $("input:button").button();
                    $(".txtPrjDateEnd").datepicker({
                        maxDate:0,
                        dateFormat:'yy-mm-dd',
                        showButtonPanel:true
                    });
                    $(".prjProgressBar").each(function(){
                        var options = {};
                        
                        options.value = parseInt($(this).next().next().children('input').val());
                        $(this).progressbar(options);

                        var DateStart = $(this).parent().parent().find('input.txtPrjDateStart').val();
                        var DateEnd = $(this).parent().parent().find('input.txtPrjDateEnd').val();
                        
                         
                        var progressColor = $(this).children('div');
                               $(progressColor).removeClass('ui-widget-header');
                               
                              if(DateEnd!=""){
                                 //Yellow na siya
                                 $(progressColor).addClass('ui-widget-header-y');
                                 
                              }else{
                                  var dateStart = new Date(DateStart);
                                  var dateToday = new Date();
                                  var dateDiff = DateDiff.inDays(dateStart,dateToday);
                                  
                                  if(dateDiff<=2){
                                      //Green
                                      $(progressColor).addClass('ui-widget-header-g');
                                  }
                                  else if(dateDiff>2 && dateDiff<=5){
                                      //Blue
                                      $(progressColor).addClass('ui-widget-header-b');
                                      
                                  }else if(dateDiff>5){
                                      //Red
                                      $(progressColor).addClass('ui-widget-header-r');
                                  }
                                  
                              }

                    });
                    
                    $(".btnSavePrjProgress").click(function(){
                        saveDevelopment($(this).parent().parent('form').serializeArray());
                    });
                    
                    $(".btnDeletePrjProgress").click(function(){
                        delDevelopment($(this).parent().parent('form').serializeArray());
                    });
                    
                    
                    
                }
            );
            }
            
            function doLogout(){
                document.location.replace('models/mod.prj.timeline.php?ACTION=DoLogOut');
            }
            
            function disableButtons(bln){
                $('.btnSavePrjProgress,.btnDeletePrjProgress').button({
                    disabled:bln
                });
            }
            
            function refreshDevelopments(date){
                $("#prjTimelineDeveloperFormExistingDiv").empty();
                getDeveloperTasks('',date,1);
            }
            
            function refreshDailyView(date){
                $("#prjTimelineView").empty();
                showDailyView(date);
            }
            
            function refreshDeveloperTask(date){
                $(".DeveloperTask").empty();
                showDeveloperTask(date);
                
            }
            
            function refreshDeveloperDetails(){
                $("#prjTimelineDeveloper").empty();         
                getDeveloperDetails();
            }
            
            function saveDevelopment(d){
                
                if(confirm("Are You Sure You Want To [Update] This Development?")){
                     disableButtons(true);
                    $.ajax({
                        url:"models/mod.prj.timeline.php?ACTION=UpdateDevelopment",
                        data:d,
                        type:"POST",
                        success:function(){
                            refreshDevelopments('');
                            refreshDailyView(today);
                        }
                    
                    });
                }
                
            }
            
            function delDevelopment(d){
                if(confirm("Are You Sure You Want To [Delete] This Development?")){
                    disableButtons(true);
                    $.ajax({
                        url:"models/mod.prj.timeline.php?ACTION=RemoveDevelopment",
                        data:d,
                        type:"POST",
                        success:function(){
                            refreshDevelopments('');
                            refreshDailyView(today);
                        }
                    
                    }); 
                }
               
            }
            function percentageUpdate(obj){
            	var currentPercentage = parseInt($(obj).prev().val());
            	var updatePercentage = parseInt(obj.value);
            	if(currentPercentage > updatePercentage){
            		alert("Update Percentage Should Be >[ "+currentPercentage+" ] %");
            		$(obj).val(currentPercentage);
            	}
            }
            
            function developerFormViewTemplate(d,o){
                
                var temp = '<div style="padding:37px;width:500px;border:1px solid black">'+
                    '<form>'+
                        '<div>'+
                            '<input class="txtPrjProgressPercent" name="POSTPARAM[ProjectID]" type="hidden" value="'+d.ProjectID+'"/>'+
                            '<input class="txtPrjReportDate" name="POSTPARAM[ReportDate]" type="hidden" value="'+d.ReportDate+'"/>'+
                            '<input class="txtPrjAttachment" name="POSTPARAM[ProjectAttachment]" type="hidden" value="'+d.ProjectAttachment+'"/>'+
                            '<div class="prjProgressBar" style="width:65%;float:left;border:1px solid black;">'+
                            '<span id="prjTitle" style="position:absolute;margin:7px;white-space: nowrap;width: 300px;overflow: hidden;text-overflow: ellipsis;"><span title="'+d.ProjectName+' - '+d.ProjectModuleName+'">'+d.ProjectName+' - '+d.ProjectModuleName+'</span></span>'+
                        '</div>'   +                         
                        '<span style="clear:both;"></span>'+
                        '<div style="float:right;">'+
                        	'<input type="text" style="display:none;" value="'+(d.Percentage==null? '0' : d.Percentage)+'"/>'+
                            '<input class="txtPrjProgressPercent" name="POSTPARAM[Percentage]" type="text"'+(d.DateEnd==null? '' : 'readonly="readonly"' ) +' size="2" style="text-align:center;" onkeypress="return IsNumeric(event)" onblur="percentageUpdate(this);" value='+(d.Percentage==null? '"0"' : d.Percentage)+' maxlength="3"/> %'+
                        '</div>'+
                        '<span style="clear:both;"></span>'+
                            '<div style="float:right;margin-top: -10px;margin-right:10px">'+
                            (d.ProjectAttachment=="" || d.ProjectAttachment==null ? '' :'<a href="developerAttachments/'+d.ProjectAttachment+'" target="_blank">'+'<img src="developerPIC/attach.png"/></a>')+
                        '</div>'+
                    '</div>'+
                    '<br clear="all"/>'+
                    '<br/>'+
                    '<div>'+
                        '<label>Remarks</label>'+
                        '<textarea class="txtPrjRemarks" name="POSTPARAM[Remarks]" style="margin: 2px;min-width:498px; max-width: 498px; height: 78px; " '+( !o? 'readonly="readonly"' : (d.DateEnd==null? '' : 'readonly="readonly"')) +'>'+(d.Remarks==null? "" : d.Remarks)+'</textarea>'+
                    '</div>'+
                    '<br clear="all"/>'+
                    '<div>'+
                        '<div style="float:left;">'+
                            '<label>Project Start</label>'+
                            '<div>'+
                                '<input class="txtPrjDateStart" name="POSTPARAM[DateStart]" type="text"'+(d.DateEnd==null?(!o? 'disabled="disabled"' :'readonly="readonly"'): 'disabled="disabled"') +'value='+d.DateStart+' /> '+
                            '</div>'+
                        '</div>'+
                        '<span style="clear:both;"></span>'+
                            '<div style="float:right;">'+
                                '<label>Project End</label>'+
                                '<div>'+
                                    '<input class="txtPrjDateEnd" name="POSTPARAM[DateEnd]" type="text" '+(d.DateEnd==null? (!o? 'disabled="disabled"':'') : 'value="'+d.DateEnd+'" disabled="disabled"')+' /> '+
                                '</div> ' +
                            '</div>'+
                    '</div>'+
                    '<br clear="all"/>'+
                    '<hr/>'+(!o? '':
                    '<div style="float:right;">'+
                        (d.DateEnd!=null? '': '<input class="btnSavePrjProgress" type="button" value="Save"/>')
                        +'<input class="btnDeletePrjProgress" type="button" value="Delete"/>')+
                    '</div>'+
                    '<br clear="all"/>'+
                    '</form>'+
                    '</div>';
                
                return temp;
            }
            
            function showDevelopers(){
                 $.ajax({
                     url:'models/mod.prj.timeline.php?ACTION=GetDevelopers',
                     async:false,
                     dataType:'json',
                     success:function(jsonResult){
                        
                        developers = jsonResult;
                        for(var i =0,d;d=jsonResult[i];i++){
                            var developerDiv = document.createElement('div');
                            developerDiv.setAttribute('class', 'DeveloperPanel');
                            developerDiv.setAttribute('id','Developer_'+d.EmpID);


                            var developerProf = profileTemplate(d);
                            var developerProfDiv = document.createElement('div');
                            developerProfDiv.setAttribute('class','DeveloperProfile');
                            
                            $(developerProfDiv).append(developerProf);
                            $(developerDiv).append(developerProfDiv);
                            $(developerDiv).append("<br clear='all'/>");
                            $(developerDiv).append("<br />");
                            var developerTask = document.createElement('div');
                            developerTask.setAttribute('class','DeveloperTask');
                            $(developerDiv).append(developerTask);

                            $(developerDiv).appendTo("#prjTimelineView");
                        }
                    }
            });
                
            }
            
            function showDeveloperTask(date){
                
                for(var i =0,d;d=developers[i];i++){
                    $.getJSON('models/mod.prj.timeline.php',{ACTION:'GetDeveloperTasks',GETPARAM:{'EmpID':d.EmpID,'Date':date}},
                        function(jsonResult){

                           
                            for(var i=0,d;d=jsonResult[i];i++){
                                if(jsonResult[0].ReportDate==null){
                                    continue;
                                }
                                var developerTasks = dailyViewFormTemplate(d)
                                
                                $("#Developer_"+d.EmpID+" .DeveloperTask").append(developerTasks);
                                
                            }
                            
                                                    
                          for(var x=0,e;e=jsonResult[x];x++){
                              var options = {};
                              options.value = parseInt(e.Percentage);
                              $("#dailyViewProgress_"+e.ProjectID+"").progressbar(options);
                              
                               var progressColor = $("#dailyViewProgress_"+e.ProjectID+"").children('div');
                               $(progressColor).removeClass('ui-widget-header');
                               
                              if(e.DateEnd!=null){
                                 //Yellow na siya
                                 $(progressColor).addClass('ui-widget-header-y');
                                 
                              }else{
                                  var dateStart = new Date(e.DateStart);
                                  var dateToday = new Date();
                                  var dateDiff = DateDiff.inDays(dateStart,dateToday);
                                  
                                  if(dateDiff<=2){
                                      //Green
                                      $(progressColor).addClass('ui-widget-header-g');
                                  }
                                  else if(dateDiff>2 && dateDiff<=5){
                                      //Blue
                                      $(progressColor).addClass('ui-widget-header-b');
                                      
                                  }else if(dateDiff>5){
                                      //Red
                                      $(progressColor).addClass('ui-widget-header-r');
                                  }
                                  
                              }
                              
                          }
                          
                           
                        });
                }
                
            }
            
            function showDailyView(date){
                $.getJSON('models/mod.prj.timeline.php?ACTION=GetDevelopers',
                function(jsonResult){
                    for(var i =0,d;d=jsonResult[i];i++){
                        var developerDiv = document.createElement('div');
                        developerDiv.setAttribute('id','profileDivEmpID_'+d.EmpID);
                                            
                        
                        var developerProf = profileTemplate(d);
                        $(developerProf).attr('id','DeveloperProfile');
                        $(developerDiv).append(developerProf);
                        $(developerDiv).append("<br clear='all'/>");
                        $(developerDiv).append("<br />");
                        var developerTask = document.createElement('div');
                        developerTask.setAttribute('class','DeveloperTask');
                        $(developerDiv).append(developerTask);
                        
                        $(developerDiv).css({
                              'margin':'10px',
                              'padding':'20px',
                              'border':'1px black solid',
                              'width':'760px'
                          });
                        
                        
                        $(developerDiv).appendTo("#prjTimelineView");
                        
                        $.getJSON('models/mod.prj.timeline.php',{ACTION:'GetDeveloperTasks',GETPARAM:{'EmpID':d.EmpID,'Date':date}},
                        function(jsonResult){

                           
                            for(var i=0,d;d=jsonResult[i];i++){
                                if(jsonResult[0].ReportDate==null){
                                    continue;
                                }
                                var developerTasks = dailyViewFormTemplate(d)
                                
                                $("#profileDivEmpID_"+d.EmpID).append(developerTasks);
                                
                            }
                            
                                                    
                          for(var x=0,e;e=jsonResult[x];x++){
                              var options = {};
                              options.value = parseInt(e.Percentage);
                              $("#dailyViewProgress_"+e.ProjectID+"").progressbar(options);
                              
                               var progressColor = $("#dailyViewProgress_"+e.ProjectID+"").children('div');
                               $(progressColor).removeClass('ui-widget-header');
                               
                              if(e.DateEnd!=null){
                                 //Yellow na siya
                                 $(progressColor).addClass('ui-widget-header-y');
                                 
                              }else{
                                  var dateStart = new Date(e.DateStart);
                                  var dateToday = new Date();
                                  var dateDiff = DateDiff.inDays(dateStart,dateToday);
                                  
                                  if(dateDiff<=2){
                                      //Green
                                      $(progressColor).addClass('ui-widget-header-g');
                                  }
                                  else if(dateDiff>2 && dateDiff<=5){
                                      //Blue
                                      $(progressColor).addClass('ui-widget-header-b');
                                      
                                  }else if(dateDiff>5){
                                      //Red
                                      $(progressColor).addClass('ui-widget-header-r');
                                  }
                                  
                              }
                              
                          }
                          
                           
                        });
                    }
                });               
            }
            
            function profileTemplate(d){
                return '<div style="width:610px;">'+
                            '<div id="divEmpPic_'+d.EmpID+'" style="float:left;box-shadow: 0 0 2px 0 #888;">'+
                                '<img id="imgEmpPicThumb" width="150" height="150" src="developerPIC/'+d.EmpPic+'" />'+
                            '</div>'+
                            '<div style="float: left;margin-top: 121px;margin-left: 20px;">'+
                                '<label>'+d.EmpName+'</label>'+
                            '</div>'+
                            '<br clear="all"/>'+
                        '</div>';
            }
            
            function dailyViewFormTemplate(d){
                
                return '<div style="width:750px;border:1px black solid">'+
                            '<div style="width:490px;margin:20px 0 0 10px;">'+
                                '<div id="dailyViewProgress_'+d.ProjectID+'" style="border: 1px black solid;width:420px;">'+
                                    '<span style="position:absolute;margin: 7px;white-space: nowrap;width: 400px;overflow: hidden;text-overflow: ellipsis;">'+
                                        '<span title="'+d.ProjectName+' - '+d.ProjectModuleName+'" style="cursor:hand;" onclick="showDevelopmentProgress(\''+d.EmpID+'\');">'+d.ProjectName+' - '+d.ProjectModuleName+'</span>'+
                                    '</span>'+
                                '</div>'+
                                
                            '</div>'+
                            '<div style="float:right;margin-top: -50px;">'+
                                '<div style="float:left;margin:20px">'+
                                    d.Percentage+' % '+
                                '</div>'+
                                '<div style="float:left;margin:10px">'+
                                    'Date Start'+
                                    '<br/>'+
                                    d.DateStart+
                                '</div>'+
                                '<div style="float:left;margin:10px">'+
                                    'Date End'+
                                    '<br/>'+
                                    (d.DateEnd==null? '' : d.DateEnd)+
                                '</div>'+
                            '</div>'+
                        ' <br clear="all" />'+
                        '</div>'+
                        '<br/>';
            }
            
            function showDevelopmentProgress(id){
                var developmentProgressDiv = document.createElement('div');
                developmentProgressDiv.setAttribute('id', 'developerViewProgress');
                document.body.appendChild(developmentProgressDiv);
                
                var developmentProgressDeveloper = document.createElement('div');
                developmentProgressDeveloper.setAttribute('id', 'developerViewProfile');
                developmentProgressDeveloper.setAttribute('style', 'style="width:610px;border:1px solid black;padding:20px;"');
                $(developmentProgressDeveloper).appendTo("#developerViewProgress");
                getDeveloperDetails(id,'developerViewProfile');
                
                var developmentProgressTask = document.createElement('div');
                developmentProgressTask.setAttribute('id', 'developerViewTask');
                $(developmentProgressTask).appendTo("#developerViewProgress");
                getDeveloperTasks(id, '', 0,'developerViewTask');
                
//                $("#developerViewTask > div").each(function(){
//                    $(this).css('margin','20px');
//                });
                
                $("#developerViewProgress").dialog({
                    autoOpen:true,
                    title:'Developer Development Progress',
                    width:680,
                    height:800,
                    modal:true,
                    resizable:false,
                    close:function(){
                        $(this).dialog("destroy");
                        $(this).remove();
                    }
                });
                
            }
            
            function readURL(input) {
    
                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {
           
                        var imgWidth;
                        var imgHeight;
            
                        var imgPdcStockInfoThumb = "imgPdcStockInfoThumb";
                        $("#" + imgPdcStockInfoThumb).remove();
    
                        var img = document.createElement('img');
                        img.id = imgPdcStockInfoThumb;
                        $(img).css('visibility','none');
                        img.src = e.target.result;
            
                        document.body.appendChild(img);
    
                        img.onload = function() {
                            imgWidth = img.offsetWidth;
                            imgHeight = img.offsetHeight;
                
                            createImgCanvas(img, imgWidth, imgHeight, 'canvasPdcStockInfoMain', $('#divPdcStockImageMain')); 
                            createImgCanvas(img, imgWidth, imgHeight, 'canvasPdcStockInfoThumb', $('#divPdcStockImageThumb')); 
                            showStockImageCanvasRatio();
                
                            $("#" + imgPdcStockInfoThumb).remove();
                        }
       
                    }
        
                    reader.readAsDataURL(input.files[0]);
      
                }
            }

            function showStockImageGridRatio(strStockID){
    
                var div = $('#divPdcStockImageGrid-' + strStockID);
                var img = $('#imgPdcStockImageGrid-' + strStockID);
    
                var imgStockThumbPosTop = Math.floor((div.height()- img.height() ) / 2);
                var imgStockThumbPosLeft = Math.floor((div.width()- img.width() ) / 2);
                img.css({'margin-top': imgStockThumbPosTop+'px', 'margin-left': imgStockThumbPosLeft+'px'}); 

            }

            function showStockImageCanvasRatio(){
    
                var imgStockMainPosTop = Math.floor(($('#divPdcStockImageMain').height()- $('#canvasPdcStockInfoMain').height() ) / 2);
                var imgStockMainPosLeft = Math.floor(($('#divPdcStockImageMain').width()- $('#canvasPdcStockInfoMain').width() ) / 2);
    
                $('#canvasPdcStockInfoMain').css({'margin-top': imgStockMainPosTop+'px', 'margin-left': imgStockMainPosLeft+'px'}); 
    
                var imgStockThumbPosTop = Math.floor(($('#divPdcStockImageThumb').height()- $('#canvasPdcStockInfoThumb').height() ) / 2);
                var imgStockThumbPosLeft = Math.floor(($('#divPdcStockImageThumb').width()- $('#canvasPdcStockInfoThumb').width() ) / 2);
                $('#canvasPdcStockInfoThumb').css({'margin-top': imgStockThumbPosTop+'px', 'margin-left': imgStockThumbPosLeft+'px'}); 
    
            }

            function createImgCanvas(img, imgWidth, imgHeight, canvasID, divContainer) {     
                //proportion here.
    
                width = divContainer.width();
                height = divContainer.height();
    
                if (imgWidth > imgHeight) {       
                    if (imgWidth > width) {         
                        imgHeight *= width / imgWidth;         
                        imgWidth = width;       
                    }     
                } else {       
                    if (imgHeight > height) {         
                        imgWidth *= height / imgHeight;         
                        imgHeight = height;
                    }     
                }     
                //clear first.
                $('#'+canvasID).remove();
    
                var canvas = document.createElement('canvas');     
                canvas.setAttribute('id',canvasID);     
                canvas.width = imgWidth;     
                canvas.height = imgHeight;

                var imageCanvas2D = canvas.getContext("2d");     
    
                try{         
                    imageCanvas2D.drawImage(img, 0, 0, imgWidth, imgHeight);     
                    divContainer.append(canvas);
                } catch(err) {alert(err);}     

            }
            
            
    
            
    

 