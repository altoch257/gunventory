<?php
    // Start Session 
    session_start();

    // Destroy session
    session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Redirect to another page after x secs -->
    <meta http-equiv="refresh" content="5; URL=http://localhost/gunventory">

	<title>ProSfaffers | Home</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	
	<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">

	<!-- Toaster -->
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="warningbox box-shadow">
        <h1>Goodbye!</h1>
        <p>
            You have been successfully logged out of the system.
        </p>
        <p class="pt-2"> You will be redirected in 5 seconds. 
            if the page has not refreshed in 5 seconds, click <a class="text-secondary" href="index.php">here</a>
        </p>
    </div>
</body>
</html>