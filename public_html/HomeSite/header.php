<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<!-- Google-hosted Jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="../js/headerFunct.js" type="text/javascript"></script>
		
	</head>
	<body>
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation" class="dropdown"><a href="category.php?name=Repair%20Items" class="dropbtn">Repair <span class="caret"></span></a> 
						<div class="dropdown-content" id="header-repair-links">
						</div>
					</li>
					<li role="presentation" class="dropdown"><a href="category.php" class="dropbtn">Reuse <span class="caret"></span></a>
						<div class="dropdown-content" id="header-reuse-links">
						</div>
					</li>
					<li role="presentation" class="dropdown"><a href="recycle.php" class="dropbtn">Recycle <span class="caret"></span></a>
						<div class="dropdown-content" id="header-recycle-links">
						</div>
					</li>
					<li role="presentation"><a href="about.php">About</a></li>
					<li role="presentation"><a href="contact.php">Contact</a></li>
					<li role="presentation"><a href="../AdminSite/loginPage.php">Admin</a></li>
				</ul>
				<a href ="home.php">
					<img id="header-icon" src="../img/CSCLogo.png">
					<h3 class="text-muted" id="header-title">The Corvallis Reuse and Repair Directory</h3>
				</a>
			</nav>
		</div>
		<script>
			addRepairLinks();
			addReuseLinks();
			addRecycleLinks();
		</script>
	</body>
</html>