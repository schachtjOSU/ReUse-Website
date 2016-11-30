<?php
  	session_start();

	if(!(isset($_SESSION['username'])) || $_SESSION['username'] == "") {
    header( 'Location: /AdminSite2/loginPage.php' ) ;
   	}
?>
