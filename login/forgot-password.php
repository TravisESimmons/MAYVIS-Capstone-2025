<?php
$title = "Log In";

include("./../includes/header-new.php");
$errors = isset($_GET['errors']) ? explode(",", $_GET['errors']) : []; // Initialize errors array

?>

<div class="container col-4 mx-auto">
    <h2>Forgot Password</h2>
    <p class="my-4">Enter your email address below to receive a link to reset your password.</p>
    <?php 
    if (count($errors) > 0): 
    ?>
        <div class="alert alert-warning">
            <?php 
            foreach ($errors as $error):  ?>
                <p><?php echo $error ?></p>
                <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="./functions/send-reset-link.php" name="reset-password-email-form">
        <div class="form-group mb-3">
            <label for="user_email" class="form-label">Email Address</label>
            <input type="email" id="user_email" name="user_email" class="form-control">
        </div>
        <div class="form-group mb-3">
            <button type="submit" name="password_reset_link" class="btn btn-primary">Send Reset Link</button>
        </div>
    </form>
    <?php 
    if (isset($_GET["reset"])) {
    if ($_GET["reset"] == "success") {
        echo "<p class=\"mt-4\">Please check your email address for the link to reset your password.</p>"; 
    }
}
?>

</div>