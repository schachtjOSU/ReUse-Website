<?php
//Routes that the phone application will interface with

	/**
  	 * @api {get} /reuseDB
     * @apiName ReUseApp
     *
	 * @apiSuccess {XML} An XML tree of the contents of DB, with a list of businesses and data relevant to the businesses, including contact information and items they accept.
	 */  
	$app->get('/reuseDB', function() {
    
        global $app;
		
		//printing an xml file, set headers accordingly
		$app->response->headers->set('content-type', 'application/xml');
	
		//echo out the xml file
		echoxmlfile();		
    });

	/**
  	 * @api {get} /recycleXML
     * @apiName ReUseApp
     *
	 * @apiSuccess {XML} An XML tree with a list of recycling centers and data relevant to the businesses, including contact information, items they accept, and a list of links associated with the recycling center.
	 */  
	$app->get('/recycleXML', function() {
    
        global $app;
		
		//printing an xml file, set headers accordingly
		$app->response->headers->set('content-type', 'application/xml');
	
		//echo out the xml file
		echoRecycleXML();		
    });
	
	/**
  	 * @api {get} /reuseDB
     * @apiName ReUseApp
     *
	 * @apiSuccess {XML} An XML tree of the donors/sponsors, with their name, description, and website.
	 */  
	$app->get('/donorXML', function() {
    
        global $app;
		
		//printing an xml file, set headers accordingly
		$app->response->headers->set('content-type', 'application/xml');
	
		//echo out the xml file
		echoDonorXML();		
    });

?>
