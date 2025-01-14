<?php
// KEEN Mayvis Capstone Project
// Initial file header and authorship comment
// Created by TravisESimmons, Evan Mah, Jeb Gallarde, Melody Miranda
// [Modernization] Minor code cleanup and modernization (Jan 2025)
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

// initialize form variables
$error_message = "";
$success_message = "";

// Check for upload success from redirect
if ((isset($_GET['upload_success']) || isset($_GET['remove_success'])) && isset($_SESSION['upload_success'])) {
    $success_message = $_SESSION['upload_success'];
    unset($_SESSION['upload_success']);
}

$new_user_name = isset($_POST['save']) ? trim($_POST['user_name']) : "";
$new_first_name = isset($_POST['save']) ? trim($_POST['first_name']) : "";
$new_last_name = isset($_POST['save']) ? trim($_POST['last_name']) : "";
$new_email = isset($_POST['save']) ? trim($_POST['email']) : "";
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : "";
$confirm_new_password = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : "";

// validation
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

    // Validate file type - accept JPEG, JPG, PNG, and GIF
    $allowedTypes = ["image/jpeg", "image/pjpeg", "image/png", "image/gif"];
    if (in_array($_FILES["upload"]["type"], $allowedTypes)) {
        $boolValidateOK = 1;
    } else {
        $boolValidateOK = 0;
        $error_message .= "<p>File must be a JPG, JPEG, PNG, or GIF image.</p>";
    }

    if (!($_FILES["upload"]["size"] < 4000000)) {
        $boolValidateOK = 0;
        $error_message .= "<p>File size is too large. Maximum size is 4MB.</p>";
    }

    if ($boolValidateOK == 1) {
        // Create directories if they don't exist
        foreach ([$originalsFolder, $thumbsFolder, $thumbsSquareFolder, $thumbsSquareSmallFolder] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        // Generate unique filename to prevent conflicts
        $fileExtension = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
        $uniqueFilename = $_SESSION['user_id'] . '_' . time() . '.' . $fileExtension;
        
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $originalsFolder . $uniqueFilename)) {
            $thisFile = $originalsFolder . $uniqueFilename;

            try {
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

                // insert new photo in db using prepared statement
                $stmt = $conn->prepare("INSERT INTO profile_pictures (filename, user_id) VALUES (?, ?)");
                $stmt->bind_param("si", $uniqueFilename, $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $_SESSION['profile_pic_filename'] = $uniqueFilename;
                    $picture_filename = $uniqueFilename; // Update display immediately
                    $_SESSION['upload_success'] = "Profile Picture successfully updated!";
                    
                    // Redirect to prevent form resubmission and ensure fresh page load
                    header("Location: " . $_SERVER['PHP_SELF'] . "?upload_success=1");
                    exit();
                } else {
                    $error_message .= "<p>Database error: " . $conn->error . "</p>";
                }
            } catch (Exception $e) {
                $error_message .= "<p>Error processing image: " . $e->getMessage() . "</p>";
            }
        } else {
            $error_message .= "<p>Error uploading file. Please try again.</p>";
        }
    }
} elseif (isset($_POST['remove_file'])) {
    $sql = $conn->prepare("SELECT * from profile_pictures WHERE user_id = ?");
    $sql->bind_param("i", $_SESSION['user_id']);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        delete_picture($_SESSION['user_id'], $conn);
        unset($_SESSION['profile_pic_filename']);
        $_SESSION['upload_success'] = "Profile Picture successfully removed!";
        
        // Redirect to prevent form resubmission and ensure fresh page load
        header("Location: " . $_SERVER['PHP_SELF'] . "?remove_success=1");
        exit();
    }
}
?>

<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-color: #ec4899;
        --accent-color: #06b6d4;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --border-radius: 12px;
        --border-radius-lg: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --error-color: #ef4444;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* DROPDOWN FIX - Override any conflicting styles */
    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
        z-index: 999999 !important;
        transform: none !important;
        inset: auto 0px auto auto !important;
        margin: 0 !important;
        margin-top: 8px !important;
    }

    .dropdown-menu[data-bs-popper] {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
        z-index: 999999 !important;
        transform: none !important;
        inset: auto 0px auto auto !important;
    }

    .profile-dropdown {
        position: relative !important;
    }

    .profile-dropdown .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
    }

    /* Ensure navbar stays on top */
    .modern-navbar {
        z-index: 999998 !important;
    }

    header.sticky-top {
        z-index: 999998 !important;
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Page Header */
    .page-header {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .page-header .content {
        position: relative;
        z-index: 2;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Navigation */
    .nav-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-nav {
        background: white;
        color: var(--text-dark);
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .btn-nav:hover {
        color: var(--primary-color);
        text-decoration: none;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Alert Messages */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--error-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    /* Profile Form */
    .profile-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--bg-secondary);
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Profile Picture Section */
    .profile-picture-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-picture {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        margin-bottom: 1.5rem;
        object-fit: cover;
    }

    .picture-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .file-input {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        background: var(--bg-secondary);
        color: var(--text-dark);
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        border: 2px dashed #e5e7eb;
        cursor: pointer;
        transition: var(--transition);
        display: inline-block;
        font-weight: 600;
    }

    .file-input-label:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .picture-buttons {
        display: flex;
        gap: 0.75rem;
    }

    /* Notifications */
    .notification-section {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
    }

    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: var(--primary-color);
        margin-top: 0.125rem;
    }

    .checkbox-label {
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        user-select: none;
    }

    .help-text {
        font-size: 0.875rem;
        color: var(--text-light);
        line-height: 1.5;
        margin-top: 0.5rem;
    }

    /* Buttons */
    .btn-primary {
        background: var(--bg-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: white;
        color: var(--text-dark);
        padding: 0.875rem 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger {
        background: var(--error-color);
        color: white;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Save Button */
    .save-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        text-align: center;
    }

    .save-btn {
        background: var(--bg-gradient);
        color: white;
        padding: 1rem 3rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .profile-form {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .form-section {
            padding: 2rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.75rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .picture-buttons {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-edit"></i>
                Edit Profile
            </h1>
            <p class="page-subtitle">Manage your personal information and account settings</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <?php
        // Get user status to determine correct dashboard
        $uid = $_SESSION['user_id'];
        $sql_user_status = "SELECT user_status FROM users WHERE user_id = " . $uid;
        $result_user_status = $conn->query($sql_user_status);
        
        $dashboard_url = "/mayvis/employee-dashboard.php"; // default to employee
        if ($result_user_status->num_rows > 0) {
            $row_status = $result_user_status->fetch_assoc();
            $user_status = $row_status["user_status"];
            
            // If user_status is 0, they are a client
            if ($user_status == 0) {
                $dashboard_url = "/mayvis/client-dashboard.php";
            }
        }
        ?>
        <a href="<?php echo $dashboard_url; ?>" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

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
            // User not found - redirect to login
            header("Location: ./login/index.php");
            exit();
        }
    }
    ?>

    <!-- Alert Messages -->
    <?php if ($error_message != "") : ?>
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div><?php echo $error_message; ?></div>
        </div>
    <?php endif; ?>

    <?php if ($success_message != "") : ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <div><?php echo $success_message; ?></div>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
        <!-- Profile Form Grid -->
        <div class="profile-form">
            <!-- Personal Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Personal Information
                </h3>
                
                <div class="form-group">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" id="user_name" name="user_name" class="form-input" 
                           placeholder="<?php echo htmlspecialchars($user_display); ?>">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="<?php echo htmlspecialchars($email_display); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" 
                               placeholder="<?php echo htmlspecialchars($firstname_display); ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" 
                               placeholder="<?php echo htmlspecialchars($lastname_display); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-input" 
                               placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_new_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-input" 
                               placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <!-- Profile Picture & Settings -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-camera"></i>
                    Profile Picture
                </h3>
                
                <div class="profile-picture-section">
                    <img src="<?php
                        if (!empty($picture_filename)) {
                            $image_path = $_SERVER['DOCUMENT_ROOT'] . "/mayvis/images/thumbs-square/" . $picture_filename;
                            $cache_buster = file_exists($image_path) ? filemtime($image_path) : time();
                            echo "/mayvis/images/thumbs-square/" . htmlspecialchars($picture_filename) . "?v=" . $cache_buster;
                        } else {
                            echo "https://ui-avatars.com/api/?size=128&name=" . urlencode($firstname_display . " " . $lastname_display);
                        }
                    ?>" alt="Profile Image" class="profile-picture">
                    
                    <div class="picture-upload">
                        <div class="file-input-wrapper">
                            <input type="file" id="upload" name="upload" class="file-input" accept="image/jpeg,image/jpg,image/png,image/gif">
                            <label for="upload" class="file-input-label">
                                <i class="fas fa-upload"></i>
                                Choose New Picture
                            </label>
                        </div>
                        
                        <div class="picture-buttons">
                            <button type="submit" name="upload_file" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Upload
                            </button>
                            <?php if (!empty($picture_filename)): ?>
                                <button type="submit" name="remove_file" class="btn-danger">
                                    <i class="fas fa-trash"></i>
                                    Remove
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <h3 class="section-title">
                    <i class="fas fa-bell"></i>
                    Notifications
                </h3>
                
                <div class="notification-section">
                    <div class="checkbox-group">
                        <input type="checkbox" id="notification_check" name="notification_check" 
                               class="checkbox-input" <?php echo $notifications_options[$notification_status]; ?>>
                        <label for="notification_check" class="checkbox-label">
                            Email Notifications
                        </label>
                    </div>
                    <div class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Receive email notifications when changes are made to your proposals. 
                        Check your spam folder if notifications don't appear in your inbox.
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="save-section">
            <button type="submit" name="save" class="save-btn">
                <i class="fas fa-save"></i>
                Save All Changes
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const sections = document.querySelectorAll('.form-section, .save-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        setTimeout(() => {
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add loading states to buttons
    document.querySelectorAll('button[type="submit"]').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin';
            }
        });
    });

    // File input preview
    const fileInput = document.getElementById('upload');
    const profilePicture = document.querySelector('.profile-picture');
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php
include('./includes/footer.php');
