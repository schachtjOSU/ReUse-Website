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
var y;
var x;
var z;
var a;
var b;
var d;
var e;
var f;
var g;

function searchBusiness(){
    $('#table').empty();
    var match = $('#searchName').val();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business/" + match,
    dataType: 'json',
    success: function(data){
        // var match = $('#searchName').val();
        console.log(match);
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Address' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
            row += '<tr><td>' + data[i].name + '</td><td>' + data[i].address_line_1 + '</td><td>' + '<a href="editBusiness.php"><button id=edit>Edit</button></a>' + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
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

function editBusiness(){
    var c = $('#edit').val();
    x = c;
      $.ajax({type:"GET",
        url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business",
        dataType: 'json',
        success: function(data){
            var cat = "<select class='form-control' name='selectState' id='states' onChange='changeCat(this.value)'><option>Select Business</option>";
            for(var i = 0; i < data.length; i++){ 
              cat += "<option value = " + data[i].id + ">";
              cat += data[i].name;
              cat += "</option>";
            }
            cat += "</select>";
            $("#EditData1").append(cat);
            formdata = '</div></div><p align="center"><button Id ="submit" type ="submit" class="btn btn-primary" onclick="changeItem(); return false" align="center">Update Item</button></p>';
            formdata += '</form>';
            $('#EditData2').append(formdata);
        }
    });

    $.ajax({type:"GET",
        url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business/" + c,
        dataType: 'json',
        success: function(data){
          console.log("In success");
          $('#table').empty();
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<label class="control-label col-sm-2" for="text">' + 'Edit Information:' + '</label>';
          d += '<div class="col-sm-10">';
          d += '<input type ="text" class="form-control" Id="searchName" placeholder=' + 'Current:' + data[0].name + ' onChange="changeName(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchAdd" placeholder=' + 'Current:' + data[0].address_line_1 + ' onChange="changeAdd(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchAdd2" placeholder=' + 'Current:' + data[0].address_line_2 + ' onChange="changeName(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchCity" placeholder=' + 'Current:' + data[0].city + ' onChange="changeName(this.value)">';       
          $('#EditData').append(d);
        }
      });

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
            $("#EditData").append(states);
        },
      });


    $.ajax({type:"GET",
        url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/business/" + c,
        dataType: 'json',
        success: function(data){
          console.log("In success");
          $('#table').empty();
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<div class="col-sm-10">';
          d += '<input type ="text" class="form-control" Id="searchPhone" placeholder=' + 'Current:' + data[0].phone + ' onChange="changeName(this.value)">';
          d += '<input type ="text" class="form-control" Id="searchWebsite" placeholder=' + 'Current:' + data[0].website + ' onChange="changeAdd(this.value)">';
          $('#EditData').append(d);
        }
      });

}

function changeName(value) {
      y = value;
}

function changeAdd(value) {
      z = value;
}

function changeAdd1(value) {
      a = value;
}

function changeCity(vaue) {
      b = value;
}

function changeState(value) {
      d = value;
}

function changeZip(value) {
      e = value;
}

function changePhone(value) {
      f = value;
}

function changeWebsite(value) {
      g = value;
}
function changeItem(){

       var tableData = "name="+y+"&oldName="+x+"&add1="+z+"&add2="+a+"&city="+b+"&state="+d+"&zip="+e+"&phone="+f+"&website="+g;
        $.ajax({type:"POST",
            url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/changeBusiness",
            data: tableData,
            success: function(){
              $('#form1').empty();
              $('#table').empty();
            },
        });
      $('#EditData').empty();
      $('#EditData1').empty();
      $('#EditData2').empty();
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