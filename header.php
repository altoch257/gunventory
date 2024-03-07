<?php
	require('includes/dbh.inc.php');

	session_start();

	function active($currect_page){
		$url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
		$url = end($url_array);  
		
		if($currect_page == $url){
			echo 'active'; //class name in css 
		} 
	}

	// $sqlStr = "SELECT
	// 				TerminalName,
	// 				Phone,
	// 				Street,
	// 				Street2,
	// 				City,
	// 				State,
	// 				Zip
	// 			FROM Terminals
	// 			WHERE Id = 1;";
	
	// $stmt = $db->prepare($sqlStr);
	// $stmt->execute();
	// $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $title; ?> | Gunventory</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	
	<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

	<!-- Toaster -->
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400&display=swap" rel="stylesheet">
</head>
<body>

	<!-- Navigation -->
	<nav class="navbar bg-dark navbar-dark navbar-expand-lg">
		<div class="container">
			<a href="." class="navbar-brand"><img src="img/logo.png" alt="Logo" title="Logo" height="40px"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="." class="nav-link active">Home</a></li>
					<li class="nav-item"><a href="manage-inventory.php" class="nav-link">Add Inventory</a></li>
					<div class="floatr">
						<?php if (isset($_SESSION['user']) && $_SESSION['user']): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
									<?php echo $_SESSION['user']['firstName']; ?>
								</a>
								<div class="dropdown-menu dropdown-menu-right bg-dark">
									<a class="nav-link dropdown-item" href="#"><i class="mdi mdi-small mdi-account-circle-outline pr-2"></i>My Profile</a>
									<a class="nav-link dropdown-item" href="jobs.php"><i class="mdi mdi-small mdi-format-list-bulleted pr-2"></i>Job Listings</a>
									<?php if ($_SESSION['user']['roleId'] == 1) : ?>
										<a class="nav-link dropdown-item" href="admin/index.php"><i class="mdi mdi-small mdi-plus-circle-outline pr-2"></i>Admin Panel</a>
									<?php endif ?>
									<div class="dropdown-divider"></div>
									<a class="nav-link" href="logout.php" style="display: block;"><i class="mdi mdi-small mdi-logout pr-2"></i>Logout</a>
								</div>
							</li>	
						<?php else: ?>
							<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
						<?php endif; ?>
					</div>							
				</ul>
			</div>
		</div>
	</nav>
	<!-- End Navigation -->