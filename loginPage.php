<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Corvallis Reuse and Repair Directory: Web Portal</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/customStylesheet.css" rel="stylesheet">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Rubik:700' rel='stylesheet' type='text/css'>
  <script>

  /************************************************************************
  * 				Error handling login
  ************************************************************************/

function login(){

  /* get values from form */
  var user = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var type = "login"

  /* check for blanks in the form */
  if(user == "" && password == ""){
    document.getElementById("output").innerHTML= "Enter a Username and Password";
   return;
  }
  if(user == ""){
    document.getElementById("output").innerHTML = "Enter a Username";
   return;
  }

  if(password == ""){
    document.getElementById("output").innerHTML ="Enter a Password";
    return;
  }

  /* if no blanks, make the request and check for password match */
  else{
    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if(req.readyState == 4 && req.status == 200){

        /* add user to DB */
        if(req.responseText == 1){
        /* everything has passed! Session begin */
        window.location.href = "http://web.engr.oregonstate.edu/~masseyta/testApi/main.php";
        }

        /* false, errors. Notify  user, no addition to DB */
        if(req.responseText == 0){
            document.getElementById("output").innerHTML = "Error: Username or Password Incorrect.";
            document.getElementById("LForm").reset(); 
         }

         /* logged in already under another name */
         if(req.responseText == 3){
            killSession();
         }

         /* errors I couldn't think of will print, destroying my grade */
        else if(req.responseText != 1 && req.responseText != 0){
          document.getElementById("output").innerHTML = req.responseText;
        }
      }
    }

    /* send to login.php for the session and db connection */
    req.open("POST","index2.php", true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var loginData ="type="+type+"&username="+user+"&password="+password;
    req.send(loginData);

  }
}

function killSession(){
    var tableData = "killSession";
    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index2",
      data: tableData,
      success: function(data){
        console.log("Success");
      },
    });
  window.alert('Session already in progress. Logging out old user.')
  window.location.href = "http://web.engr.oregonstate.edu/~masseyta/testApi/loginPage.php";
}
</script>
</head>
<body">
  
  <!-- Main container -->
  <div class="container-fluid" id="smallCont">

    <!-- logo, left corner -->
    <img src="img/CSCLogo.png" class="img-thumbnail">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <hr></hr>
        <!-- Get the user's login information -->
        <form id="loginForm">
          <h3> DATABASE MANAGEMENT PORTAL </h3>
        </p>
        <div class="form-group">
           <label>Enter your username: </label>
           <input type ="text" class="form-control" Id="username" placeholder="Enter Username">
        </div> <!-- end formground-->
        <div class="form-group">
            <label>Enter your password: </label>
            <input type ="password" class="form-control" Id ="password" placeholder="Password">
        </div><!-- end formgroup -->
        <p align="center">

          <!-- Send information to loginCheck function for error handling and ajax call if wrong -->
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="login(); return false" align="center">Login</button>
        </p>
        </form>
        <!-- Hidden row for displaying login errors -->
        <div class="row">
          <div class="col-xs-12 cold-md-8" Id= "output"></div>
        </div class="row"><!-- end inner row -->
      </div> <!-- end column -->
    </div> <!-- end row -->
    <hr></hr>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
	</body>
</html>