<?php
if (isset($_POST['deliverable_id'])) {
    // Retrieve the deliverable_id 
    $deliverable_id = $_POST['deliverable_id'];


    include 'connect.php';

    // SQL query to delete the template with the given deliverable_id
    $sql = "DELETE FROM deliverables WHERE deliverable_id = $deliverable_id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // If deletion is successful
        echo "Template deleted successfully!";
    } else {
        // If an error occurs during deletion
        echo "Error deleting template: " . $conn->error;
    }


    $conn->close();
} else {

    echo "Error: deliverable_id parameter is not set.";
}
