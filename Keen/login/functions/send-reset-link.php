<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../connect.php");

//phpmailer
require_once('../../PHPMailer/PHPMailerAutoload.php');

$errors = []; // Initialize errors array

if(isset($_POST["password_reset_link"]) && !empty($_POST["user_email"])) {

    $email = mysqli_real_escape_string($conn, $_POST["user_email"]);

    // check email in db
    $sql = $conn->prepare("SELECT user_email FROM users WHERE user_email = ?");
    $sql->bind_param('s', $email);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        // Proceed with sending reset link

        // generate token
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        
        // ENTER YOUR BASE URL RIGHT BEFORE "/login"
        $url = "/login/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        $expires = date("U") + 1800; // expires 1 hour from now
    
        $check_sql = "DELETE from password_reset WHERE reset_email = ?";
        $stmt = mysqli_stmt_init($conn);
    
        if(!mysqli_stmt_prepare($stmt, $check_sql)) {
            $errors[] = "There was an error.";
            header("Location: ../forgot-password.php?errors=" . implode(",", $errors));
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
        }

        $sql = "INSERT INTO password_reset (reset_email, reset_selector, reset_token, reset_expiry) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            $errors[] = "There was an error.";
            header("Location: ../forgot-password.php?errors=" . implode(",", $errors));
            exit();
        } else {
            $hashed_token = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssi", $email, $selector, $hashed_token, $expires);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // creating email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = ''; // change
        $mail->Password = ''; // create and enter app password
        $mail->SetFrom(''); // change to no-reply or whatever you need

        // email content
        $mail->Subject = '';
            // message -- change to whatever you want yours to say
        $message = '<p>Here is the link to reset your password. If you did not make this request, please simply ignore this email.</p>';
        $message .= '<a href="'. $url .'">' . $url . '</a>';
        $mail->Body = $message;
        $mail->AddAddress($email); // you will have to initialize the $email earlier in your script

        $mail->Send();

        header("Location: ../forgot-password.php?reset=success");

    } else {
        // No account found with that email address
        $errors[] = "No account found with that email address.";

        // Redirect back to forgotpassword.php and include errors in query string
        header("Location: ../forgot-password.php?errors=" . implode(",", $errors));
        exit;
    }
} else {
    // no email provided
    $errors[] = "Please enter an email address.";

    // Redirect back to forgotpassword.php and include errors in query string
    header("Location: ../forgot-password.php?errors=" . implode(",", $errors));
    exit;
}
?>
