<?php
  /**********************************************************************
  *          Session set up
  **********************************************************************/

  /* error check */
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  /* start session */
  ini_set('session.save_path', '/nfs/stak/students/m/masseyta/session');
  session_start();


  /***********************************************************************
  *           Database setup to 
  ***********************************************************************/
  $mysqli = new mysqli("oniddb.cws.oregonstate.edu", "masseyta-db", "ov00iqgNNd5KBsCZ", "masseyta-db");
  if($mysqli->connect_errno){
    echo "ERROR : Connection failed: (".$mysqli->connect_errno.")".$mysqli->connect_error;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Corvallis Reuse and Repair Directory: Web Portal</title>
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/customStylesheet.css" rel="stylesheet">
  <link href="css/media.css" rel="stylesheet">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Rubik:700' rel='stylesheet' type='text/css'>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>

/************************************************************************
*         Check Session on body load
************************************************************************/
function searchBusiness(){
    $('#table').empty();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business",
    dataType: 'json',
    success: function(data){
        var match = $('#searchName').val();
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
         if(data[i].name == match){
            row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + '<a href="editBusiness.php"><button id=edit>Edit</button></a>' + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
         }
        }
        $('#table').append(row);
    },
  });
}

function delItem(){
    var match = $('#delete').val();
    $.ajax({type:"DELETE",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business/" + match,
    dataType: 'json',
    success: function(data){
    }
  });
searchBusiness();
}

function checkSession(){

    req = new XMLHttpRequest();
    req.onreadystatechange = function(){
     if(req.readyState == 4 && req.status == 200){

        if(req.responseText == 1){
          /* everything has passed! Yay! Go into your session */
          window.alert("You are not logged in! You will be redirected.");
          window.location.href = "http://web.engr.oregonstate.edu/~masseyta/testApi/loginPage.php";
        }
      }
    }

    /* send data to create table */
    req.open("POST","checkSession.php", true);
    req.send();
}
</script>
  </head>
  <body onload="checkSession()">

  <!-- Import Nav bar -->
  <?php include("nav.php"); ?>

  <!-- Main container -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <br></br>
        <h3>Search for a Business to Edit or Delete</h3>
        <hr></hr>
        <form class="form-horizontal" role="form">
        <div class="form-group">
           <label class="control-label col-sm-2" for="text">Business Name: </label>
           <div class="col-sm-10">
            <input type ="text" class="form-control" Id="searchName" placeholder="Enter Business Name">
            </div>
        </div> <!-- end formground-->

        <p align="center">
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="searchBusiness(); return false" align="center">Search for Business</button>
        </p>
        </form>

        <!-- Table is created when button is hit -->
        <div id="tableHere">
          <table class="table table-striped" id="table"></table>
        </div>
    
    </div>
    <hr></hr>
    <!-- Hidden row for displaying login errors -->
    <div class="row">
      <div class="col-xs-12 cold-md-8" Id= "output"></div>
    </div class="row"><!-- end inner row -->
  </div> <!-- end row -->
  </div> <!-- end container-->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>