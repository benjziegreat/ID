<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo isset($this->title) ? $this->title : "Warehouse"; ?></title>
    <link rel="shortcut icon" href="../../../icon/favicon.ico" />
    <link rel="stylesheet" type="text/css" href='../js/css/blitzer/jquery-ui-1.8.16.custom.css'/>
    <link rel="stylesheet" type="text/css" href='style.css'/>
    
    <link rel="stylesheet" type="text/css" href='../js/jquery.jqGrid-4.3.1/css/ui.jqgrid.css'/>
    <link rel="stylesheet" type="text/css" href='../js/jquery.jqGrid-4.3.1/css/ui.multiselect.css'/>
    <!-- JQuery  File-->
    
    <script type ="text/javascript" src ='../js/jquery-1.7.1.min.js'></script>
    <script type ="text/javascript" src ='../js/jquery.jqGrid-4.5.2/js/i18n/grid.locale-en.js'></script>
    <script type ="text/javascript" src ='../js/jquery.jqGrid-4.5.2/js/jquery.jqGrid.src.js'></script>
    <script type ="text/javascript" src ='../js/jquery.blockUI.js'></script>
    <script type ="text/javascript" src ='../js/jquery.format-1.2.min.js'></script>
    <script type ="text/javascript" src ='../js/jquery-ui-1.8.16.custom.min.js'></script>
    <script type ="text/javascript" src ='../js/jquery-ui-timepicker-addon.js'></script>
    <script type ="text/javascript" src ='../js/jquery-ui-sliderAccess.js'></script>        
    <script type ="text/javascript" src ='../js/highstock-1.1.5/highstock.js'></script>
    <script type ="text/javascript" src ='../js/highstock-1.1.5/modules/exporting.src.js'></script>    
    <script type ="text/javascript" src ='jsgui/common.js'></script>

    
   
<!--    <script type ="text/javascript">clickLabel();</script>-->
    

    <script type = "text/javascript">
        
        clickLabel();
        
        function flashEvent(e) { 
            
            clickLabel();
            //routeEvent(e)
        }
        
        window.captureEvents(Event.CLICK);
        window.onclick = flashEvent;
        
        
    </script>
   
    <!-- External JS Files-->
    <?php 
        if (isset($this->js)){
            
            foreach($this->js as $js){?>
                <script type ="text/javascript" src ="<?php echo'jsgui/'. $js ;?>"></script>
            <?php    
            }
        }
    ?>
    

    
    <!-- End external JS Files-->    
    
    <!-- External CSS Files-->
    <?php 
        if (isset($this->css)){
            
            foreach($this->css as $css){?>
                <link rel="stylesheet" type="text/css" href = "<?php echo 'css/'. $css ;?>" />            
            <?php    
            }
        }
    ?>
                
    <!-- End external CSS Files-->    
   
</head>
<body>
