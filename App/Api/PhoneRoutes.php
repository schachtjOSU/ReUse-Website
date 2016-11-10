<?php
//Routes that the phone application will interface with

 /**
   *GET request prints out an XML tree of the contents of DB.
   * api
   * return void
   *                            
   */

	$app->get('/reuseDB', function() {
    
        global $app;
		
		//printing an xml file, set headers accordingly
		$app->response->headers->set('content-type', 'application/xml');
	
		//echo out the xml file
		echoxmlfile();		
    });


?>
