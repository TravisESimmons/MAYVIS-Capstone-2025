<?php
// Not meant to be the actual employee home page, just a default landing page for when logged in.
require_once("./login/classes/Login.php");
include("./profile-functions.php");
$login = new Login();


if ($login->isUserLoggedIn() == true) {
    // user is logged in; initialize the header variables
    $title = "Edit Profile";
    include("./includes/header-new.php");

} else {
    // not logged in: redirect to the login page
    header("Location:./login/index.php");
}

// connect to database
include('connect.php');

?>

<?php
// check for profile picture
$picture_sql = $conn->prepare("SELECT filename from profile_pictures WHERE user_id = ?");
$picture_sql->bind_param("i", $_SESSION['user_id']);
$picture_sql->execute();

$result = $picture_sql->get_result();

$picture_filename = '';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $picture_filename = $row['filename'];
}

// check notifications status
$notification_sql = $conn->prepare("SELECT notifications from users WHERE user_id = ?");
$notification_sql->bind_param("i", $_SESSION['user_id']);
$notification_sql->execute();

$result = $notification_sql->get_result();

$notification_status = '';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $notification_status = $row['notifications'];

$notifications_options = array("0"=>"unchecked", "1"=>"checked");
}
?>

<!-- initialize form varaibles -->
<?php
$error_message = "";
$success_message = "";
$new_user_name = isset($_POST['save']) ? trim($_POST['user_name']) : "";
$new_first_name = isset($_POST['save']) ? trim($_POST['first_name']) : "";
$new_last_name = isset($_POST['save']) ? trim($_POST['last_name']) : "";
$new_email = isset($_POST['save']) ? trim($_POST['email']) : "";
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : "";
$confirm_new_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : "";

?>

<!-- validation -->
<?php
if (isset($_POST['save'])) {

    // validate user name
    if (isset($new_user_name) && $new_user_name != "") {
        if (strlen($new_user_name) > 2) {
            $new_user_name = filter_var($new_user_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $new_user_name = mysqli_real_escape_string($conn, $new_user_name);
            if (already_exists_in_users("user_name", $new_user_name, $conn)) {
                $error_message .= "<p>Cannot update username: username already exists in the database.</p>";
            } else {
                $update_statement = $conn->prepare("UPDATE users SET user_name = ? WHERE user_id = ?");
                $update_statement->bind_param("si", $new_user_name, $_SESSION['user_id']);
                $update_statement->execute();
                $success_message .= "<p>Username updated successfully.</p>";
            }
        } else {
            $error_message .= "<p>New username must be more than 1 character.</p>";
        }
    }

    // validate first name
    if (isset($new_first_name) && $new_first_name != "") {
        if (strlen($new_first_name) > 2) {
            $new_first_name = filter_var($new_first_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $new_first_name = mysqli_real_escape_string($conn, $new_first_name);

            $update_statement = $conn->prepare("UPDATE users SET first_name = ? WHERE user_id = ?");
            $update_statement->bind_param("si", $new_first_name, $_SESSION['user_id']);
            $update_statement->execute();
            // writing to the contacts table
            if (is_user_in_contacts($_SESSION['user_id'], $conn)) {
                $contacts_update = $conn->prepare("UPDATE contacts SET first_name = ? where user_id = ?");
                $contacts_update->bind_param("si", $new_first_name, $_SESSION['user_id']);
                $contacts_update->execute();
            }
            $success_message .= "<p>First Name updated successfully.</p>";
        } else {
            $error_message .= "<p>First Name must be more than 1 character.</p>";
        }
    }

    // validate last name
    if (isset($new_last_name) && $new_last_name != "") {
        if (strlen($new_last_name) > 2) {
            $new_last_name = filter_var($new_last_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $new_last_name = mysqli_real_escape_string($conn, $new_last_name);

            $update_last_name_statement = $conn->prepare("UPDATE users SET last_name = ? WHERE user_id = ?");
            $update_last_name_statement->bind_param("si", $new_last_name, $_SESSION['user_id']);
            $update_last_name_statement->execute();
            // writing to the contacts table
            if (is_user_in_contacts($_SESSION['user_id'], $conn)) {
                $contacts_update = $conn->prepare("UPDATE contacts SET last_name = ? where user_id = ?");
                $contacts_update->bind_param("si", $new_last_name, $_SESSION['user_id']);
                $contacts_update->execute();
            }
            $success_message .= "<p>Last Name updated successfully.</p>";
        } else {
            $error_message .= "<p>Last Name must be more than 1 character.</p>";
        }
    }

    // validate email address
    $new_email = isset($_POST['email']) ? trim($_POST['email']) : "";
    if (!empty($new_email)) {
        // check if the email is valid
        if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            // Sanitize and escape the email address
            $new_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);
            $new_email = mysqli_real_escape_string($conn, $new_email);

            // check if email in database
            if (already_exists_in_users("user_email", $new_email, $conn)) {
                $error_message .= "<p>Cannot update email address: email address already exists in the database.</p>";
            } else {
                $update_statement = $conn->prepare("UPDATE users SET user_email = ? WHERE user_id = ?");
                $update_statement->bind_param("si", $new_email, $_SESSION['user_id']);
                $update_statement->execute();
                // writing to the contacts table
                if (is_user_in_contacts($_SESSION['user_id'], $conn)) {
                    $contacts_update = $conn->prepare("UPDATE contacts SET email = ? where user_id = ?");
                    $contacts_update->bind_param("si", $new_email, $_SESSION['user_id']);
                    $contacts_update->execute();
                }
                $success_message .= "<p>Email address updated successfully.</p>";
            }
        } else {
            $error_message .= "<p>Invalid email address.</p>";
        }
    }

    // update password validation

    if (!empty($new_password) && !empty($confirm_new_password)) {
        // check if new password and confirm new password match
        if ($new_password !== $confirm_new_password) {
            $error_message .= "<p>New password and confirm new password do not match.</p>";
        } else if (strlen($new_password) < 6) { // Check if new password meets length requirement only when passwords match
            // check if new password meets length requirement
            $error_message .= "<p>New password must be at least 6 characters long.</p>";
        } else {
            // hash the new password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // update the password hash in the database
            $update_password_statement = $conn->prepare("UPDATE users SET user_password_hash = ? WHERE user_id = ?");
            $update_password_statement->bind_param("si", $new_password_hash, $_SESSION['user_id']);
            $update_password_statement->execute();
            $success_message .= "<p>Password updated successfully.</p>";
        }
    }

    if (isset($_POST['notification_check']) && $notification_status === '0'){
        $notification_status = '1';
        $update_statement = $conn->prepare("UPDATE users SET notifications = ? WHERE user_id = ?");
        $update_statement->bind_param("si", $notification_status, $_SESSION['user_id']);
        $update_statement->execute();
        $success_message .= "<p>Notifications turned on.</p>";
    }

    if (!isset($_POST['notification_check']) && $notification_status === '1'){
        $notification_status = '0';
        $update_statement = $conn->prepare("UPDATE users SET notifications = ? WHERE user_id = ?");
        $update_statement->bind_param("si", $notification_status, $_SESSION['user_id']);
        $update_statement->execute();
        $success_message .= "<p>Notifications turned off.</p>";
    }

} elseif (isset($_POST['upload_file'])) {
    $originalsFolder = "./images/originals/";
    $thumbsFolder = "./images/thumbs/";
    $thumbsSquareFolder = "./images/thumbs-square/";
    $thumbsSquareSmallFolder = "./images/thumbs-square-small/";

    if (($_FILES["upload"]["type"] == "image/jpeg") || ($_FILES["upload"]["type"] == "image/pjpeg")) {
        $boolValidateOK = 1;
    } else {
        $boolValidateOK = 0;
        $error_message .= "<p>File must be a JPG or JPEG.</p>";
    }

    if (!($_FILES["upload"]["size"] < 4000000)) {
        $boolValidateOK = 0;
        $error_message .= "<p>File size is too large.</p>";
    }

    if ($boolValidateOK == 1) {
        move_uploaded_file($_FILES["upload"]["tmp_name"], $originalsFolder   . $_FILES["upload"]["name"]);
        $thisFile = $originalsFolder . $_FILES["upload"]["name"];

        createSquareImageCopy($thisFile, $thumbsSquareFolder, 128);
        $thumbToShow = createSquareImageCopy($thisFile, $thumbsSquareSmallFolder, 48);
        resizeImage($thisFile, $thumbsFolder, 128);

        // check if user already has a picture in the db
        $sql = $conn->prepare("SELECT * from profile_pictures WHERE user_id = ?");
        $sql->bind_param("i", $_SESSION['user_id']);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            delete_picture($_SESSION['user_id'], $conn);
        }

        // insert new photo in db
        $filename = $_FILES["upload"]["name"];
        $user_id = $_SESSION['user_id'];
        mysqli_query($conn, "INSERT INTO profile_pictures (filename, user_id) VALUES ('$filename', '$user_id')") or die(mysqli_error($conn));
        $_SESSION['profile_pic_filename'] = $filename;
        $success_message .= "<p>Profile Picture successfully updated. Refresh the page to see the changes.</p>";
    }
} elseif (isset($_POST['remove_file'])) {
    $sql = $conn->prepare("SELECT * from profile_pictures WHERE user_id = ?");
    $sql->bind_param("i", $_SESSION['user_id']);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        delete_picture($_SESSION['user_id'], $conn);
        unset($_SESSION['profile_pic_filename']);
        $success_message .= "<p>Profile Picture successfully removed. Refresh the page to see the changes.</p>";
    }
}

?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!-- main form -->
<div class="container mx-auto">
    <h2>Edit Profile</h2>
    <?php

    $user_display = "";
    $firstname_display = "";
    $lastname_display = "";
    $email_display = "";

    if (isset($_SESSION['user_id'])) {
        $uid = $_SESSION['user_id'];

        // first query to get user information
        $sql_user = "SELECT * FROM users WHERE user_id = " . $uid;
        $result_user = $conn->query($sql_user);

        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $user_display = $row_user["user_name"];
            $firstname_display = $row_user["first_name"];
            $lastname_display = $row_user["last_name"];
            $email_display = $row_user["user_email"];
        } else {
            echo "0 results";
        }
    }
    ?>
    <!-- display error message -->
    <?php if ($error_message != "") : ?>
        <div role="alert" class="alert alert-danger my-4 pb-0 col-6">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- display success message -->
    <?php if ($success_message != "") : ?>
        <div role="alert" class="alert alert-primary my-4 pb-0 col-6">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>


    <!------- 

    start of form 

    ------->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="row gx-4 justify-content-between" enctype="multipart/form-data">
        <div class="col-md-6">
            <!-- LEFT COLUMN: Personal Information -->
            <h3 class="display fw-normal mb-3 mt-4">Personal Information</h3>
            <div class="form-group mb-4">
                <label for="login_input_username">Username</label>
                <input id="login_input_username" class="login_input form-control" type="text" name="user_name" placeholder="<?php echo $user_display; ?>" />
            </div>
            <!-- EMAIL -->
            <div class="form-group mb-4">
                <label for="login_input_email">Email Address</label>
                <input id="login_input_email" class="login_input form-control" type="text" name="email" placeholder="<?php echo $email_display; ?>" />
            </div>
            <div class="row">
                <!-- FIRST AND LAST NAME -->
                <div class="form-group mb-4 col-6">
                    <label for="login_input_firstname">First Name</label>
                    <input id="login_input_firstname" class="login_input form-control" type="text" name="first_name" placeholder="<?php echo $firstname_display; ?>" />
                </div>
                <div class="form-group mb-4 col-6">
                    <label for="login_input_lastname">Last Name</label>
                    <input id="login_input_lastname" class="login_input form-control" type="text" name="last_name" placeholder="<?php echo $lastname_display; ?>" />
                </div>
            </div>
            <!-- PASSWORDS -->
            <div class="form-group mb-4">
                <label for="login_input_password">Password</label>
                <input id="login_input_password" class="login_input form-control" type="password" name="new_password" />
            </div>
            <div class="form-group mb-4">
                <label for="login_input_confirm_password">Confirm Password</label>
                <input id="login_input_confirm_password" class="login_input form-control" type="password" name="confirm_new_password" />
            </div>


        </div>
        <div class="col-md-5">
            <!-- RIGHT COLUMN -->
            <div class="form-group">
                <h3 class="display fw-normal mb-3 mt-4">Edit Profile Picture</h3>
                <!-- profile picture -->
                <div class="d-flex align-items-center mb-4">
                    <!-- picture -->
                    <img src="
                    <?php
                    if (!empty($picture_filename)) {
                        echo "./images/thumbs-square/" . $picture_filename;
                    } else {
                        echo "https://ui-avatars.com/api/?size=128";
                    }
                    ?>
                    " alt="Profile Image" class="rounded-circle">
                    <!-- buttons -->
                    <div class="d-flex flex-column px-2 mx-3 ">
                        <label for="formFile" class="form-label" hidden>Upload Profile Image</label>
                        <input class="mb-4" type="file" id="formFile" name="upload" value="Upload">
                        <div class="d-flex ">
                            <input type="submit" name="upload_file" value="Upload" class="btn btn-primary">
                            <input type="submit" name="remove_file" value="Remove" class="btn btn-outline-light mx-3">
                        </div>
                    </div>
                </div>
                <!-- notification settings -->
                <h3 class="display fw-normal mb-3">Notification Settings</h3>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="notification_check" name="notification_check" <?php echo $notifications_options[$notification_status]; ?>>
                    <label for="emailNotification" class="form-check-label">
                        Notify me through Email
                    </label>
                </div>
                <div class="form-text fs-6" id="notificationHelpBlock">
                    Notifications will be sent to your email address if changes are made to your existing proposals. If notifications do not appear, please check your spam folder.
                </div>

            </div>

        </div>

        <div class="col-12">
            <!-- submit button -->
            <input type="submit" name="save" value="Save Changes" class="btn btn-primary">
        </div>

    </form>

</div>

<?php
include('./includes/footer.php');
?>