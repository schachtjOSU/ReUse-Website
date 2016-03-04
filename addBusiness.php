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
  var x;
  var count = 0;
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
  var flag = 0;
  console.log(x);
  console.log(name);


  /* check for blanks in the form */
  if(address == null){
    document.getElementById("output2").innerHTML ="Please enter a valid business address.\n";
    document.getElementById("addBusiness").reset();
    flag = 1;
  }
  if(city == null){
    document.getElementById("output2").innerHTML ="Please enter a valid city.\n";
    document.getElementById("addBusiness").reset();
    flag = 1;
  }
  if(state == null){
    document.getElementById("output2").innerHTML ="Please enter a state from the drop down.\n";
    document.getElementById("addBusiness").reset();
    flag =1;
  }
  if(phone == null){
    document.getElementById("output2").innerHTML ="Please enter a valid phone number.\n";
    document.getElementById("addBusiness").reset();
    flag = 1;
  }
  if(zipcode == null){
      document.getElementById("output2").innerHTML ="Please enter a valid phone zip code.\n";
      document.getElementById("addBusiness").reset();
    flag = 1;
  }

  /* now check for errors */
  if(isNaN(zipcode)){
      document.getElementById("output2").innerHTML ="Zipcode input should be numeric.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(zipcode.length != 5){
      document.getElementById("output2").innerHTML ="Please enter a valid zip code of 5 digits.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(isNaN(phone)){
      document.getElementById("output2").innerHTML ="Phone input should be numeric, with no special characters. Ex: 5031234566.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(phone.length != 10){
      document.getElementById("output2").innerHTML ="Please enter a valid phone number of 10 digits.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(address.length > 150){
      document.getElementById("output2").innerHTML ="Please enter a valid address, less than 150 characters.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(address.length > 50){
      document.getElementById("output2").innerHTML ="Please enter a valid city, less than 50 characters.\n";
      document.getElementById("addBusiness").reset();
      flag = 1;
  }
  if(flag != 0){
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
      window.alert("Select as many items as you'd like to be added to the Business.");
        var entry = '<input type = button value = DONE id = done onclick=clearAll() style="margin-right: 30px;">'
        entry += '<label>Accepts Following Items: </label>';
        $('#tableHere').append(entry);
        var row = '<tr><th>' + 'Name' + '</th><th>'  + 'Business Accepts Following Items' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= update1 value=' + data[i].id + '><input type= submit value=update id=update onclick=updateItem('+data[i].id+')>' + '</td></tr>';
        }
        $('#table').append(row);
    },
  });
}

function clearAll(){
    $('#table').empty();
    $('#tableHere').empty();
    document.getElementById("addBusiness").reset();
    document.getElementById("output2").innerHTML ="Successfully added to the database.\n";
}

function updateItem(value){

  var name = x;
  console.log(name);
  //var item = document.getElementById("update1").value;
  var item = value;
  console.log(item);
  var tableData = "name="+name+"&items="+item;

    $.ajax({type:"POST",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/updateBusiness",
      data: tableData,
      success: function(data){
        console.log(data);
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
        <div id="doneHere"></div>
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