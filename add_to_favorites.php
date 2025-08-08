<?php
include 'connect.php';

session_start();

// Check if the user is logged in and the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Check if the deliverable ID is sent via POST request
    if (isset($_POST['deliverable_id'])) {
        // Get the deliverable ID from the POST data
        $deliverableId = $_POST['deliverable_id'];

        // execute the SQL query to insert into the favourites table
        $sql = "INSERT INTO favourites (user_id, deliverable_id) VALUES ($userId, $deliverableId)";
        if ($conn->query($sql) === TRUE) {
            // If the insertion is successful
            echo "Template added to favorites!";
        } else {
            // If there's an error
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {

        echo "Deliverable ID is missing!";
    }
} else {
    echo "User is not logged in!";
}

$conn->close();
