<ul class="menu">
   <li><a id="support" href="cont.support.request"><label id="<?php echo 'useraccess-LBL_SUPPORT'; ?>"> <?php echo $this->defaultStr(@$LBL_SUPPORT);?></label></a></li>
   <li><a id="settings" href="#"><label id="<?php echo 'useraccess-LBL_SETTINGS'; ?>"><?php echo $this->defaultStr(@$LBL_SETTINGS);?></label></a></li><?php
   if(isset($_COOKIE['loginUserID'])&&(!empty($_COOKIE['loginUserID']))){
   ?>
   <li onclick ="doUserAccessLogout(event)"><a id="logout"><label id="<?php echo 'useraccess-LBL_LOG_OUT'; ?>"><?php echo  $this->defaultStr(@$LBL_LOG_OUT);?></label></a></li><?php
   }
   ?>
</ul><!--#menu-->