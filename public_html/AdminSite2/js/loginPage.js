function login(){

  /* get values from form */
  var user = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var type = "login"

  /* if no blanks, make the request and check for password match */
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if(req.readyState == 4 && req.status == 200){

        /* add user to DB */
        if(req.responseText == 1){
        /* everything has passed! Session begin */
        window.location.href = "/AdminSite2/main.php";
        }

        /* false, errors. Notify  user, no addition to DB */
        if(req.responseText == 0){
            alert("Error: Incorrect user name or password.");
         }

         /* logged in already under another name */
         if(req.responseText == 3){
            killSession();
         }

         /* other errors */
        else if(req.responseText != 1 && req.responseText != 0){
          alert(req.responseText);
        }
      }
    }

    /* send to loginCheck.php for the session and db connection-- Calls function login() */
    req.open("POST","/AdminSite/loginCheck.php", true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var loginData ="type="+type+"&username="+user+"&password="+password;
    req.send(loginData);

  
}

/*
function killSession
purpose: Kill session
*/
function killSession(){
    var tableData = "killSession";
    $.ajax({type:"POST",
      url: "/AdminSite/loginCheck.php",
      data: tableData,
      success: function(data){
        console.log("Success");
      },
    });
  window.alert('Session already in progress. Logging out old user.')
  window.location.href = webURL + "/AdminSite/loginPage.php";
}
