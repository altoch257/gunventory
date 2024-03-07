	<!-- Start Socket -->
	<div class="socket">
		<div class="container footer-text">
			<div class="row justify-content-center pt-3">
				<div class="col-md-auto">
					<div class="justify-content-end">
						&copy; <?php echo date("Y"); ?> <a href=".">Gunventory</a>. All Rights Reserved.
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-auto">
					<div class="small-text">
						<a href="terms-of-service.php">Terms of Service</a> | <a href="faqs.php">FAQ's</a> | <a href="privacy.php">Privacy Policy | <a href="terms-of-use.php">Term Of Use</a></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Socket -->

	<!-- Format phone number field -->
	<script>
		function formatPhoneNumber(value) {
			if (!value) return value;
			const phoneNumber = value.replace(/[^\d]/g, '');
			const phoneNumberLength = phoneNumber.length;
			if (phoneNumberLength < 4) return phoneNumber;
			if (phoneNumberLength < 7) {
				return `(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(3)}`;
			}
			return `(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(
				3,
				6
			)}-${phoneNumber.slice(6, 10)}`;
		}

		function phoneNumberFormatter() {
			const inputField = document.getElementById('phone');
			const formattedInputValue = formatPhoneNumber(inputField.value);
			inputField.value = formattedInputValue;
		}
	</script>
	
	<!-- Script Source Files -->
	<!-- jQuery -->
	<script src="js/jquery-3.5.1.min.js"></script>
	<!-- Bootstrap 4.5 JS -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Popper JS -->
	<script src="js/popper.min.js"></script>
	<!-- Font Awesome -->
	<script src="js/all.min.js"></script>
	<!-- End Script Source Files -->


	<!-- TinyMCE -->
	<script src="plugins/tinymce/tinymce.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>