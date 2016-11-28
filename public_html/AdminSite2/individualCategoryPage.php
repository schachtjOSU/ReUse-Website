<!-- Page you are currently taken to by clicking one of the businesses
in allCategoriesPage.php -->

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="css/individualCategoryPage.css">
      <?php
         if(isset($_POST['id']) && !empty($_POST['id'])) {
           $id = $_POST['id'];
           echo "Hypothetical page for category with category_id " . $id;
           echo "<input type='hidden' id='idInput' value='" . $id . "'>";
           include("components/largeDraggable.php");
         }
         ?>
   </head>
   <body>
      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="js/individualCategoryPage.js"></script>
   </body>
</html>
