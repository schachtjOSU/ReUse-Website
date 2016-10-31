<?php
$app->get('/', function() use ($app) {
     //echo "HELLO";
     $app->redirect("/HomeSite/HomeSite.html");
});
?>
