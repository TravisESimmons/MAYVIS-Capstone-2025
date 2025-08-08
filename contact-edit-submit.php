<?php
   include 'connect.php';

    $contact_id = $_GET['contact_id'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactEmail = $_POST['contactEmail'];



    $sql2 = "UPDATE contacts SET first_name = '$firstName', last_name = '$lastName', email = '$contactEmail'  WHERE contact_id = '$contact_id'";
    if ($conn->query($sql2)) {
        // echo "New contact created successfully";
        header("Location: employee-usercontrol.php");

    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    ?>