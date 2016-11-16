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
  <link href="../Css/bootstrap.css" rel="stylesheet">
  <link href="../Css/customStylesheet.css" rel="stylesheet">
  <link href="../Css/media.css" rel="stylesheet">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Rubik:700' rel='stylesheet' type='text/css'>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="../js/searchBusFunct.js"></script>
<script>
  $(document).ready(function(){
    checkSession();
    allBusinesses();
    $('#editFields').hide();
  });
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
        <h3 id="instructions">Edit or Remove any of the businesses listed below, or search for one!</h3>
        <hr></hr>
        <form class="form-horizontal" role="form" id="busForm1">

        <div class="form-group" id="searchForm">
           <label class="control-label col-sm-2" for="text">Business Name: </label>
           <div class="col-sm-10">
            <input id="searchName" name="searchName" class="form-control" onfocus="this.value = ''" type="text" value="search">

            </div>
        </div> <!-- end formground-->

        <p align="center">
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="searchBusiness(); return false" align="center">Search for Business</button>
        </p>
        <p align="center">
          <button Id ="submit" type ="submit" class="btn btn-primary" onclick="allBusinesses(); return false" align="center">View all Businesses</button>
        </p>
        </form>

<span id="editFields">
  <form>
    <p id="oldName"></p>


  <label for="name">Name of Business</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonName">Was: Whatever name</span>
    <input type="text" class="form-control" id="name" name="name" aria-describedby="basic-addon3">
  </div>

  <label for="add1">Address Line One</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonAddress1">https://example.com/users/</span>
    <input type="text" class="form-control" id="add1" name="add1" aria-describedby="basic-addon3">
  </div>

  <label for="add2">Address Line Two</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonAddress2">https://example.com/users/</span>
    <input type="text" class="form-control" id="add2" name="add2" aria-describedby="basic-addon3">
  </div>

  <label for="city">City</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonCity">https://example.com/users/</span>
    <input type="text" class="form-control" id="city" name="city" aria-describedby="basic-addon3">
  </div>

  <label for="zip">Zipcode</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonZip">https://example.com/users/</span>
    <input type="text" class="form-control" id="zip" name="zip" aria-describedby="basic-addon3">
  </div>

  <label for="phone">Phone</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonPhone">https://example.com/users/</span>
    <input type="text" class="form-control" id="phone" name="phone" aria-describedby="basic-addon3">
  </div>

  <label for="website">Website</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonWebsite">https://example.com/users/</span>
    <input type="text" class="form-control" id="website" name="website" aria-describedby="basic-addon3">
  </div>

  <!-- <label for="State">State</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonState">https://example.com/users/</span>
    <input type="text" class="form-control" id="state" name="state" value="1" aria-describedby="basic-addon3">
  </div> -->
  <input type="hidden" id="stateHidden" name="stateHidden">

  <!-- <input type="hidden" id="oldNameHidden" name="oldNameHidden"> -->

  <label for="statesHere">State</label>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addonStatesHere">https://example.com/users/</span>
    <div id="statesHere"></div>

    <!-- <input type="text" class="form-control" id="state" name="state" value="1" aria-describedby="basic-addon3"> -->
  </div>
  <input type="hidden" id="oldNameHidden" name="oldNameHidden">


<input type="submit" value="save" id="submitChangesButton">

<script type="text/javascript">
    document.getElementById("submitChangesButton").addEventListener("click", saveClicked, false);
</script>
</form>



</span>

        <!-- Table is created when button is hit -->
        <div id="tableHere">
          <table class="table table-striped" id="table"></table>
        </div>

                <!-- edit info -->
        <div id= "EditData"></div>
                <!-- edit info -->
        <div id= "EditData1"></div>
                <!-- edit info -->
        <div id= "EditData2"></div>

    </div>
    <hr></hr>
    <!-- Hidden row for displaying login errors -->
    <div class="row">
      <div class="col-xs-12 cold-md-8" Id= "output"></div>
    </div class="row"><!-- end inner row -->
  </div> <!-- end row -->
  </div> <!-- end container-->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
