<head>
   <meta charset="UTF-8">
   <title>Login Form</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
   <link rel="stylesheet" type="text/css" href="css/loginPage.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
</head>
<body>
   <div class="login">
      <h1>Login</h1>
      <!-- <form method="post" action="main.php"> -->
      <form method="post" action="/RUapi/login">
         <input type="text" name="u" placeholder="Username" required="required" />
         <input type="password" name="p" placeholder="Password" required="required" />
         <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
      </form>
   </div>
</body>
</html>

<?php

function login()
  /* variables */
  $username = $_POST['username'];
  $username = strtoupper($username);
  //$password = $_POST['password'];
  $password = crypt($_POST['password'], 'rl');
  $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
  if($mysqli->connect_errno){
    echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
  }
    /* check for someone elses session prior to starting page */
    if(isset($_SESSION['username']) && $_SESSION['username'] != $username){
      if($_SESSION['loggedIn'] != false){
        echo "Another user is already logged in. Please click ";
        echo "<a href='logout.php'>here</a> to log out.";
      }
    }
    else{
    /************************************************************************
    * 					Search for users name and password
    ************************************************************************/
    /* Select user input for search */
    $result = "SELECT login FROM Reuse_User_Credentials WHERE login='$username' && pw_hash='$password'";
    $product = $mysqli->query($result);
    $numReturned = $product->num_rows;
    /* if no results, there's no record of that username/password match */
    if($numReturned == 0){
      echo 0;				// false back to javascript
    }
    /* there is a match, so log them in an create a session */
    else{
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $_SESSION['loggedIn'] = true;
      echo 1;				// true back to javascript
    }
    /* close it up */
    $mysqli->close();
  }
}




 ?>
