<!-- Page you are currently taken to by clicking one of the businesses
in allBusinessesPage.php -->

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="css/singleItemPage.css">
      <?php
         if(isset($_POST['id']) && !empty($_POST['id'])) {
           $id = $_POST['id'];
           echo "Hypothetical page for business with id " . $id;
           echo "<input type='hidden' id='idInput' value='" . $id . "'>";
           include("components/largeDraggable.php");
         }
         ?>
   </head>
   <body>
      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="js/singleItemPage.js"></script>
   </body>
</html>
