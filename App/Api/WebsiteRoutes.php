<?php
	/*
	* GET request that returns the home page of the Reuse and Repair Directory
	* @return string JSON
	*/
	$app->get('/', function() use ($app) {
		$app->redirect("/HomeSite/home.php");
	}); 
	
	
	
	
	//NOTE: WE SHOULD SEPARATE PAGE ROUTES FROM API ROUTES LATER
	
	
	
	
	//replacing a single single-quote with two single-quotes in a given string
	function singleToDoubleQuotes(&$string) {
		$string = str_replace("'","''", $string);
	}
	
	//replacing a single underscore with a slash 
	function underscoreToSlash(&$string) {
		$string = str_replace("_","/", $string);
	}
	
	/*
	* a special GET request that provides a list of distinct businesses NOT in Repair, Repair Items, or Recycle
	* @api
	* @return string JSON
	*/
	$app->get('/business/reuseExclusive', function(){
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name NOT IN ('Repair', 'Repair Items', 'Recycle')");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides a list of distinct businesses associated with a given category, ordered by business names
	* @api
	* @return string JSON
	*/
	$app->get('/business/category/name/:cat_name', function($cat_name){
		singleToDoubleQuotes($cat_name);
		underscoreToSlash($cat_name);
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name = '$cat_name' ORDER BY loc.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides a list of distinct businesses NOT in the given category
	* @api
	* @return string JSON
	*/
	$app->get('/business/category/name/not/:cat_name', function($cat_name){
		singleToDoubleQuotes($cat_name);
		underscoreToSlash($cat_name);
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name <> '$cat_name'");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides all distinct businesses
	* @api
	* @return string JSON
	*/
	$app->get('/business', function(){
		
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id");//NOTE THAT LAST INNER JOIN IS UNNECESSARY - REMOVE LATER 

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides a list of distinct businesses accepting a given item
	* @api
	* @return string JSON
	*/
	$app->get('/business/item/name/:item_name', function($item_name){
		singleToDoubleQuotes($item_name);
		underscoreToSlash($item_name);
		
		$mysqli = connectReuseDB();
		
		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id WHERE item.name = '$item_name'");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides a list of distinct businesses associated with a given category and and item in the category
	* @api
	* @return string JSON
	*/
	$app->get('/business/category/name/:cat_name/item/name/:item_name', function($cat_name, $item_name){
		
		singleToDoubleQuotes($cat_name);
		singleToDoubleQuotes($item_name);
		underscoreToSlash($item_name);
		underscoreToSlash($cat_name);
		//echo $cat_name."	".$item_name;
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name = '$cat_name' AND item.name = '$item_name'");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	
	
	/*
	* GET request that provides a business with a given name, not including items accepted
	* @api
	* @return string JSON
	*/
	$app->get('/business/name/:bus_name', function($bus_name){
		$mysqli = connectReuseDB();
		
		singleToDoubleQuotes($bus_name);
		underscoreToSlash($bus_name);
		
		$result = $mysqli->query("SELECT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id WHERE loc.name = '$bus_name'");

		$business = $result->fetch_object();

	    echo json_encode($business);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides an ordered array of items accepted by a business with a given name, ordered by item names
	* @api
	* @return string JSON
	*/
	$app->get('/item/business/name/:bus_name', function($bus_name){
		$mysqli = connectReuseDB();

		singleToDoubleQuotes($bus_name);
		underscoreToSlash($bus_name);
		
		$result = $mysqli->query("SELECT item.name FROM Reuse_Items AS item INNER JOIN Reuse_Locations_Items AS loc_item ON item.id = loc_item.item_id INNER JOIN
		Reuse_Locations AS loc ON loc.id = loc_item.location_id WHERE loc.name = '$bus_name' ORDER BY item.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides an array of item names for items in a given category as well as the number of businesses for each item, ordered by ordered by item name
	* @api
	* @return string JSON
	*/
	$app->get('/item/category/name/:cat_name', function($cat_name){
		
		singleToDoubleQuotes($cat_name);
		underscoreToSlash($cat_name);
		
		
		
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT item.name, COUNT(loc_item.location_id) AS item_count FROM Reuse_Items AS item INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id INNER JOIN Reuse_Locations_Items AS loc_item ON item.id = loc_item.item_id WHERE cat.name = '$cat_name' GROUP BY (item.name) ORDER BY item.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides an array of item names for items in any categories excluding the special categories of Repair, Repair Items, or Recycling as the number of businesses for each item, ordered by ordered by item name
	* @api
	* @return string JSON
	*/
	$app->get('/item/category/reuseExclusive', function(){
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT item.name, COUNT(loc_item.location_id) AS item_count FROM Reuse_Items AS item INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id INNER JOIN Reuse_Locations_Items AS loc_item ON item.id = loc_item.item_id WHERE cat.name NOT IN ('Repair', 'Repair Items', 'Recycle') GROUP BY (item.name) ORDER BY item.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	/*
	* GET request that provides an array of category names not including Repair, Repair Items, and Recycle, ordered by ordered by category names
	* @api
	* @return string JSON
	*/
	$app->get('/category/reuseExclusive', function(){
		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT cat.name FROM Reuse_Categories AS cat WHERE cat.name NOT IN ('Repair', 'Repair Items', 'Recycle') ORDER BY cat.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});
	
	
	
	?>
