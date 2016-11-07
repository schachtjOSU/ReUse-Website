<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../img/CSCLogo.png">
		<title>Business - The Corvallis Reuse and Repair Directory</title>

		<!-- Bootstrap core CSS -->
		<link href="../Css/bootstrap.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="../Css/jumbotron-narrow.css" rel="stylesheet">
		<!-- Generic Reuse public site styling css -->
		<link href="../Css/publicSite.css" rel="stylesheet">
		<!-- Generic map styling css -->
		<link href="../Css/map.css" rel="stylesheet">
	</head>

    <body>
		<div class="container">
			<?php
				include 'header.php';
			?>
			<div class="business-container">
				<div class="business-info-container">
				</div>
				
				<div class="business-map-container">
					<div id="map"></div>
				</div>
			</div>
			
			<?php 
				include 'footer.php';
			?>
		</div> <!-- /container -->
		<!-- Map JS -->
		<script src="../js/mapFunct.js" type="text/javascript"></script>
		<script type="text/javascript">

			function initBusinessMapWrapper() {
				var busName = encodeURI("<?php if(isset($_REQUEST['name'])) {echo $_REQUEST['name'];}?>");
				//console.log(busName);
				if(busName != "") {
					initBusinessMap(busName);
				}
				
			}
			
		</script>
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiF8JALjnfAymACLHqPAhlrLlUj3y9DTo&callback=initBusinessMapWrapper">
		</script>
    </body>
</html>
