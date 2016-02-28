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
  <script src="js/jquery.multi-select.js" type="text/javascript"></script>
  <script>
  var x;

  //ONLOAD -- GET requests and checking of session with jQuery
  $(document).ready(function(){
    function displayStates(){
      $.ajax({type:"GET",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/states",
      dataType: 'json',
      success: function(data){
          var states = "<select class='form-control' name='selectState' id='states'><option>Select State</option>";
          for(var i = 0; i < data.length; i++){ 
            states += "<option value = " + data[i].id + ">";
            states += data[i].name;
            states += "</option>";
          }
          states += "</select>";
          $("#state").html(states);
      },
    });
  }

  displayStates();
  checkSession();
});

  /************************************************************************
  *         Check Session on body load
  ************************************************************************/

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

function addNewBusiness(){

  /* get values from form */
  var name = document.getElementById("name").value;
  var address = document.getElementById("address").value;
  var address2 = document.getElementById('address2').value;
  var city = document.getElementById("city").value;
  var state = document.getElementById("states").value;
  var zipcode = document.getElementById("zipcode").value;
  var phone = document.getElementById("phone").value;
  var website = document.getElementById("website").value;
  var type = "add";
  x = name;
  console.log(x);
  console.log(name);


  /* check for blanks in the form */
  if(isNaN(zipcode)){
    document.getElementById("output2").innerHTML ="Zipcode input should be numeric.";
    document.getElementById("addBusiness").reset();
    return;
  }
  if(name == null){
    document.getElementById("output2").innerHTML ="Must, at minimum, contain a name";
    document.getElementById("addBusiness").reset();
    return;
  }
  else{

    var tableData = "type="+type+"&name="+name+"&address="+address+"&address2="+address2+"&city="+city+"&state="+state+"&phone="+phone+"&zipcode="+zipcode+"&website="+website;

    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business",
      data: tableData,
      success: function(data){
        displayTable();
      },
    });
  }
}


function displayTable(){
  $('#table').empty();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/items",
    dataType: 'json',
    success: function(data){
        var entry = '<label>Accepts Following Items: </label>';
        $('#tableHere').append(entry);
        var row = '<tr><th>' + 'Name' + '</th><th>'  + 'Business Accepts Following Items' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= update1 value=' + data[i].id + '><input type= submit value=update id=update onclick=updateItem()>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}


function updateItem(){

  var name = x;
  console.log(name);
  var item = document.getElementById("update1").value;
  console.log(item);
  var tableData = "name="+name+"&items="+item;

    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/updateBusiness",
      data: tableData,
      success: function(data){
        displayTable();
      },
    });
  }  

</script>
  </head>
  <body>

  <!-- Import Nav bar -->
  <?php include("nav.php"); ?>

  <!-- Main container -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <br></br>
        <h3>Add a New Business</h3>
        <hr></hr>

       <form id="addBusiness">
        <div class="form-group">
           <label>Business Name: </label>
           <input type ="text" class="form-control" Id="name" placeholder="Enter Business Name">
        </div> <!-- end formground-->
        <div class="form-group">
            <label>Address: </label>
            <input type ="text" class="form-control" Id ="address" placeholder="Enter Business Address">
        </div><!-- end formgroup -->
        <div class="form-group">
            <label>Address: </label>
            <input type ="text" class="form-control" Id ="address2" placeholder="Enter Business Address">
        </div><!-- end formgroup -->
        <div class="form-group">
            <label>City: </label>
            <input type ="text" class="form-control" Id ="city" placeholder="Enter City">
        </div><!-- end formgroup -->
        <div class="form-group">
          <label>State: </label>
          <div id="state"></div>
        </div><!-- end formgroup -->
        <div class="form-group">
            <label>Zipcode: </label>
            <input type ="text" class="form-control" Id ="zipcode" placeholder="Enter numeric zipcode">
        </div><!-- end formgroup -->
        <div class="form-group">
            <label>Phone Number: </label>
            <input type ="text" class="form-control" Id ="phone" placeholder="Enter Phone Number">
        </div><!-- end formgroup -->
        <div class="form-group">
            <label>Website: </label>
            <input type ="url" class="form-control" Id ="website" placeholder="Enter Website Address">
        </div><!-- end formgroup -->
        <p align="center">
        </br>
          <!-- Send information to loginCheck function for error handling and ajax call if wrong -->
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="addNewBusiness(); return false" align="center">Add Business</button>
        </p>
        </form>
        <hr></hr>
        <div class="form-group">
        <div>
          <p id="tableHere">
            <table class="table table-striped" id="table"></table>
          </p>
        </div>
        </div><!-- end formgroup -->
        <!-- Hidden row for displaying login errors -->
        <div class="row">
          <div class="col-xs-12 cold-md-8" Id= "output2"></div>
        </div class="row"><!-- end inner row -->
  </div> <!-- end container-->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>