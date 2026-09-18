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
