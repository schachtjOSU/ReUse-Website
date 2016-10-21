<?php
//Routes used by the admin portal to change or view the database.

$app->response->headers->set('Content-Type', 'application/json');
// API group
 	$app->group('/RUapi', function () use ($app) {

	/****************************************************************************
	*				Gets
	****************************************************************************/
     



     /**
      * GET request will display the category 
      * corresponding to the ID presented.
      * @api
      *
      * @return string JSON
      */
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

     /**
      * GET request will display all 
      * states and their unique ID's from the database.
      * @api
      *
      * @return string JSON
      */
	$app->get('/states', function() {
		$mysqli = connectReuseDB();

		$result = $mysqli->query('SELECT name, id FROM States');
		$returnArray = array();

	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);
	    $result->close();
	    $mysqli->close();
	});		

     /**
      * GET response that provides a listing of all 
      * categories available in the 
      * database and the corresponding ID.
      * @api
      * @return void
      */
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


     /**
      * GET response that provides a listing of all 
      * categories available in the 
      * database and the corresponding ID.
      * @api
      * @return string JSON
      */
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

     /**
      * GET request that provides the
      * name of an item given the ID
      * @api
      * @return string JSON
      */
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


     /**
      * This method will not change until a major release.
      * GET request that given the name of the business will 
      * provide info on said business 
      *
      * @return string JSON
      */
	$app->get('/business/:one', function($one){
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT name, id, address_line_1, address_line_2, state_id, phone, website, city, zip_code FROM Reuse_Locations WHERE Reuse_Locations.name = '$one'");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

     /**
      * This method will not change until a major release.
      * GET request that provides a list of all items currently in the database
      * and their corresponding category 
      * @api
      *
      * @return string JSON
      */
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
		echo json_encode("IN RIGHT FUNCTION");
		$delID = $mysqli->real_escape_string($id);	

		$mysqli->query("DELETE FROM Reuse_Locations_Items WHERE location_id = '$delID'");
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

	$app->delete('/updateBusiness/:one/:id', function($one, $id){
		
		$mysqli = connectReuseDB();

		/* get location id based off name */
		$result = $mysqli->query("SELECT name, id FROM Reuse_Locations");
        while($row = $result->fetch_object()){
            if($row->name == $one){
				$match = $row->id;
			}
		}		
		$match2 = $mysqli->real_escape_string($id);		

		$mysqli->query("DELETE FROM Reuse_Locations_Items WHERE location_id = '$match' AND item_id = '$match2'");
		$mysqli->close();
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

		/* update item */
	$app->post('/changeBusiness', function(){

		$oldName = $_POST['oldName'];
		$name = $_POST['name'];
		$state = $_POST['state'];
		$address = $_POST['add1'];
		$address2 = $_POST['add2'];
		$zipcode = $_POST['zip'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$website = $_POST['website'];

		$mysqli = connectReuseDB();
		if($state != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET state_id = '$state' WHERE name = '$oldName'");
		}
		if($address != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET address_line_1 = '$address' WHERE name = '$oldName'");
		}
		if($address2 != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET address_line_2 = '$address2' WHERE name = '$oldName'");
		}
		if($phone != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET phone = '$phone' WHERE name = '$oldName'");
		}
		if($zipcode != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET zip_code = '$zipcode' WHERE name = '$oldName'");
		}
		if($city != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET city = '$city' WHERE name = '$oldName'");
		}
		if($website != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET website = '$website' WHERE name = '$oldName'");
		}
		if($name != 'undefined' && $oldName != 'undefined'){
			$mysqli->query("UPDATE Reuse_Locations SET name = '$name' WHERE name = '$oldName'");			
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
?>
