<?php 
	$title = "Home";
	
	include_once 'header.php';
?>
<div class="my-5"></div>
	<div class="container">
		<div class="d-flex align-self-center" style="height: calc(100vh - 75px);">
		<div class="row">
			<div class="col-6 col-md-4 d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/handgun.png" alt="" width="50px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Firearm</h5>
						<a href="add-firearm.php" class="stretched-link"></a>
					</div>
				</div>
			</div>

			<div class="col-6 col-md-4 d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/ammo.png" alt="" width="50px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Ammo</h5>
						<a href="add-ammo.php" class="stretched-link"></a>
					</div>
				</div>
			</div>	

			<div class="col-6 col-md-4 d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/accessory.png" alt="" width="120px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Accessory</h5>
						<a href="add-accessory.php" class="stretched-link"></a>
					</div>
				</div>
			</div>	

			<div class="col-6 col-md-4 d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/shooting.png" alt="" width="40px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Shooting</h5>
						<a href="add-shooting.php" class="stretched-link"></a>
					</div>
				</div>
			</div>	

			<div class="col-6 col-md-4 d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/maintenance.png" alt="" width="22px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Maintenance</h5>
						<a href="add-maintenance.php" class="stretched-link"></a>
					</div>
				</div>
			</div>	

			<div class="col-6 col-md-4  d-flex justify-content-center">
				<div class="card mb-5 p-1" style="width: 15rem; height: 10rem;">
					<i class="bi bi-plus-square"></i>
					<div class="card-body">
						<div class="text-center mb-2">
							<img src="img/malfunction.png" alt="" width="40px">
						</div>
						<h5 class="card-title text-center text-uppercase my-auto">Add Malfunction</h5>
						<a href="add-malfunction.php" class="stretched-link"></a>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php
	include_once 'footer.php';
?>
	