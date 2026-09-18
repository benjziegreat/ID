


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//End slide menu
//======================================================================================================================================================================

//Start of Message Dialog
//Created by: Ayant P. Orcasitas
//Date Created: June 9, 2012
//
//Parameters:
//msg -> Message to be display. Simple string and html data is accepted
//title -> String title that shall be displayed in dialog title
//icon -> select in any of the following:ask, error, info, failed, success, locked, unlocked, warning, stop and reminder. however, you can add more icons by putting them in /images/icon/
//buttons -> the caption of buttons separated by "|". 
//  First text refers to first button and the other is for the second button. if empty, blank or null the button caption shall be default caption  "Ok".
//  If the user set only a caption for first button, then the second buttong shall not be displayed
//
//mbWidth -> width of message box window  
//mbHeight -> height of message box window 
//callBackFunction(buttonNumber) -> call back function 
//
//Sample implementation: <input type="button" onclick="msgBox('Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'Msg Box Test', 'reminder', 'Yes|hello',500,400,function(num){alert(num);})" value="Msg Box"/>
//
//======================================================================================================================================================================

function msgBox(msg, title,icon,buttons,mbWidth,mbHeight,callBackFunction){
   
    var retVal=0; 
     
    arrButtons=buttons.split("|");
    var btn1="Ok";
    var btn2="";
    
    if (icon=='' || icon==null){
        icon="success";
    }
    
    if(mbWidth==null || mbWidth<400){
        mbWidth=450;
    }    
    if(mbHeight==null || mbHeight<200){
        mbHeight=210;
    }
       
    if(buttons=='' || buttons==null){        
        btn1="Ok";
    } else{
        btn1=arrButtons[0];
    }    
    if(arrButtons.length>1){        
        btn2=arrButtons[1];
    }
    
    $("#___msgContainer").remove();
    $("#___msgBox").remove();
        
    var objBox = document.createElement("div");
    objBox.id = "___msgBox";
    
    document.body.appendChild(objBox);
    
    var objBoxCon = document.createElement("div");
    objBoxCon.id = "___msgContainer";    
    
    var objBoxIcon = document.createElement("img");
    objBoxIcon.id = "___msgIcon";   
    
    var objBoxMsg = document.createElement("span");
    objBoxMsg.id = "___msgText";   

    $("#___msgBox").append(objBoxCon);
    $("#___msgContainer").append(objBoxIcon);
    $("#___msgContainer").append(objBoxMsg);    

    $("#___msgIcon").attr("src", "../images/icon/"+icon+".png");
    $("#___msgIcon").attr("align", "left");
    $("#___msgIcon").css("margin", "15px");
    
    $("#___msgText").css("padding", "5px");
    $("#___msgText").css("font-size", "14px");
    $("#___msgText").html(msg);
    
    if (title == 'Void') {
        
        var reasonDiv = document.createElement("div");
        $(reasonDiv).insertAfter($("#___msgContainer"));
        
        var reasonLabel = document.createElement("label");
        $(reasonLabel).text("If Yes, why?");
        $(reasonDiv).append($(reasonLabel));
        
        var reasonTextBox = document.createElement("input");
        $(reasonTextBox).attr({
            "id" : "txtReasonMessage",
            "type" : "textbox",
            "style" : "width: 67%;"
        });
        $(reasonTextBox).insertAfter($(reasonLabel));
    }
    
    $(document).ready(function() {        
        if(btn2==''){
            $("#___msgBox").dialog({
                title: title,
                width:mbWidth,
                height:mbHeight,
                modal:true,

                close: function(event, ui) {
                    $(this).dialog("destroy");
                },
                buttons:[{
                    id:'btn1',
                    text:btn1,
                    click:function(){
                        retVal=1;
                        $(this).dialog('close');
                        $(this).dialog("destroy");
                        callBackFunction(1);
                    }			
                },						
                ]
            });	            
        }else{            
            $("#___msgBox").dialog({
                title: title,
                width:mbWidth,
                height:mbHeight,
                modal:true,

                close: function(event, ui) {
                    $(this).dialog("destroy");
                },
                buttons:[{
                    id:'btn1',
                    text:btn1,
                    click:function(){
                        retVal=1;
                        
                        if ($(reasonTextBox).val() == "") {
                            alert("Please put a reason if you click Yes.");
                            $(reasonTextBox).css({
                                "border-style":"solid",
                                "border-width":"1px",
                                "border-color":"red"
                            });
                        }else{
                            $(this).dialog('close');
                            $(this).dialog("destroy");
                            callBackFunction(1);
                        }

                    }			
                },	
                {
                    id:'btn2',
                    text:btn2,
                    click:function(){
                        retVal=2;
                        $(this).dialog('close');
                        $(this).dialog("destroy");
                        callBackFunction(2);
                    }
                },                        
                ]
            });	            
        }
            
        return false;			        		
    });    
       
    return retVal;
}


//End of Message Dialog
//======================================================================================================================================================================
