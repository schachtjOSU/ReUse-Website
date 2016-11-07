var APIBase = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller
//var APIBase = "http://app.sustainablecorvallis.org"; //used by the live website

function initGeneralMap() {
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	
	//calling reqReuse, then ReqRepair, then reqRecycle
	var reqReuse = new XMLHttpRequest();
	var reqRecycle = new XMLHttpRequest();
	var reqRepair = new XMLHttpRequest();
	
	reqRecycle.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "7C903A";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}

		}
		
	};
	
	reqRepair.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "47A6B2";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
			
			reqRecycle.open("GET", APIBase + "/business/category/name/Recycle", true);
			reqRecycle.send();
			
			
		}
		
	};
	
	reqReuse.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "F89420";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
			
			reqRepair.open("GET", APIBase + "/business/category/name/Repair%20Items", true);
			reqRepair.send();
			
			
		}
		
	};

	reqReuse.open("GET", APIBase + "/business/reuseOnly", true);//use when developing locally
	reqReuse.send();

}

function initCategoryMap(categoryName) {
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	
	//calling reqReuse, then ReqRepair, then reqRecycle
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "F89420";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
		}
		
	};
	
	
	
	if(categoryName === undefined) {
		var catURI = APIBase + "/business/reuseOnly"; 
	}
	else {
		var catURI = APIBase + "/business/category/name/" + categoryName; 
	}
	
	req.open("GET", catURI, true);
	req.send();
}

function initItemMap(categoryName, itemName) {
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	
	//calling reqReuse, then ReqRepair, then reqRecycle
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			
			for(i = 0; i < businesses.length; i++) {
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "F89420";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
		}
		
	};

	var itemURI = APIBase + "/business/category/name/" + categoryName + "/item/name/" + itemName;
	
	req.open("GET", itemURI, true);
	req.send();
}

function initBusinessMap(busName) {
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	
	//calling reqReuse, then ReqRepair, then reqRecycle
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			
			
			for(i = 0; i < businesses.length; i++) {
				
				//console.log(businesses[i].name);
				
				//Reference http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker/7686977#7686977
				var pinColor = "F89420";
				var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
					new google.maps.Size(21, 34),
					new google.maps.Point(0,0),
					new google.maps.Point(10, 34));
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: pinImage,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong><a href=business.php?b=" + encodeURI(this.title) + ">" + this.title + "</a></strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
		}
		
	};

	var busURI = APIBase + "/business/name/" + busName;
	
	req.open("GET", busURI, true);
	req.send();
}


  
  
  
  