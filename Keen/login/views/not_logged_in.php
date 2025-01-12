<?php

$title = "Log In";

include("./../includes/header-new.php");
                   
?>

<!-- login form box -->
<div class="container col-md-4 mx-auto">
    <h2 class="mb-4 fw-light">Log In</h2>
    <?php
    // Check if $login is set and has errors or messages
    if (isset($login) && ($login->errors || $login->messages || isset($_SESSION['registration_success']))) : ?>
        <div class="alert alert-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle mr-2" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
            </svg>
            <?php
            // Display errors or messages
            if ($login->errors) {
                foreach ($login->errors as $error) {
                    echo $error;
                }
            }
            if ($login->messages) {
                foreach ($login->messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php" name="loginform" class="login_form">
        <div class="form-group mb-3">
            <label for="login_input_username" class="form-label">Username or Email Address</label>
            <input id="login_input_username" class="login_input form-control" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : ''; ?>" required />
        </div>
        <div class="form-group mb-4">
            <label for="login_input_password" class="form-label">Password</label>
            <input id="login_input_password" class="login_input form-control mb-4" type="password" name="user_password" autocomplete="off" required />
            <a href="./forgot-password.php" class="mt-4">Forgot Password?</a>
        </div>
        <div class="d-flex flex-column mx-auto">
            <input type="submit" name="login" value="Log in" class="btn btn-primary" />
            <a href="register.php" class="register text-white text-center mt-4">Register for a New Account</a>
        </div>

    </form>

</div>