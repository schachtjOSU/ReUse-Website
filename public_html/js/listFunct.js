var APIBase = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller
//var APIBase = "http://app.sustainablecorvallis.org"; //used by the live website

//adds list of items to "category-list-container"
function addItemList(catName) {
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		
		if (this.readyState == 4 && this.status == 200) {
			var items = JSON.parse(this.responseText);
			
			for(i = 0; i < items.length; i++) {
				
				var listDiv = document.getElementById("category-list-container");
				listDiv.className += " list-group";
				
				var link = document.createElement("a");
				link.className = "list-group-item";
				link.setAttribute('href', "item.php?cat=Repair%20Items&item=" + encodeURI(items[i].name));
				
				
				var itemName = document.createTextNode(items[i].name);
				itemName.className = "list-group-item-heading";
				link.appendChild(itemName);
				
				var itemCountSpan = document.createElement("span");
				itemCountSpan.className = "badge";
				var itemCount = document.createTextNode(items[i].item_count);
				itemCountSpan.appendChild(itemCount);
				link.appendChild(itemCountSpan);

				listDiv.appendChild(link);
			}
			
		}
	};
	
	if(catName === undefined || catName === "") {
		var itemsURI = APIBase + "/item/category/reuseExclusive";
	}
	else {
		var itemsURI = APIBase + "/item/category/name/" + catName;
	}
	
	
	req.open("GET", itemsURI, true);
	req.send();
}


//adds list of businesses to "item-list-container"
function addBusinessList(busName) {
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		
		if (this.readyState == 4 && this.status == 200) {
			var bus = JSON.parse(this.responseText);
			
			for(i = 0; i < bus.length; i++) {
				
				var listDiv = document.getElementById("item-list-container");
				listDiv.className += " list-group";
				
				var link = document.createElement("a");
				link.className = "list-group-item";
				link.setAttribute('href', "business.php?name=" + encodeURI(bus[i].name));
				
				var linkTitle = document.createElement("p");
				linkTitle.className = "list-group-item-heading";
				var busName = document.createTextNode(bus[i].name);
				linkTitle.appendChild(busName);
				
				link.appendChild(linkTitle);
				
				if (bus[i].address_line_1  && bus[i].city && bus[i].abbreviation && bus[i].zip_code ) {
					var linkAddress = document.createElement("p");
					linkTitle.className = "list-group-item-text";
					var busAddress = document.createTextNode(bus[i].address_line_1 + ", " + bus[i].city + ", " + bus[i].abbreviation + " " + bus[i].zip_code);
					linkAddress.appendChild(busAddress);
					link.appendChild(linkAddress);
					
				}
				
				if(bus[i].website) {
					var linkWebsite = document.createElement("a");
					linkWebsite.setAttribute('href', bus[i].website);
					linkWebsite.className = "list-group-item-text";
					var busWebsite = document.createTextNode(bus[i].website);
					linkWebsite.appendChild(busWebsite);
					link.appendChild(linkWebsite);
				}
				
				

				listDiv.appendChild(link);
			}
			
		}
	};
	
	if(busName === undefined || busName === "") {
		var busURI = APIBase + "/business/reuseExclusive";
	}
	else {
		var busURI = APIBase + "/business/name/" + busName;
	}
	
	
	req.open("GET", busURI, true);
	req.send();
}
