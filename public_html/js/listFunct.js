var APIBase = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller
//var APIBase = "http://app.sustainablecorvallis.org"; //used by the live website

//adds dropdown menu links of items in the Repair Items category to "header-repair-links"
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
				
				/*
				 
				 <ul class="list-group">
				  <li class="list-group-item">New <span class="badge">12</span></li>
				  <li class="list-group-item">Deleted <span class="badge">5</span></li> 
				  <li class="list-group-item">Warnings <span class="badge">3</span></li> 
				</ul>
				*/
				
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
	
	var repairItemsURI = APIBase + "/item/category/name/Repair%20Items";
	
	req.open("GET", repairItemsURI, true);
	req.send();
}