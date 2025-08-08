<?php
// Include necessary files and establish database connection
$title = "Toggle Visibility";
include 'includes/header-new.php';
include 'connect.php';

$user_id = $_SESSION['user_id'] ?? null;
$welcome_message = "Welcome to Toggle Visibility Page!";

if ($user_id) {
    $stmt = $conn->prepare("SELECT employee_first_name, employee_last_name FROM employees WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_first_name = $row['employee_first_name'];
        $welcome_message = "Welcome back, $user_first_name!";
    }
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the deliverable_id and visibility status from the POST parameters
    $deliverable_id = $_POST['deliverable_id'];
    $visible = $_POST['visible'];

    // Perform database update
    $sql = "UPDATE deliverables SET visible = ? WHERE deliverable_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $visible, $deliverable_id);

    // Execute the update query
    if ($stmt->execute()) {
        // Update successful
        echo "Template visibility updated.";
    } else {
        // Error occurred
        echo "Error updating template visibility: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
