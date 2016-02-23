<?php
	ini_set('display_errors', 'On');	
		
	//functions to facilitate connection to reuse database
	include ('database/reuseConnect.php');
		
	/**************************************************************************
	*				Requirements
	**************************************************************************/
	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	/**************************************************************************
	*				Routing set up
	***************************************************************************/
	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');


	/****************************************************************************
	*				Gets
	****************************************************************************/
	$app->get('/index/category/:id', function($id){
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

	$app->get('/index/states', function() {
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

$app->get('/index/business', function() {
		$mysqli = connectReuseDB();

		$result = $mysqli->query('SELECT name, id, address_line_1, address_line_2, city, state_id, zip_code, phone, website FROM Reuse_Locations');

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});


	$app->get('/index/category', function() {
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

	$app->get('/index/items', function() {
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
	$app->delete('/index/business/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Locations WHERE Reuse_Locations.id ='$delID'");
		$mysqli->close();
	});

	$app->delete('/index/item/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Items WHERE Reuse_Items.id ='$delID'");
		$mysqli->close();
	});

	$app->delete('/index/category/:id', function($id){
		$mysqli = connectReuseDB();

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Categories WHERE Reuse_Categories.id ='$delID'");
		$mysqli->close();
	});



/******************************************************************************************
*				PUTS
******************************************************************************************/
	$app->put('/index/category/:id', function($id){
		$mysqli = connectReuseDB();

		//$inID = $mysqli->real_escape_string($id);
		$inID = $id;
		$mysqli->query("INSERT INTO Reuse_Categories WHERE Reuse_Locations.id ='$inID'");
		$mysqli->close();
	});

/*****************************************************************************************
*			POSTS
******************************************************************************************/
$app->post('/index/business', function(){
		
		$name = $_POST['name'];
		if ($_POST['address']){
			$address = $_POST['address'];
		}
		else {
			$address = null;
		}
		if ($_POST['address2']){
			$address2 = $_POST['address2'];
		}
		else {
			$address2 = null;
		}
		if ($_POST['city']){
			$city = $_POST['city'];
		}
		else{
			$city = null;
		}
		if ($_POST['state']){
			$state = $_POST['state'];
		}
		else{
			$state = null;
		}
		if ($_POST['zipcode']){
			$zipcode = $_POST['zipcode'];
		}
		else{
			$zipcode = null;
		}
		if ($_POST['phone']){
			$phone = $_POST['phone'];
		}
		else {
			$phone = null;
		}
		if ($_POST['website']){
			$website = $_POST['website'];
		}
		else {
			$website = null;
		}

	$mysqli = connectReuseDB();


		/* prepare the statement*/
		if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_Locations (name, address_line_1, address_line_2, city, state_id, zip_code, phone, website) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))){
			echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/* bind the variables */
		if(!$stmt->bind_param('ssssiiss', $name, $address, $address2, $city, $state, $zipcode, $phone, $website)){
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

$app->post('/index/category', function(){
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

$app->post('/index/items', function(){

		$name = $_POST['name'];
		$category = $_POST['category'];

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
		if(!$stmt->bind_param('si', $name, $category)){
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

	$app->run();	
?>
