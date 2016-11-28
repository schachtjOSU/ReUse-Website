<?php

	/**
  	 * @api {get} /
     * @apiName ReUseWebsite
     *
	 * @apiSuccess {Webpage} /HomeSite/home.php The home page of the Reuse and Repair Directory
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

	/**
  	 * @api {get} /business/reuseExclusive
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray Distinct businesses not in Repair, Repair Items, or Recycle and not having the recycle flag set to 1.
	 */
	$app->get('/business/reuseExclusive', function(){

		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name NOT IN ('Repair', 'Repair Items', 'Recycle') AND loc.recycle <> 1");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	/**
  	 * @api {get} /business/recycleExclusive
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray Distinct businesses that are recycling centers, having the recycle flag set to 1.
	 */
	$app->get('/business/recycleExclusive', function(){

		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id WHERE loc.recycle = 1");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});



	/**
  	 * @api {get} /business/category/name/:cat_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} cat_name Category name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Distinct businesses associated with a given category, ordered by business names.
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

	/**
  	 * @api {get} /business/category/name/not/:cat_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} cat_name Category name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Distinct businesses not associated with a given category, ordered by business names.
	 */
	$app->get('/business/category/name/not/:cat_name', function($cat_name){
		singleToDoubleQuotes($cat_name);
		underscoreToSlash($cat_name);

		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT loc.name, loc.id, loc.address_line_1, loc.address_line_2, state.abbreviation, loc.phone, loc.website, loc.city, loc.zip_code, loc.latitude, loc.longitude FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id INNER JOIN Reuse_Locations_Items AS loc_item ON loc.id = loc_item.location_id INNER JOIN Reuse_Items AS item ON loc_item.item_id = item.id INNER JOIN Reuse_Categories AS cat ON item.category_id = cat.id WHERE cat.name <> '$cat_name' ORDER BY loc.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});


	/**
  	 * @api {get} /business/category/name/not/:cat_name
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray All distinct businesses.
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


	/**
  	 * @api {get} /business/item/name/:item_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} item_name Item name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Distinct businesses accepting a given item.
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

	/**
  	 * @api {get} /business/item/name/:item_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} item_name Item name (mandatory).
	 * @apiParam {String} cat_name Category name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Distinct businesses associated with a given category and and item in the category.
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



	/**
  	 * @api {get} /business/name/:bus_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} bus_name Business name (mandatory).
	 * @apiSuccess {JSON Object} business Businesses with a given name.
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

	/**
  	 * @api {get} /item/business/name/:bus_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} bus_name Business name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Items accepted by the business with the given name, ordered by item name.
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


	/**
  	 * @api {get} /item/category/name/:cat_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} cat_name Category name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Items in the given category as well as the number of businesses accepting an item, ordered by item name.
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

	/**
  	 * @api {get} /item/category/reuseExclusive
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray Items in any category excluding the special categories of Repair, Repair Items, or Recycling and a count of the number of businesses for each item, ordered by ordered by item name.
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


	/**
  	 * @api {get} /category/reuseExclusive
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray All category names not including Repair, Repair Items, and Recycle, ordered by ordered by category name.
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

	/**
  	 * @api {get} /document/business/name/:bus_name
     * @apiName ReUseApp
     *
	 * @apiParam {String} bus_name Business name (mandatory).
	 * @apiSuccess {JSON[]} returnArray Documents/links associated with a given business, ordered by document name.
	 */
	$app->get('/document/business/name/:bus_name', function($bus_name){
		singleToDoubleQuotes($bus_name);
		underscoreToSlash($bus_name);

		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT doc.name, doc.URI FROM Reuse_Documents AS doc INNER JOIN Reuse_Locations AS loc ON doc.location_id = loc.id WHERE loc.name = '$bus_name' ORDER BY doc.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});


	/**
  	 * @api {get} /donor
     * @apiName ReUseApp
     *
	 * @apiSuccess {JSON[]} returnArray All donors, ordered by donor name.
	 */
	$app->get('/donor', function(){

		$mysqli = connectReuseDB();

		$result = $mysqli->query("SELECT DISTINCT donor.name, donor.description, donor.websiteurl FROM Reuse_Donors AS donor ORDER BY donor.name");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }

	    echo json_encode($returnArray);

	    $result->close();
	    $mysqli->close();
	});

	?>
