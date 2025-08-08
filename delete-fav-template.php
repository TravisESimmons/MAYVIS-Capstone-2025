<?php
session_start();
include 'connect.php';

if (isset($_POST['deliverable_id'])) {
    $deliverable_id = $_POST['deliverable_id'];
    $user_id = $_SESSION['user_id'];

    // SQL to delete the template
    $sql = "DELETE FROM favourites WHERE deliverable_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $deliverable_id, $user_id);

    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header("Location: employee-dashboard.php?msg=Template+Deleted+Successfully");
    } else {
        // Redirect back with an error message
        header("Location: employee-dashboard.php?msg=Error+Deleting+Template");
    }
    $stmt->close();
} else {
    // Redirect back with an error message if deliverable_id is not set
    header("Location: employee-dashboard.php?msg=Invalid+Request");
}
