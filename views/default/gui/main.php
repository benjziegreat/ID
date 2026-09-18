<?php
  // Use an autoloader!
    error_reporting(E_ALL ^ E_WARNING);
    include_once '../../../libs/include.view.php';
    
    $strModuleName  = 'main.login';

    $view = new View('Main');
    $view->loadHeader();
    
    $loginlang = $view->getModuleLanguageVariables($strModuleName);
?>

<style>
#module-main-icons{
	/*white-space:nowrap;*/
	text-align:center;
	padding-top: 1em;
}

#module-main-icons .ico{
	display: inline-block;
	padding-bottom: 2em;
}
</style>


<script>

</script>

      <div id="container">
         <!--<?=uniqid('',true);?>-->
         <div id="content">
            <div id="module-main-icons">
			  <div class="ico"  onclick ="window.open('view.jhrms.naviframe.php','JHRMS')"  ontap ="document.window.open('view.jhrms.naviframe.php','JHRMS')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_MAINJHRMS'; ?>"><?php echo $loginlang['LBL_MAINJHRMS']; ?></label>
				  </div>
				  <div><img src="../images/jhrms.png">
				  </div>
			  </div>
			  <div class="ico"  onclick ="window.open('view.pdc.naviframe.php','PDC')"  ontap ="document.window.open('view.pdc.mststocklist.php','PDC')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_MAINPDC'; ?>"><?php echo $loginlang['LBL_MAINPDC']; ?></label>
				  </div>
				  <div><img src="../images/pdcicon.png">
				  </div>
			  </div>
			  <div class="ico"  onclick ="window.open('view.production.blank.php','Production')"  ontap ="document.window.open('view.production.blank.php','Production')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_MAINPRODUCTION'; ?>"><?php echo $loginlang['LBL_MAINPRODUCTION']; ?></label>
				  </div>
				  <div><img src="../images/production-icon.png">
				  </div>
			  </div>
			  
<!--			  <div class="ico"  onclick ="window.open('view.ntcwarehouse.naviframe.php','NTCWarehouse')"  ontap ="document.window.open('view.ntcwarehouse.naviframe.php','NTCWarehouse')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_NTCWAREHOUSE'; ?>"><?php echo $loginlang['LBL_NTCWAREHOUSE']; ?></label>
				  </div>
				  <div><img src="../images/ntcwarehouse/NTC Warehouse.png"></div>
			  </div>-->
			  
			  <div class="ico"  onclick ="window.open('view.dm.naviframe.php','DocumentMonitoring')"  ontap ="document.window.open('view.dm.naviframe.php','DocumentMonitoring')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_DOCMONITORING'; ?>"><?php echo $loginlang['LBL_DOCMONITORING']; ?></label>
				  </div>
				  <div><img src="../images/icon_DocMonitoring.png"></div>
			  </div>
                
                          <div class="ico"  onclick ="window.open('view.grb.naviframe.php','GuestRoomBooking')"  ontap ="document.window.open('view.grb.naviframe.php','GuestRoomBooking')">
				  <div>
					  <label id="<?php echo $strModuleName.'-LBL_GUESTROOMBOOKING'; ?>"><?php echo $loginlang['LBL_GUESTROOMBOOKING']; ?></label>
				  </div>
				  <div><img src="../images/icon_DocMonitoring.png"></div>
			  </div>
            </div>
         </div>
      </div><!--#container-->
<?php  $view->loadFooter();?>