<?php
/* Escape problem characters in XML ( '<', '>', '&', ''', '"' ) */
function escapeSpecial($str) {
	$specialChars 	= array("<",	">", 	"&", 		"'", 		'"' );
	$escapeTags 	= array("&lt;",	"&gt;",	"&amp;",	"&apos;",	"&quot;");
	$str = str_replace($specialChars, $escapeTags, $str);
	$str = preg_replace('/[[:^print:]]/', '', $str);
	return $str;
}

/* Generates an XML string from the Reuse project's SQL database */
function reuse_generateXML() {
	
	/* Filename to write XML to */
		// - As $XML_FILENAME	
	require 'xmlGeneratorConfig.php' ;
	
	/* Database Connection function */
	/* It's messy, but assumed to be defined prior to this page being included */
	//require $DATABASE_CONNECT;
	
	/* SimpleXML Declaration */
	$sxml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><reuse/>');
	
	/* Revision */	
	$revision = $sxml->addChild("Revision", uniqid() );
	/* Business List*/
	$businessList = $sxml->addChild("BusinessList");
	
	/* connect to database */
	/* OLD	
	include( $DATABASE_CRED_FILE );
	$mysqli = new mysqli($DBUrl, $DBUser, $DBPw, $DBName);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to database (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		exit();
	}
	*/
	/* NEW */
	$mysqli = connectReuseDB();
	
	/* Query for businesses and all items associated with it */
	//Prepare Statement - Select all businesses and their attributes
	if ( !($stmt = $mysqli->prepare( "SELECT L.id, L.name, L.address_line_1, L.address_line_2, L.city, S.abbreviation, L.zip_code, L.phone, L.website, L.latitude, L.longitude  FROM Reuse_Locations L LEFT JOIN States S ON L.state_id = S.id" ) ) ) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	$stmt->bind_result($Loc_id, $name, $address_line_1, $address_line_2, $city, $state, $zip_code, $phone, $website, $latitude, $longitude);
	$stmt->execute();
	$stmt->store_result();
	
	  //fetch and print results
	while ($stmt->fetch()) {
		//echo "$name \r\n";
		$business = $businessList->addChild("business");
		$business->addChild("id", $Loc_id);
		$business->addChild("name", escapeSpecial($name));
		$contact_info = $business->addChild("contact_info");
			$address = $contact_info->addChild("address");			
				$address->addChild("address_line_1", escapeSpecial($address_line_1));
				$address->addChild("address_line_2", $address_line_2);
				$address->addChild("city", escapeSpecial($city));
				$address->addChild("state", $state);
				$address->addChild("zip", escapeSpecial($zip_code));
			$contact_info->addChild("phone", escapeSpecial($phone));
			$contact_info->addChild("website", escapeSpecial($website));
			$latlong = $contact_info->addChild("latlong");
				$latlong->addChild("latitude", $latitude);
				$latlong->addChild("longitude", $longitude);
		$catList = $business->addChild("category_list");
		
		if ( !(	$stmt2 = $mysqli->prepare( "SELECT DISTINCT CAT.id, CAT.name FROM Reuse_Categories CAT INNER JOIN Reuse_Items ITM ON ITM.category_id = CAT.id INNER JOIN Reuse_Locations_Items L_ITM ON L_ITM.item_id = ITM.id INNER JOIN Reuse_Locations L ON L.id = L_ITM.location_id WHERE L.id = ?") ) ) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		$stmt2->bind_param('i', $Loc_id);
		$stmt2->bind_result($cat_id, $cat_name);
		$stmt2->execute();
		$stmt2->store_result();
		while ($stmt2->fetch()) {
			//echo "\t $cat_name \r\n";
			$category = $catList->addChild("category");
				$category->addChild("name", $cat_name);
				$subcatlist = $category->addChild("subcategory_list");
			$stmt3 = $mysqli->prepare("SELECT ITM.name FROM Reuse_Categories CAT INNER JOIN Reuse_Items ITM ON ITM.category_id = CAT.id INNER JOIN Reuse_Locations_Items L_ITM ON L_ITM.item_id = ITM.id INNER JOIN Reuse_Locations L ON L.id = L_ITM.location_id WHERE L.id = ? AND CAT.id = ?");
			$stmt3->bind_param('ii', $Loc_id, $cat_id);
			$stmt3->bind_result($subcat_name);
			$stmt3->execute();
			
			$i = 0;
			while ($stmt3->fetch()) {
				//echo "\t\t $subcat \r\n";
				//$i = $i + 1;
				$subcat = $subcatlist->addChild("subcategory", $subcat_name);
			}
			$stmt3->close();
		}
		$stmt2->close();
		
	}
	$stmt->close();
	
	$sxml->asXML( $XML_FILENAME );
	return true;
	
}


/* Reads in xml file, converts to a string, and echos it out in text/xml MIME-type */
function echoXMLFile() {
	/* File Location To Read */
	include ( 'xmlGeneratorConfig.php' );
	
	/*output type is xml*/
	header('Content-Type: application/xml');

	
	//create the file if it doesn't exist
	if (file_exists($XML_FILENAME) == false) {
		reuse_generateXML();
		
		if (file_exists($XML_FILENAME) == false) {
			// if the file still doesn't exist, there are problems
			echo "$XML_FILENAME Does not Exist.  Check the configuration of XML Generator";
		}
	}
	
	
	echo file_get_contents( $XML_FILENAME );
	
	return;
}

?>
