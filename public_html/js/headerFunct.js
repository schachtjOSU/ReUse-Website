var APIBase = "http://localhost/Corvallis-Sustainability-ReUse/public_html/index.php"; //used for local development by Lauren Miller
var APIBase = ""; //used by the live website and colleen

// Listen for the Enter key for the search and then do things after that.
$(document).keypress(function(e) {
    if(e.which == 13) {
        //alert('You pressed enter!');
        // Get the search term
        var search_term = $('#searchTerm').val();
        //console.log(search_term);
        // Find special characters
        //Source: http://stackoverflow.com/questions/13840143/jquery-check-if-special-characters-exists-in-string
        if(/^[a-zA-Z0-9- ]*$/.test(search_term) == false) {
            alert('Your search string contains illegal characters.  Please try Again!');
        }
        else {
        	// Start with categories
            $.ajax({
                type: "GET",
                url: "/itemSearch/" + search_term,
                dataType: 'json',
                success: function(data) {
                    console.log(data[0].name);
                    if (data.length == 0)
                        alert("No data found with given search.  Please try again!")
                    else {
                    	var name = data[0].name;
                    	var next_url = "item.php?cat=Repair%20Items&item="
                    	window.location.href = next_url + name;
					}
                },
            });
		}
    }
});

//adds dropdown menu links of items in the Repair Items category to "header-repair-links"
function addRepairLinks() {
	var req = new XMLHttpRequest();

	req.onreadystatechange = function() {

		if (this.readyState == 4 && this.status == 200) {
			var items = JSON.parse(this.responseText);

			for(i = 0; i < items.length; i++) {

				var dropDown = document.getElementById("header-repair-links");

				var link = document.createElement("a");
				var linkText = document.createTextNode(items[i].name);
				link.appendChild(linkText);
				link.setAttribute('href', "item.php?cat=Repair%20Items&item=" + encodeURI(items[i].name));

				dropDown.appendChild(link);
			}

		}
	};

	var repairItemsURI = APIBase + "/item/category/name/Repair%20Items";

	req.open("GET", repairItemsURI, true);
	req.send();
}

//adds dropdown menu links of all categories not in the special categories of Repair, Repair Items, or Recycle
function addReuseLinks() {
	var req = new XMLHttpRequest();

	req.onreadystatechange = function() {

		if (this.readyState == 4 && this.status == 200) {
			var items = JSON.parse(this.responseText);

			for(i = 0; i < items.length; i++) {

				var dropDown = document.getElementById("header-reuse-links");

				var link = document.createElement("a");
				var linkText = document.createTextNode(items[i].name);
				link.appendChild(linkText);
				link.setAttribute('href', "category.php?name=" + encodeURI(items[i].name));

				dropDown.appendChild(link);
			}

		}
	};

	var reuseCatsURI = APIBase + "/category/reuseExclusive";

	req.open("GET", reuseCatsURI, true);
	req.send();
}


//adds dropdown menu links of all businesses associated with the Category Recycle
function addRecycleLinks() {
	var req = new XMLHttpRequest();

	req.onreadystatechange = function() {

		if (this.readyState == 4 && this.status == 200) {
			var recycleCenters = JSON.parse(this.responseText);

			for(i = 0; i < recycleCenters.length; i++) {

				var dropDown = document.getElementById("header-recycle-links");

				var link = document.createElement("a");
				var linkText = document.createTextNode(recycleCenters[i].name);
				link.appendChild(linkText);
				link.setAttribute('href', "business.php?name=" + encodeURI(recycleCenters[i].name));

				dropDown.appendChild(link);
			}

		}
	};

	var recycleURI = APIBase + "/business/recycleExclusive";

	req.open("GET", recycleURI, true);
	req.send();
}
