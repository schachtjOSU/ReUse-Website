<?php
  /**********************************************************************
  *          Session set up
  **********************************************************************/

  /* error check */
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  /* start session */
  session_start();


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
var x;

  $(document).ready(function(){
    function displayStates(){
      $.ajax({type:"GET",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category",
      dataType: 'json',
      success: function(data){
          var c = "<select class='form-control' name='selectCat' id='categories'><option>Select Item Category</option>";
          for(var i = 0; i < data.length; i++){ 
            c += "<option value = " + data[i].id + ">";
            c += data[i].name;
            c += "</option>";
          }
          c += "</select>";
          $("#cat").html(c);
      },
    });
  }
  displayStates();
  checkSession();
});


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

function addNewItem(){

  console.log("In function");

  /* get values from form */
  var name = document.getElementById("name").value;
  var type = "addItem";
  x = name;
  var flag = 0;
  var cat = 15;

  /* check for blanks in the form */
  if(name == null){
    document.getElementById("output2").innerHTML ="Please enter a valid business name.\n";
    document.getElementById("addItem").reset();
    return;
  }
  else{
    var tableData = "type="+type+"&name="+name+"&cat="+cat;
    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/items",
      data: tableData,
      success: function(data){
        console.log("in success");
        displayTable();
      },
    });
  }
}

function displayTable(){
  $('#table').empty();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category",
    dataType: 'json',
    success: function(data){
        var row = '<tr><th>' + 'Name' + '</th><th>'  + 'Add to Category' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= update1 value=' + data[i].id + '><input type= submit value=update id=update onclick=updateItem('+ data[i].id +')>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}


function updateItem(value){

  var name = x;
  console.log(name);
  var category = value;
  console.log(category);
  var tableData = "name="+name+"&category="+category;

    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/updateItems",
      data: tableData,
      success: function(data){
        $('#table').empty();
      },
    });
    $('#table').empty();
    document.getElementById("addItem").reset();
    document.getElementById("output2").innerHTML ="Successfully added to the database.\n";
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
        <h3>Add a New Item</h3>
        <hr></hr>

       <form id="addItem">
        <div class="form-group">
           <label>Item Name: </label>
           <input type ="text" class="form-control" Id="name" placeholder="Enter Item Name">
        </div> <!-- end formground-->

        <p align="center">
        </br>
          <!-- Send information to loginCheck function for error handling and ajax call if wrong -->
          <button Id ="submit" type="submit" class="btn btn-primary" onclick="addNewItem(); return false" align="center">Add Item</button>
        </p>
        </form>
        <hr></hr>
        <div id="tableHere">
          <table class="table table-striped" id="table"></table>
        </div>
        <!-- Hidden row for displaying login errors -->
        <div class="row">
          <div class="col-xs-12 cold-md-8" Id= "output2"></div>
        </div class="row"><!-- end inner row -->
  </div> <!-- end container-->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>