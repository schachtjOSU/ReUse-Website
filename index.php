<?php

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

	$app->get('/index/states', function() {
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

$app->get('/index/business', function() {
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

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
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

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
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

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
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Locations WHERE Reuse_Locations.id ='$delID'");
		$mysqli->close();
	});

	$app->delete('/index/item/:id', function($id){
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Items WHERE Reuse_Items.id ='$delID'");
		$mysqli->close();
	});

	$app->delete('/index/category/:id', function($id){
		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		$delID = $mysqli->real_escape_string($id);
		$mysqli->query("DELETE FROM Reuse_Categories WHERE Reuse_Categories.id ='$delID'");
		$mysqli->close();
	});

	$app->run();

?>
