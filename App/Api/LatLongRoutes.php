<?php

/******************************************************************************************
*		Special Route the Updates Every Business with a Latitude and Longitude
******************************************************************************************/
	
	
	
	
	/* Updates all businesses with lats and longs */
/*	$app->put('/setLatLongs', function(){

		$mysqli = connectReuseDB();
		
		//getting old addresses and ids
		
		$result = $mysqli->query("SELECT DISTINCT loc.id, loc.address_line_1, state.abbreviation, loc.city, loc.zip_code FROM Reuse_Locations AS loc LEFT JOIN States AS state ON state.id = loc.state_id ");

		$returnArray = array();
	    while($row = $result->fetch_object()){
	      $returnArray[] = $row;
	    }
		$result->close();
		
		
		for($i = 0; $i < count($returnArray); $i++) {
			$id = $returnArray[$i] -> id;
			$address = $returnArray[$i] -> address_line_1;
			$city = $returnArray[$i] -> city;
			$state = $returnArray[$i] -> abbreviation;
			$zipcode = $returnArray[$i] -> zip_code;
			
			if($address != NULL && $city != NULL && $state != NULL && $zipcode != NULL) {
				//echo($id." ".$address." ".$city." ".$state." ".$zipcode."\n");
				
				$latlong = bingGeocode($address, $city, $state, $zipcode);
				
				if ($latlong != false) {
					
					$latitude = $latlong['lat'];
					$longitude = $latlong['long'];
					echo($latitude." ");
					
					$mysqli->query("UPDATE Reuse_Locations SET latitude = '$name', longitude = '$longitude' WHERE id = '$id'");
					
				}
			}
			
		}
		//echo json_encode($returnArray);
		$mysqli->close();

	});
)*/
?>
