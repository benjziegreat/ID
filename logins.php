

<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href='js/css/blitzer/jquery-ui-1.8.16.custom.css'/>
        <script type ="text/javascript" src ='js/jquery-1.7.1.min.js'></script>
        <script type ="text/javascript" src ='js/jquery-ui-1.8.16.custom.min.js'></script>
        <script type ="text/javascript" src ='js/common.js'></script>

        <style>
            .ui-dialog-titlebar-close{
                display:none;
            }

            .thumb {
                height: 75px;
                border: 1px solid #000;
                margin: 10px 5px 0 0;
            }
        </style> 

        <script>
            
            loadQuery222();
            loadQuery6();
            $(document).ready(function(){
                
                
                $("#loginFormDiv").dialog({
                    autoOpen:true,
                    modal:true,
                    width:450,
                    height:'auto',
                    resizable:false,
                    draggable:false,
                    closeOnEscape: false,
                    title:'Memcache Test',
                    buttons:
					{
                        'Login':function(){

                                    if (event.ctrlKey) return;
                                    if ($("#username").val() == ""){
                                            $("#username").addClass("required-field");
                                            alert('Username is required')
                                    }
                                    else{
                                            $("#username").removeClass("required-field");
                                    }
                                    if ($("#password").val() == ""){
                                            $("#password").addClass("required-field");
                                            alert('Password is required')
                                    }
                                    else{
                                            $("#password").removeClass("required-field");
                                    }
                                    $.getJSON("models/mod.logins.php",
                                    ({
                                            ACTION: 'login',
                                            GETPARAM: ({
                                                    username:$("#username").val(),
                                                    password:$("#password").val()    
                                            })
                                    }),
                                    function(data){
                                            if (data.length > 0){
                                            console.log(data);
                                            document.location.replace('mains.php');

                                            }else{
                                            console.log(data);
                                            document.location.replace('logins.php');
                                            }
                                    },'json'
                            );
							
							// document.location.replace('main.php');
							
                        }
						// ,
                        // 'Create':function(){
                            // $("#regFormDiv").dialog('open');
                        // }                        
                    }
                    

                });
                

            
            });
			
            function closeDialog(id){
                $("#"+id+"").dialog("close");
            }
            
            function loadQuery222(){
                $.ajax({
                    url: "models/mod.logins.php?ACTION=loadQuery222",
                    type: "POST",
                    dataType: "json"
                    
                });
            }
            
            function loadQuery6(){
                $.ajax({
                    url: "models/mod.logins.php?ACTION=loadQuery6",
                    type: "POST",
                    dataType: "json"
                    
                });
            }
            



        </script>

    </head>    


    <body>


        <div id="loginFormDiv" style="margin-top:20px">
            <form id="loginFomr">
                <div style="height:30px;">                    
                    <label>Username</label>
                    <div style="float:right;">
                        : <input name="username" id="username" type="text"/>
                    </div>

                </div> 
                <br clear="all"/>
                <div style="height:30px;">                    
                    <label>Password</label>
                    <div style="float:right;">
                        : <input name="password" id="password" type="password" />
                    </div>
                </div>
            </form>
        </div>




    </form>
</div>

</body>
</html>
