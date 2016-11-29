<!-- Page you are currently taken to by clicking one of the businesses
in allBusinessesPage.php -->

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="css/singleItemPage.css">
   </head>
   <body>
     <?php
        if(isset($_POST['id']) && !empty($_POST['id'])) {
          $id = $_POST['id'];
          echo "<input type='hidden' id='idInput' value='" . $id . "'>";
          include("components/largeDraggable.php");
        }
        ?>

        <div class="container" style="padding: 4em">
          <span class="garbage" data-toggle="list">
            <span class="maki-trash"></span>
          </span>
          <span class="garbage active" data-toggle="grid">
            <span class="entypo-ccw"></span>
          </span>

           <?php include("components/gridComponent.php"); ?>
        </div>

      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="js/singleItemPage.js"></script>
   </body>
</html>
