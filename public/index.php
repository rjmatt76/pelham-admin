<?php require_once('../includes/site_header.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Pelham Lane Vegetable Management</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="pelham,farm" />
	<meta name="description" content="Pelham Lane Farm" />
	<meta name="author" content="Robert Mattern" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/pelhamlane.css" rel="stylesheet" type="text/css" />	
	<link href="css/pelhamlaneform.css" rel="stylesheet" type="text/css" />	
	<script src="js/pelham.js"></script>
</head>
<body>
<div class="menu">
	<?php include("../includes/topmenu.php"); ?>
</div> <!-- END menu -->

<div id="topwrapper">
	<div id="logo">
		<h1>Pelham Lane Farm</h1>
		<h2>Vegetable Management - Your IP address: <?php echo $_SERVER['REMOTE_ADDR']; ?></h2>
	</div> <!-- END logo -->
</div>
	<?php include("../includes/sidebar.php"); ?>
	<div id="content" class="col-8">
		<?php
		if(isset($_GET['harvestrecords']))
		{
			include('../includes/HarvestRecords.php');
		} 
		else if(isset($_GET['seedlist']))
		{
			include('../includes/SeedList.php');
		} 
		// in all other cases include the home page
		else 
		{
			include('../includes/home.php');
		}
		?>
	<!-- End Content -->
	</div>
	<!-- End Page -->
	<div style="clear: both">
	</div> 
</div> <!-- END top wrapper -->
<div id="footer"> 
	<p>Copyright &copy; 2019</p>
</div>	
</body>
</html>
