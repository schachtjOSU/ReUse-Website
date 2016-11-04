function initGeneralMap() {
	
		
	//centering the map on Corvallis
	var Corvallis = {lat: 44.569949, lng: -123.278285};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 12,
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
				map: map
				});	
			}
		}
		else {
			
		}
	};
	
	req.open("GET", "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php/business", true);//NOTE THAT THIS URL WILL NEED TO BE CHANGED FOR LIVE SITE
	req.send();

}
  
  