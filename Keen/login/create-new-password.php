<?php
$title = "Log In";

include("./../includes/header-new.php");
$errors = isset($_GET['errors']) ? explode(",", $_GET['errors']) : []; // Initialize errors array

?>

<div class="container col-4 mx-auto">
    <h2>Reset Password</h2>
    <p class="my-4">You can now enter your new password.</p>
    
    <?php 
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if (!empty($selector) || !empty($validator)) {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) { ?>

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

            <!-- form -->
            <form action="./functions/reset-password.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <div class="form-group mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="repeat_password" class="form-label">Repeat New Password</label>
                    <input type="password" id="repeat_password" name="repeat_password" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="create-password-submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        <?php
        }
    } else {
        $errors[] = "Link does not work. Please retry resetting your password.";
    }

    ?>
</div>