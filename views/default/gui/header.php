<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="../../../icon/favicon.ico" />
        <link rel="stylesheet" type="text/css" href='../js/css/blitzer/jquery-ui-1.8.16.custom.css'/>
        <link rel="stylesheet" type="text/css" href='style.css'/>

        <link rel="stylesheet" type="text/css" href='../js/jquery.jqGrid-4.3.1/css/ui.jqgrid.css'/>
        <link rel="stylesheet" type="text/css" href='../js/jquery.jqGrid-4.3.1/css/ui.multiselect.css'/>


        <!-- Titles-->
        <title><?php
            $module = $this->getModuleTitle();
            if (!empty($module)) {
                ?>
                <?php $this->showProgramTitle(); ?> - <?php $this->showModuleTitle(); ?>
                <?php
            } else {
                ?>
                <?php $this->showProgramTitle(); ?>
                <?php
            }
            ?></title>

        <!-- JQuery  File-->

        <script type ="text/javascript" src ='../js/jquery-1.7.1.min.js'></script>
        <script type ="text/javascript" src ='../js/jquery.jqGrid-4.3.1/js/i18n/grid.locale-ja.js'></script>
        <script type ="text/javascript" src ='../js/jquery.jqGrid-4.3.1/js/jquery.jqGrid.min.js'></script>
        <script type ="text/javascript" src ='../js/jquery.blockUI.js'></script>
        <script type ="text/javascript" src ='../js/jquery.format-1.2.min.js'></script>
        <script type ="text/javascript" src ='../js/jquery-ui-1.8.16.custom.min.js'></script>
        <script type ="text/javascript" src ='../js/jquery-ui-timepicker-addon.js'></script>
        <script type ="text/javascript" src ='../js/jquery-ui-sliderAccess.js'></script>


        <link rel="stylesheet" href="jsgui/jquery-ui-bootstrap-masterbs3/assets/css/bootstrap.min.css"/>
        <script src="jsgui/jquery-ui-bootstrap-masterbs3/assets/js/vendor/bootstrap.js"></script>

        <!-- 
        Added By    :   Lyoniel E. Farase
        Date        :   2012-06-08
        Comment     :   Include the HighchartJS Framework
        Start #
        -->
    <!--    <script type ="text/javascript" src ='../js/highstock-1.1.5/highstock.src.js'></script>
        <script type ="text/javascript" src ='../js/highstock-1.1.5/modules/exporting.src.js'></script>-->
        <script type ="text/javascript" src ='../js/Highcharts-3.0.7/js/highcharts.src.js'></script>
        <script type ="text/javascript" src ='../js/Highcharts-3.0.7/js/modules/exporting.src.js'></script>
        <!--
        # End
        -->

        <script type ="text/javascript" src ='jsgui/common.js'></script>      
        <!--<script type ="text/javascript" src ='jsgui/useraccess.js'></script>-->


<!--<script type ="text/javascript">clickLabel();</script>-->

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
        if (isset($this->js)) {

            foreach ($this->js as $js) {
                ?>
                <script type ="text/javascript" src ="<?php echo'jsgui/' . $js; ?>"></script>
                <?php
            }
        }
        ?>



        <!-- End external JS Files-->    

        <!-- External CSS Files-->
        <?php
        if (isset($this->css)) {

            foreach ($this->css as $css) {
                ?>
                <link rel="stylesheet" type="text/css" href = "<?php echo 'css/' . $css; ?>" />            
                <?php
            }
        }
        ?>

        <!-- End external CSS Files-->    

        <!--
        Added By: Jay Ralph M. Mandanhuyan & Lyoniel Farase
        Date Added: 26-Apr-2012
        Remarks: For form tag and thumbnail image stylesheet
        -->
        <!--<style>
        .thumb{ max-width:150px ;max-height:150px;  box-shadow: 0 0 10px 0 red; } 
        </style> -->
        <!--end edit--> 

    </head>
    <body>
        <div id="wrapper">

            <div id="header">

                <div id="masthead">

                    <div id="branding">
                        <div id="companyLogo"><img src='../images/company.logo.mainf.png'/></div>
                        <div id="companyText"><?php
                            if (!empty($strModuleName)) {
                                ?>
                                <?php $this->showProgramTitle(); ?> - <?php $this->showModuleTitle(); ?>
                                <?php
                            } else {
                                ?>
                                <?php $this->showProgramTitle(); ?>
                                <?php
                            }
                            ?></div>
                        <div id="access"><?php $this->showUserAccess(); ?></div><!--#access-->
                    </div><!--#branding-->

                    <div id="navbar">
                        <div id="navbarhholder">
                            <div></div>
                            <div id="userinfo"><?php if (isset($_COOKIE['loginUserID']) && (!empty($_COOKIE['loginUserID'])) && !isset($this->loginUnset)) { ?>
                                    Welcome, <?php $this->showLoginUserID(); ?> - <?php $this->showLoginUserName(); ?> 
                                <?php } else { ?><label id="<?php echo 'header-LBL_PLEASE_LOGIN'; ?>"><?php echo $this->defaultStr(@$LBL_PLEASE_LOGIN); ?></label><?php } ?>
                                <img src="../../../models/mod.test.employee.php?ACTION=getEmployeeImage&PARAM=<?php $this->showLoginUserID(); ?> "
                                     style ="height: 46px; background-color: transparent;background-repeat: no-repeat; background-position:center;border: #e3a1a1 solid 1px;" 
                                     />

                            </div><!--#userinfo-->
                        </div><!--#navbarhholder-->
                    </div><!--#navbar-->
                </div><!--#masthead-->
            </div><!--#header-->

            <div id="main">

