<?php
$title = "Login";
include_once('header-2.php');
include('includes/login.inc.php');
?>

<div class="loginbox box-shadow bg-tertiary">
    <img src="img/fingerprint.png" class="avatar" alt="">
    <div class="display-6">Employee Login</div>
    <form method="post" class="form" enctype="multipart/form-data">
        <div class="form-group row justify-content-md-center">
            <div class="col-sm-12 pb-3">
                <input type="text" class="form-control floating_input" name="username" id="username" autocomplete="off" tabindex="1" placeholder="Username" value="<?php echo !empty($postData['username']) ? $postData['username'] : ''; ?>" autofocus>
                <label for="Username" class="floating_label" data-content="Username">
                <span class="hidden--visually">Username</span></label>
            </div>

            <div class="col-sm-12 pb-3">
                <input type="password" class="form-control floating_input" name="password" id="password" autocomplete="off" tabindex="2" placeholder="Password" value="<?php echo !empty($postData['password']) ? $postData['password'] : ''; ?>">
                <label for="password" class="floating_label" data-content="Password">
                <span class="hidden--visually">Password</span></label>
            </div>
        </div>
        <!-- Display submission status -->
        <div class="status">
            <?php if (!empty($statusMsg)) { ?>
                <p class="statusMsg <?php echo !empty($msgClass) ? $msgClass : ''; ?>">
                    <?php echo $statusMsg; ?>
                </p>
            <?php } ?>
        </div>
        <div>
            <button type="submit" name="login_btn" class="btn btn-primary btn-block form-control-2" tabindex="9" >Login</button>
        </div>
        <div class="col-sm-12 text-center py-3 small">Don't have an account yet? <a class="text-primary font-italic" href="register.php">Register</a></div>
    </form>
</div>