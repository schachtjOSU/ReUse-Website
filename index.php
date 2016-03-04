<?php
	
	//For DEBUGGING	
	ini_set('display_errors', 'On');	
		

		
	/**************************************************************************
	*				Requirements
	**************************************************************************/
	
	//Framework
	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	//functions to facilitate connection to reuse database
		// - connectReuseDB()		<-- Create mysqli object using reuse db creds
	require 'database/reuseConnect.php';

	//functions facilitating XML file generation for mobile
		// - reuse_generateXML()	<-- Produces XML file
		// - echoXMLFile()		<-- Echos file after generation
	require 'xmlGenerator/xmlGenerator.php';
	
	//functions facilitating Bing Geocoder
	require 'BingGeocoder/geocoder.php';

	/**************************************************************************
	*				Routing set up
	***************************************************************************/
	$app = new \Slim\Slim(
		//More debugging
		array( 'debug' => true )
	);
	$app->response->headers->set('Content-Type', 'application/json');


// API group
 $app->group('/index', function () use ($app) {

	/****************************************************************************
	*				Gets
	****************************************************************************/

	//The entire database, in XML form
	$app->get('/reuseDB', function() {
		global $app;
		
		//Printing an XML file, set headers accordingly
		$app->response->headers->set('Content-Type', 'application/xml');
	
		//Echo out the XML file
		echoXMLFile();		
	});	
	
	$app->get('/category/:id', function($id){
		$mysqli = connectReuseDB();

		$id = (int)$mysqli->real_escape_string($id);
		$result = $mysqli->query('SELECT name, id FROM Reuse_Categories WHERE Reuse_Categories.id = '.$id.'');
	    
		
		
		
	    $returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	$app->get('/states', function() {
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		$result = $mysqli->query('SELECT name, id FROM States');
		$returnArray = array();

	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);
	    $result->close();
	    $mysqli->close();
	});		

	$app->get('/business', function() {
		$mysqli = connectReuseDB();

		$result = $mysqli->query('SELECT name, id FROM Reuse_Locations');

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});


	$app->get('/category', function() {
		$mysqli = connectReuseDB();

		$result = $mysqli->query('SELECT name, id FROM Reuse_Categories');
	    
	    $returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	$app->get('/items/:id', function($id){
		$mysqli = connectReuseDB();

		$id = (int)$mysqli->real_escape_string($id);
		$result = $mysqli->query('SELECT name, id, category_id FROM Reuse_Items WHERE Reuse_Items.id = '.$id.'');


		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});


	$app->get('/business/:one', function($one){
		$mysqli = connectReuseDB();

		//$id = (int)$mysqli->real_escape_string($id);
		$result = $mysqli->query("SELECT name, id, address_line_1, address_line_2, state_id, phone, website, city, zip_code FROM Reuse_Locations WHERE Reuse_Locations.name = '$one'");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	$app->get('/items', function() {
		$mysqli = connectReuseDB();

		$result = $mysqli->query('SELECT name, id, category_id FROM Reuse_Items');

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

/************************************************************************************
*					DELETES
*************************************************************************************/
	//Remove Specific Business	
	$app->delete('/business/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Locations WHERE Reuse_Locations.id ='$delID'");
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
	});
	
	//Remove Specific Item
	$app->delete('/item/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Items WHERE Reuse_Items.id ='$delID'");
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
	});
	
	//Remove Specific Business
	$app->delete('/category/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Categories WHERE Reuse_Categories.id ='$delID'");
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
	});



/******************************************************************************************
*				PUTS -- doing it as POSTS with UPDATES to avoid form issues
******************************************************************************************/
	
	/* Update a specific category name */	
	$app->post('/changeCategory', function(){

		$oldName = $_POST['oldName'];
		$name = $_POST['name'];

		$mysqli = connectReuseDB();

		if($oldName != 'undefined' && $name != 'undefined'){
			$mysqli->query("UPDATE Reuse_Categories SET name = '$name' WHERE name = '$oldName'");
		}
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
	});

	/* update item */
	$app->post('/changeItem', function(){

			$oldName = $_POST['oldName'];
			$name = $_POST['name'];
			$cat = $_POST['cat'];

		$mysqli = connectReuseDB();

		if($name != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Items SET name = '$name' WHERE name = '$oldName'");			
		}
		if($cat != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Items SET category_id = '$cat' WHERE name = '$oldName'");
		}
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
	});


/*****************************************************************************************
*			POSTS
******************************************************************************************/
/* Adding a New Business to the Directory */
$app->post('/business', function(){
		
		$name = $_POST['name'];
		if (isset($_POST['address']) && !empty($_POST['address'])){
			$address = $_POST['address'];
		}
		else {
			$address = null;
		}
		if (isset($_POST['address2']) && !empty($_POST['address2'])){
			$address2 = $_POST['address2'];
		}
		else {
			$address2 = null;
		}
		if (isset($_POST['city']) && !empty($_POST['city'])){
			$city = $_POST['city'];
		}
		else{
			$city = null;
		}
		if (isset($_POST['state']) && !empty($_POST['state'])){
			$stateId = $_POST['state'];
		}
		else{
			$stateId = null;
		}
		if (isset($_POST['zipcode']) && !empty($_POST['zipcode'])){
			$zipcode = $_POST['zipcode'];
		}
		else{
			$zipcode = null;
		}
		if (isset($_POST['phone']) && !empty($_POST['phone'])){
			$phone = $_POST['phone'];
		}
		else {
			$phone = null;
		}
		if (isset($_POST['website']) && !empty($_POST['website'])){
			$website = $_POST['website'];
		}
		else {
			$website = null;
		}

		
		/* Convert state_id to the string it references */
		$mysqli = connectReuseDB();
		if (!($stmt = $mysqli->prepare("SELECT abbreviation FROM  `States` WHERE id = ?"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}
		
		$stmt->bind_param('i', $stateId);
		$stmt->bind_result($state);
		$stmt->execute();
		$stmt->fetch();
		
		$stmt->close();
		$mysqli->close();
		
		
		/* Geocode address for storage */
		$latlong = bingGeocode($address, $city, $state, $zipcode);

		if ($latlong == false) {
			$latitude = null;
			$longitude = null;
		} else {
			$latitude = $latlong['lat'];
			$longitude = $latlong['long'];
		}
		
		
		$mysqli = connectReuseDB();
		

		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_Locations (name, address_line_1, address_line_2, city, state_id, zip_code, phone, website, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind the variables */
		if(!$stmt->bind_param('ssssiissdd', $name, $address, $address2, $city, $stateId, $zipcode, $phone, $website, $latitude, $longitude)){
	 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 	}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* updated */
		echo 1;
		$stmt->close();
		$mysqli->close();

		/* Update Mobile Database */
		reuse_generateXML();
});

/* Adding a New Category */
$app->post('/category', function(){
		$name = $_POST['name'];

		$mysqli = connectReuseDB();


		/* Check to  make sure it's not a duplicate */
		$result = $mysqli->query('SELECT name, id FROM Reuse_Categories');
            while($row = $result->fetch_object()){
                if($row->name == $name){
					$mysqli->close();
				}
			}


		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_Categories (name) VALUES (?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind the variables */
		if(!$stmt->bind_param('s', $name)){
	 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 	}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* updated */
		echo 1;
		$stmt->close();
		$mysqli->close();
});

$app->post('/updateItems', function(){
		$category = $_POST['category'];
		$name = $_POST['name'];

		$mysqli = connectReuseDB();

		if($category != 'undefined' && $name != 'undefined'){
			$mysqli->query("UPDATE Reuse_Items SET category_id = '$category' WHERE Reuse_Items.name = '$name'");
		}
		$mysqli->close();
});

/* many to many connection for business and items */
$app->post('/updateBusiness', function(){
		$item = $_POST['items'];
		$name = $_POST['name'];

		$mysqli = connectReuseDB();

		/* get location id based off name */
		$result = $mysqli->query("SELECT name, id FROM Reuse_Locations");
        while($row = $result->fetch_object()){
            if($row->name == $name){
				$match = $row->id;
			}
		}		
		$mysqli->close();

		// add to joining table
		$mysqli = connectReuseDB();
		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_Locations_Items (item_id, location_id) VALUES (?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind the variables */
		if(!$stmt->bind_param('ii', $item, $match)){
	 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 	}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/*then update the joining table with the id of the location and the id of the items it accepts */
		//$mysqli->query("UPDATE Reuse_Locations_Items SET item_id = '$item' WHERE Reuse_Locations_Items.location_id = '$match'");
		$mysqli->close();
});

/* Adding a New Item */
$app->post('/items', function(){

		$name = $_POST['name'];
		$cat = $_POST['cat'];

		$mysqli = connectReuseDB();

		/* Check to  make sure it's not a duplicate */
		$result = $mysqli->query('SELECT name, id FROM Reuse_Items');
            while($row = $result->fetch_object()){
                if($row->name == $name){
					$mysqli->close();
				}
			}
			

		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_Items (name, category_id) VALUES (?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind the variables */
		if(!$stmt->bind_param('si', $name, $cat)){
	 		echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 	}

		/* execute */
		if(!$stmt->execute()){
			echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* updated */
		echo 1;
		$stmt->close();
		$mysqli->close();
});
 });
	$app->run();	
?>
