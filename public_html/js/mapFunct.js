function initGeneralMap() {
	
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: Corvallis
	});
	
	//placing pins for local businesses
	
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var businesses = JSON.parse(this.responseText);
			
			for(i = 0; i < businesses.length; i++) {
				
				var myLatLng = {lat: parseFloat(businesses[i].latitude), lng: parseFloat(businesses[i].longitude)};
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				title: businesses[i].name,
				street_address: businesses[i].address_line_1,
				city_address: businesses[i].city + " " + ", " + businesses[i].abbreviation + " " + businesses[i].zip_code
				});	

				var infowindow = new google.maps.InfoWindow();
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, this);
					infowindow.setContent("<p><strong>" + this.title + "</strong></p><p>" + this.street_address + "<br>" + this.city_address + "</p>"); 
				});
				
			}
		}
		
	};
	
	req.open("GET", "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php/business", true);//use when developing locally
	//req.open("GET", "http://app.sustainablecorvallis.org/business", true);//use for live site
	req.send();

}
  
  