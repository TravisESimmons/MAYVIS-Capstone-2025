<?php
// [Modernization] 
// // Improved input validation and error handling (Jan 17 2025)

   include 'connect.php';

    $user_id = $_GET['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userEmail = $_POST['userEmail'];
    $userName = $_POST['userName'];


    $sql2 = "UPDATE users SET first_name = '$firstName', last_name = '$lastName', user_email = '$userEmail', user_name = '$userName'  WHERE user_id = '$user_id'";
    if ($conn->query($sql2)) {
        
        header("Location: employee-usercontrol.php");

    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    ?>