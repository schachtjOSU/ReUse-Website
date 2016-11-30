<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<!-- Google-hosted Jquery -->
		<script src="../js/jquery-1.11.1.min.js"></script>
		<script src="../js/headerFunct.js" type="text/javascript"></script>

	</head>
	<body>
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation" class="dropdown header-button"><a href="category.php?name=Repair%20Items" class="dropbtn header-link">Repair <span class="caret"></span></a>
						<div class="dropdown-content" id="header-repair-links">
						</div>
					</li>
					<li role="presentation" class="dropdown header-button"><a href="category.php" class="dropbtn header-link">Reuse <span class="caret"></span></a>
						<div class="dropdown-content" id="header-reuse-links">
						</div>
					</li>
					<li role="presentation" class="dropdown header-button"><a href="recycle.php" class="dropbtn header-link">Recycle <span class="caret"></span></a>
						<div class="dropdown-content" id="header-recycle-links">
						</div>
					</li>
					<li role="presentation" class="header-button"><a href="about.php" class="header-link">About</a></li>
					<li role="presentation" class="header-button"><a href="contact.php" class="header-link">Contact</a></li>
					<li role="presentation" class="header-button"><a href="../AdminSite/loginPage.php" class="header-link">Admin</a></li>
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
