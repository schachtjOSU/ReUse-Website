<!-- Page you are currently taken to by clicking one of the businesses
in allBusinessesPage.php -->

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="css/singleBusinessPage.css">
      <link type="text/css" rel="stylesheet" href="components/img-comp-img/foundation-icons/foundation-icons.css">
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
            <!-- <span class="fi-trash"></span> less asthetic-->
          </span>
          <span class="garbage active" data-toggle="grid">
            <span class="entypo-ccw"></span>
            <!-- <span class="fi-refresh"></span>less asthetic -->
          </span>

          <span class="fontawesome-edit" data-toggle="edit"></span>
            <!-- <span class="fi-page-edit"></span> less ashtetic but
          if any of these icons stop working, the fi-icons will still work
          on this page. -->

           <?php include("components/gridComponent.php"); ?>
        </div>

      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="js/singleBusinessPage.js"></script>
   </body>
</html>
