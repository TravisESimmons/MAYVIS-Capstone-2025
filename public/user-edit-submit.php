<?php
include 'connect.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id || !is_numeric($user_id)) {
    header("Location: employee-usercontrol.php");
    exit();
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$userEmail = trim($_POST['userEmail'] ?? '');
$userName = trim($_POST['userName'] ?? '');

// Validate inputs
if (empty($firstName) || empty($lastName) || empty($userEmail) || empty($userName)) {
    header("Location: employee-usercontrol.php?error=missing_fields");
    exit();
}

$stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, user_email = ?, user_name = ? WHERE user_id = ?");
$stmt->bind_param("ssssi", $firstName, $lastName, $userEmail, $userName, $user_id);

if ($stmt->execute()) {
    header("Location: employee-usercontrol.php");
    exit();
} else {
    header("Location: employee-usercontrol.php?error=update_failed");
    exit();
}

    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    ?>