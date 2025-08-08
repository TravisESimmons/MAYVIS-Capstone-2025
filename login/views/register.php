<?php
$title = "Register";

include("./../includes/header-new.php");
?>

<?php
         
?>


<!-- register form -->
<div class="container col-md-4 mx-auto">
    <h2 class="mb-4 fw-light">Register</h2>
    <?php
    // Check if $registration is set and has errors or messages
    if (isset($registration) && ($registration->errors || $registration->messages)) : ?>
        <div class="alert alert-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle mr-2" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
            </svg>
            <?php
            // Display errors or messages
            if ($registration->errors) {
                foreach ($registration->errors as $error) {
                    echo $error;
                }
            }
            if ($registration->messages) {
                foreach ($registration->messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
    <?php endif; ?>
    <form method="post" action="register.php" name="registerform" class="loginForm">

        <div class="row">
            <!-- the first name input field uses a HTML5 pattern check -->
            <div class="form-group col-6">
                <label for="login_input_firstname" class="form-label">First Name</label>
                <input id="login_input_firstname" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
            </div>
            <!-- the ;ast name input field uses a HTML5 pattern check -->
            <div class="form-group col-6">
                <label for="login_input_lasttname" class="form-label">Last Name</label>
                <input id="login_input_lastname" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
            </div>
        </div>
        <!-- the user name input field uses a HTML5 pattern check -->
        <div class="form-group">
            <label for="login_input_username" class="form-label">Username (only letters and numbers, 2 to 64
                characters)</label>
            <input id="login_input_username" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
        </div>
        <!-- the email input field uses a HTML5 email type check -->
        <div class="form-group">
            <label for="login_input_email" class="form-label">User's email</label>
            <input id="login_input_email" class="login_input form-control" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
        </div>
        <div class="form-group">
            <label for="login_input_password_new" class="form-label">Password (min. 6 characters)</label>

            <input id="login_input_password_new" class="login_input form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class="form-group">

            <label for="login_input_password_repeat" class="form-label">Repeat password</label>
            <input id="login_input_password_repeat" class="login_input form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class="form-group d-flex flex-column justify-content-center mx-auto">
            <input type="submit" name="register" value="Register" class="btn btn-primary">
            <a href="index.php" class="register mt-3 text-light text-center">Back to Login Page</a>

        </div>


    </form>
</div>


<?php
include("./../includes/footer.php");
?>