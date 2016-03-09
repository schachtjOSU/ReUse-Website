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
var z;

function searchItem(){
    $('#table').empty();
    $.ajax({type:"GET",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/items",
    dataType: 'json',
    success: function(data){
        var match = $('#searchName').val();
        x = match;
        var row = '<tr><th>' + 'Name' + '</th><th>' + 'Modify' + '</th><th>' + 'Delete' + '</th></tr>';
        for(var i = 0; i < data.length; i++){ 
         if(data[i].name == match){
            row += '<tr><td>' + data[i].name + '</td><td>' + '<input type= hidden id= edit value=' + data[i].id + '><input type= submit value=Edit id=edit onclick=editItem()>'  + '</td><td>' + '<input type= hidden id= delete value=' + data[i].id + '><input type= submit value=Delete id=del onclick=delItem()>' + '</td></tr>';
         }
        }
        $('#table').append(row);
    },
  });
}

function delItem(){
    var match = $('#delete').val();
    $.ajax({type:"DELETE",
    url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/item/" + match,
    dataType: 'json',
    success: function(data){
    }
  });
    $('#EditData').empty();
    $('#EditData1').empty();
    $('#EditData2').empty();
    document.getElementById("edItem").reset();  
    searchItem();
}

function editItem(){
    $('#EditData').empty();
    $('#EditData1').empty();
    $('#EditData2').empty();
    document.getElementById("edItem").reset();   
    var c = $('#edit').val();

      $.ajax({type:"GET",
        url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/category",
        dataType: 'json',
        success: function(data){
            var cat = "<div class='col-sm-10'><select class='form-control' name='selectState' id='states' onChange='changeCat(this.value)'><option>Select Category</option>";
            for(var i = 0; i < data.length; i++){ 
              cat += "<option value = " + data[i].id + ">";
              cat += data[i].name;
              cat += "</option>";
            }
            cat += "</select>";
            $("#EditData1").append(cat);
            formdata = '</div></div></div></br><p align="center"><button Id ="submit" type ="submit" class="btn btn-primary" onclick="changeItem(); return false" align="center">Update Item</button></div></p>';
            formdata += '</form>';
            $('#EditData2').append(formdata);
        }
    });

    $.ajax({type:"GET",
        url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/items/" + c,
        dataType: 'json',
        success: function(data){
          console.log("In success");
          $('#table').empty();
          var d= '<form class="form-horizontal" role="form" action="#" id="form1">';
          d += '<div class="form-group">';
          d += '<div class="col-sm-10">';
          d += '<label class="control-label col-sm-2" for="text">' + 'Edit Information:' + '</label>';
          d += '<div class="col-sm-10">';
          d += '<input type ="text" class="form-control" Id="searchName" placeholder=' + 'Current:' + data[0].name + ' onChange="changeName(this.value)">';
          $('#EditData').append(d);

        }
      });

}

function changeName(value) {
      y = value;
}

function changeCat(value) {
      z = value;
}

function changeItem(){

       var tableData = "name="+y+"&oldName="+x+"&cat="+z;
        $.ajax({type:"POST",
            url: "http://web.engr.oregonstate.edu/~masseyta/testApi" + "/index/changeItem",
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
        <h3>Search for an Item to Edit or Delete</h3>
        <hr></hr>
        <form class="form-horizontal" role="form" id="edItem">
        <div class="form-group">
           <label class="control-label col-sm-2" for="text">Item name: </label>
           <div class="col-sm-10">
            <input type ="text" class="form-control" Id="searchName" placeholder="Enter Item Name">
            </div>
        </div> <!-- end formground-->

        <p align="center">
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="searchItem(); return false" align="center">Search for Item</button>
        </p>
        </form>
        
        <!-- Table is created when button is hit -->
        <div id="tableHere">
          <table class="table table-striped" id="table"></table>
        </div>
    
    </div>
    <hr></hr>
    <div class="row">
      <div class="col-xs-12 cold-md-8" Id= "EditData"></div>
      <div class="col-xs-12 cold-md-8" Id= "EditData1"></div>
      <div class="col-xs-12 cold-md-8" Id= "EditData2"></div>
    </div class="row"><!-- end inner row -->
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