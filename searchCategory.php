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
var y;

function searchCategory(){
    $('#table').empty();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category",
    dataType: 'json',
    success: function(data){
        var match = $('#searchName').val();
        x = match;
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
         if(data[i].name == match){
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= edit value=' + data[i].id + '><input type= submit value=Edit id=edit onclick=editCategory()>' + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delCategory()>' + '</td></tr>';
         }
        }
        $('#table').append(row);
        document.getElementById("edCat").reset();
    },
  });
}

function delCategory(){
    var match = $('#delete').val();
    x = match;
    $.ajax({type:"DELETE",
      url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category/" + match,
      dataType: 'json',
      success: function(data){
    }
  });
  $('#EditData').empty();
  document.getElementById("edCat").reset();
  searchCategory();
}

function editCategory(){
    var x = $('#edit').val();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category/" + x,
    dataType: 'json',
    success: function(data){
      $('#table').empty();
      var formdata= '<form class="form-horizontal" role="form" action="#" id="form1">';
      formdata += '<div class="form-group">';
      formdata += '<label class="control-label col-sm-2" for="text">' + 'Edit Information:' + '</label>';
      formdata += '<div class="col-sm-10">';
      formdata += '<input type ="text" class="form-control" Id="searchName" placeholder=' + 'Current:' + data[0].name + ' onChange="changeName(this.value)">';
      formdata += '</div></div><p align="center"><button Id ="submit" type ="submit" class="btn btn-primary" onclick="changeCategory(); return false" align="center">Update Category</button></p>';
      formdata += '</form>';
      $('#EditData').html(formdata);
    }
  });
}

function changeName(value) {

      y = value;
}

function changeCategory(){

  console.log(x);
  console.log(y);
  $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category/" + x,
    dataType: 'json',
    success: function(data){
       var tableData = "name="+y+"&oldName="+x;
        $.ajax({type:"POST",
            url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/changeCategory",
            data: tableData,
            success: function(){
              $('#form1').empty();
              $('#table').empty();
            },
        });
      $('#EditData').empty();
    }
  });
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
        <h3>Search for a Category to Edit or Delete</h3>
        <hr></hr>
        <form class="form-horizontal" role="form" id="edCat">
        <div class="form-group">
           <label class="control-label col-sm-2" for="text">Category name: </label>
           <div class="col-sm-10">
            <input type ="text" class="form-control" Id="searchName" placeholder="Enter Category Name">
            </div>
        </div> <!-- end formground-->

        <p align="center">
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="searchCategory(); return false" align="center">Search for Category</button>
        </p>
        </form>

        <!-- Table is created when button is hit -->
        <div id="tableHere">
          <table class="table table-striped" id="table"></table>
        </div>
      
        <!-- edit info -->
        <div id= "EditData"></div>
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