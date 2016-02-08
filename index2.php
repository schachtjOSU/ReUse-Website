<?php
	/**********************************************************************
	*					 error check
	**********************************************************************/

	/* error check */
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	/* start session */
	ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
    session_start();


	/************************************************************************
	*			POSTS, Non-Framework, function routing
	************************************************************************/
	if( isset($_POST['type']) ){
		$type = $_POST['type'];

		// POST login
		if ($type == "login"){
			login();
			return;
		}

		// POST add new business
		if ($type == "add"){
			add();
			return;
		}

		// POST add new category
		if($type == "addCat"){
			addCat();
			return;
		}

		// POST add new Item
		if($type == "addItem"){
			addItem();
			return;
		}
		// POST create new user
		if ($type == "register"){
			register();
			return;
		}

		// POST kill session
		if ($type == "killSession"){
			killSession();
			return;
		}
	} 

	/***********************************************************************
	*				POST: Add to the table
	***********************************************************************/
	function add(){
		/* create my variables. Must to made NULL for simple insertion where
		allowable, if blank */
		$user = $_SESSION['username'];
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

	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
	if($mysqli->connect_errno){
		echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
	}


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
	}

	/*********************************************************************
	*				POST: Add Category
	************************************************************************/
	function addCat(){
		$user = $_SESSION['username'];
		$name = $_POST['name'];

		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}


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
	}

	/*********************************************************************
	*				POST: Add Item
	************************************************************************/
	function addItem(){
		$user = $_SESSION['username'];
		$name = $_POST['name'];
		$category = $_POST['category'];

		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}


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
	}

	/***********************************************************************
	*				POST: Login
	***********************************************************************/
	function login(){
		/* variables */
		$username = $_POST['username'];
		$username = strtoupper($username);
		$password = $_POST['password'];

		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}
	    /* check for someone elses session prior to starting page */
	    if(isset($_SESSION['username']) && $_SESSION['username'] != $username){
	    	if($_SESSION['loggedIn'] != false){
	   			echo "Another user is already logged in. Please click ";
	   			echo "<a href='logout.php'>here</a> to log out.";
	   		}
	   	}

	   	else{
			/************************************************************************
			* 					Search for users name and password
			************************************************************************/

			/* Select user input for search */
			$result = "SELECT login FROM Reuse_User_Credentials WHERE login='$username' && pw_hash='$password'";
			$product = $mysqli->query($result);
			$numReturned = $product->num_rows;

			/* if no results, there's no record of that username/password match */
			if($numReturned == 0){
				echo 0;				// false back to javascript
			}

			/* there is a match, so log them in an create a session */
			else{
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				$_SESSION['loggedIn'] = true;
				echo 1;				// true back to javascript
			}

			/* close it up */
			$mysqli->close();
		}
	}

	/******************************************************************************
	*				POST create new user
	******************************************************************************/
	function register(){
		$usernameDB = $_POST['username'];
		$usernameDB = strtoupper($usernameDB);
		$passwordDB = $_POST['password'];
		$userArray = [];
		$newUser = true;

		$_SESSION['username'] = $usernameDB;
		$_SESSION['password'] = $passwordDB;
		$_SESSION['loggedIn'] = true;

		$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
		if($mysqli->connect_errno){
			echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
		}

		/************************************************************************************
		*					Search for duplicate usernames
		************************************************************************************/

		/* prepare statement */
		if(!($stmt = $mysqli->prepare('SELECT login FROM Reuse_User_Credentials'))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}

		/* execute */
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}

		/* bind results to a temp array of user names */
		if(!$stmt->bind_result($tempArray)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}

		/* while there's ueser names, fill the array */
		while($stmt->fetch()){
			array_push($userArray, $tempArray);
		}

		/* check each username to see if a new one will create a duplicate */
		foreach($userArray as $i){
			if($usernameDB === $i){
				$newUser = false;
				echo 0;
				break;
			}
		}

			
		/*******************************************************************************
		*					create new database user
		*******************************************************************************/
			
		/* name not taken  */
		if($newUser === true){

			/* prepare the statement*/
			if (!($stmt = $mysqli->prepare("INSERT INTO Reuse_User_Credentials (login, pw_hash) VALUES (?, ?)"))){
				echo "Prepare failed : (".$mysqli->connect_errno.")".$mysqli->connect_error;
			}

			/* bind to the variables for testing */
			if(!$stmt->bind_param('ss', $usernameDB, $passwordDB)){
	 			echo "Binding failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
	 		}

			/* execute */
			if(!$stmt->execute()){
				echo "Execute failed. (".$mysqli->connect_errno.")".$mysqli->connect_error;
			}

			echo 1;			// return false to javascript for notification

			/* close this request */
			$stmt->close();
			$mysqli->close();

		}		
	}

	/**************************************************************************
	*					POST Kill session
	***************************************************************************/
	function killSession(){
		session_unset();
		session_destroy();
		//header('Location: loginPage.php');
		echo 1;
	}



	$app->run();
?>
