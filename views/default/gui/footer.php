   </div><!--#main-->
   
   <div id="footer201">

	  <?php
	  list($GLOBALS['strModuleInfoMVC'],$GLOBALS['strModuleInfoSystemgroup'],$GLOBALS['strModuleInfoModuleName']) = explode('.',$GLOBALS['strModuleName']);
	  
	  if($GLOBALS['strModuleInfoMVC']!='main' && $_GET['showtapmenu']!='no'){
	  ?>
      <div id="colophon">
        <div id="colophon-header">
          <div id="up-hide-button" onclick="showHideAllMenu(25)">&#187;</div>
        </div><!--#colophon-header-->
        <div id="colophon-body">
          <div id="module-menu-holder"><?php $this->showTapMenu();?></div>
        </div><!--#colophon-body-->
      </div><!--#colophon-->
      <?php
	  }
	  ?>
   </div><!--#footer-->
</div><!--#wrapper-->
</body>
</html>