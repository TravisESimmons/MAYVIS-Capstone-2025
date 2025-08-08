<?php

include("../../connect.php");

$selector = $_POST["selector"] ?? '';
$validator = $_POST["validator"] ?? '';

$errors = [];

if (isset($_POST["create-password-submit"])){
    // initialize variables
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    // validate: password is not empty, passwords match each other
    if (empty($password) || empty($repeat_password)) {
        $errors[] = "Passwords cannot be empty.";

    } else if ($password != $repeat_password) {
        $errors[] = "Passwords do not match.";

    }

    if (!empty($errors)) {
        $error_string = implode(",", $errors);
        $redirect_url = "../create-new-password.php?selector=$selector&validator=" . bin2hex($validator) . "&errors=$error_string";
        header("Location: $redirect_url");
        exit();
    }

    // select current datetime for token
    $current_date = date("U");
    
    // sql query
    $sql = "SELECT * FROM password_reset WHERE reset_selector = ? AND reset_expiry >= ?";
    $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            $errors[] = "There was an error.";
            header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
            exit();
        } else {
            // access the token by hashing the token from url
            $hashed_token = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "si", $selector, $current_date);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
                $errors[] = "There was an error. Please resubmit your password reset request.";
                header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                exit();
            } else {
                // check if token exists
                $token_binary = hex2bin($validator); 
                $token_check = password_verify($token_binary, $row["reset_token"]);
                
                if ($token_check === false){
                    $errors[] = "There was an error. Please resubmit your password reset request.";
                    header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                    exit();
                } elseif ($token_check === true) {
                    // select user's email from database password_reset table
                    $email = $row['reset_email'];
                    
                    $sql = "SELECT * FROM users WHERE user_email = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                            $errors[] = "There was an error.";
                            header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                            exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if (!$row = mysqli_fetch_assoc($result)) {
                            $errors[] = "There was an error. Please resubmit your password reset request.";
                            header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                            exit();
                        } else {
                            // hash the password
                            $new_password_hash = password_hash($password, PASSWORD_DEFAULT);
                            // update the password
                            $sql = "UPDATE users SET user_password_hash = ? WHERE user_email = ?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                    $errors[] = "There was an error resetting the password. Please try again.";
                                    header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                                    exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "ss", $new_password_hash, $email);
                                mysqli_stmt_execute($stmt);
                                
                                // delete token
                                $check_sql = "DELETE from password_reset WHERE reset_email = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $check_sql)) {
                                    $errors[] = "There was an error in deleting the token from the server. Please resubmit your password reset request.";
                                    header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token)) . "&errors=" . implode(",", $errors);
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $email);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../reset-password-success.php");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        }



} else {
    header("Location: ../create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token));
}

?>