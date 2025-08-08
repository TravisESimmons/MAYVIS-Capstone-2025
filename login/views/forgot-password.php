<?php

$title = "Log In";

include("./../includes/header-new.php");

?>

<div class="container col-4 mx-auto">
    <h2>Forgot Password</h2>
    <p class="my-4 col-4">Enter your email address below to recieve a link to reset your password.</p>
    <form method="post" action="send-reset-link.php" name="reset-password-email-form">
    <div class="form-group mb-3">
        <label for="user_email" class="form-label">Email Address</label>
        <input type="email" id="user_email">
    </div>
    </form>
</div>