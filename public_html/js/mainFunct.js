
/***************************************************************
        YOUR WEBSITE HERE
***************************************************************/
var webURL = "";


/*
function checkSession
purpose: logs user out if not properly logged in
*/
function checkSession(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

        if(req.responseText == 1){
          /* everything has passed! Yay! Go into your session */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = webURL + "/AdminSite/loginPage.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}

/*
function addRoute
Purpose: directs user to correct area
*/
function addRoute(){

  /* send to appropriate site */
  var name = document.getElementById("choose").value;
  if(name == "Business")
    window.location.href = webURL + "/AdminSite/addBusiness.php";
  if(name == "Category")
        window.location.href = webURL + "/AdminSite/addCategory.php";
  if(name == "Item")
        window.location.href = webURL + "/AdminSite/addItem.php";
}

/*
function addRoute
Purpose: directs user to correct area
*/
function EditRoute(){

  /* send to appropriate site */
  var name = document.getElementById("choose").value;
  if(name == "Business")
    window.location.href = webURL + "/AdminSite/searchBusiness.php";
  if(name == "Category")
        window.location.href = webURL + "/AdminSite/searchCategory.php";
  if(name == "Item")
        window.location.href = webURL + "/AdminSite/searchItem.php";
}
