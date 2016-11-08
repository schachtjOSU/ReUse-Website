var APIBase = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller
//var APIBase = "http://app.sustainablecorvallis.org"; //used by the live website

// Returns a pin with the passed color, or CSC orange by default. Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
function pin(pinColor) {
	if (pinColor === undefined) {
		pinColor = "F89420"; //setting default color to CSC orange
	}
	
	var pin = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
		new google.maps.Size(21, 34),
		new google.maps.Point(0,0),
		new google.maps.Point(10, 34));
	
	return pin;
}

//ititializes the map centered on the Corvallis area
function corvallisMap () {
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	
	return map;
}

//returns an object with lat and lng as floats
function LatLng(lat, lng) {
	var latLng = {lat: parseFloat(lat), lng: parseFloat(lng)};
	return latLng;
}

//ititializes a marker with latLng, map, pin, busName, busAddress, busCity, busState, busZip
function marker(latLng, map, pin, busName, busAddress, busCity, busState, busZip) {
	var marker = new google.maps.Marker({
		position: latLng,
		map: map,
		icon: pin,
		title: busName,
		street_address: busAddress,
		city_address: busCity + " " + ", " + busState + " " + busZip
		});

	return marker;
}

//adds an info window for a given marker
function addInfoWindow(marker, map) {
	var infoWindow = new google.maps.InfoWindow();
	
	//adding the listener for clicking a marker
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map, this);
		infoWindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
	});
	
	// adding listener so clicking the map closes Info Windows
	google.maps.event.addListener(map, "click", function(event) {
		infoWindow.close();
	});
}

//initializes a map with repair, recycling, and other businesses in three colors
function initGeneralMap() {
	
	var map =  corvallisMap();
	
	
	
	
	var reqReuse = new XMLHttpRequest();
	var reqRecycle = new XMLHttpRequest();
	var reqRepair = new XMLHttpRequest();
	
	reqRecycle.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				var pinColor = "7C903A";
				var pinImage = pin(pinColor);
				
				var myLatLng = LatLng(businesses[i].latitude, businesses[i].longitude);
				var myMarker = marker(myLatLng, map, pinImage, businesses[i].name, businesses[i].address_line_1, businesses[i].city, businesses[i].abbreviation, businesses[i].zip_code);

				addInfoWindow(myMarker, map);
				
			}
		}
	};
	
	reqRepair.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				var pinColor = "47A6B2";
				var pinImage = pin(pinColor);
				
				var myLatLng = LatLng(businesses[i].latitude, businesses[i].longitude);
				
				var myMarker = marker(myLatLng, map, pinImage, businesses[i].name, businesses[i].address_line_1, businesses[i].city, businesses[i].abbreviation, businesses[i].zip_code);
				addInfoWindow(myMarker, map);
				
			}	
		}
		
	};
	
	reqReuse.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				var pinColor = "F89420";
				var pinImage = pin(pinColor);
				
				var myLatLng = LatLng(businesses[i].latitude, businesses[i].longitude);
				
				var myMarker = marker(myLatLng, map, pinImage, businesses[i].name, businesses[i].address_line_1, businesses[i].city, businesses[i].abbreviation, businesses[i].zip_code);
				addInfoWindow(myMarker, map);
				
			}
		}
		
	};

	reqReuse.open("GET", APIBase + "/business/reuseExclusive", true);
	reqReuse.send();
	
	reqRecycle.open("GET", APIBase + "/business/category/name/Recycle", true);
	reqRecycle.send();
	
	reqRepair.open("GET", APIBase + "/business/category/name/Repair%20Items", true);
	reqRepair.send();

}

//initializes a map with businesses from a given category, or all categories except Repair Items and Recycle if no category name is given
function initCategoryMap(categoryName) {
		
	var map =  corvallisMap();
	
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				var pinImage = pin();
				var myLatLng = LatLng(businesses[i].latitude, businesses[i].longitude);
				
				var myMarker = marker(myLatLng, map, pinImage, businesses[i].name, businesses[i].address_line_1, businesses[i].city, businesses[i].abbreviation, businesses[i].zip_code);
				addInfoWindow(myMarker, map);		
			}
		}	
	};
	
	
	if(categoryName === undefined) {
		var catURI = APIBase + "/business/reuseExclusive"; 
	}
	else {
		var catURI = APIBase + "/business/category/name/" + categoryName; 
	}
	
	req.open("GET", catURI, true);
	req.send();
}

//initializes a map with businesses associated with a given category and item
function initItemMap(categoryName, itemName) {
		
	var map =  corvallisMap();
	
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			
			for(i = 0; i < businesses.length; i++) {
				
				var pinImage = pin();
				var myLatLng = LatLng(businesses[i].latitude, businesses[i].longitude);
				var myMarker = marker(myLatLng, map, pinImage, businesses[i].name, businesses[i].address_line_1, businesses[i].city, businesses[i].abbreviation, businesses[i].zip_code);

				addInfoWindow(myMarker, map);
				
			}
		}
		
	};

	var itemURI = APIBase + "/business/category/name/" + categoryName + "/item/name/" + itemName;
	
	req.open("GET", itemURI, true);
	req.send();
}

//initializes a map with a pin for a single business with a given name
function initBusinessMap(busName) {
		
	var map =  corvallisMap();
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			var pinImage = pin();
			var myLatLng = LatLng(businesses.latitude, businesses.longitude);
			var myMarker = marker(myLatLng, map, pinImage, businesses.name, businesses.address_line_1, businesses.city, businesses.abbreviation, businesses.zip_code);
			
			addInfoWindow(myMarker, map);
			
		}
	};

	var busURI = APIBase + "/business/name/" + busName;
	
	req.open("GET", busURI, true);
	req.send();
}


  
  
  
  