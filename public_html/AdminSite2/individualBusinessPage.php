<!-- Page you are currently taken to by clicking one of the businesses
in allBusinessesPage.php -->

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="css/individualBusinessPage.css">
      <link href="bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
      <?php

         if(isset($_POST['id']) && !empty($_POST['id'])) {
           $id = $_POST['id'];
           echo "Hypothetical page for business with id " . $id;
           echo "<input type='hidden' id='idInput' value='" . $id . "'>";
           include("components/largeDraggable.php");
         }
         ?>
         <div class="container" style="padding: 4em">
            <?php include("components/gridComponent.php"); ?>
         </div>
   </head>
   <body>
      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="js/individualBusinessPage.js"></script>
      <script src="bootstrap-editable/js/bootstrap-editable.js"></script>

   </body>
</html>
