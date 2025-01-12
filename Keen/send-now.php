<?php 
include 'connect.php';
include 'send-notification.php';
$proposal_id = $_GET['proposal_id'];
$sql = "UPDATE proposals SET sent_status='1' WHERE proposal_id = $proposal_id"; // Assuming user_id 1 for demonstration
if ($conn->query($sql) === TRUE) {
    send_to_client($conn, $proposal_id, "0");
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
header("Location: proposal-details.php?proposal_id=$proposal_id");
?>