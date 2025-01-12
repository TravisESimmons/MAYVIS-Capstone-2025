<?php
include 'connect.php';
include 'send-notification.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $signature = mysqli_real_escape_string($conn, $_POST['signature']);
    $response = mysqli_real_escape_string($conn, $_POST['response']);
    $decision = $_POST['decision'];

    $proposal_id = $_GET['proposal_id'];
    $second_sig = isset($_POST['second_sig']) ? ($_POST['second_sig'] == 'yes' ? 1 : 0) : 0;
    echo "<p>sig: $second_sig</p>";


}



$currentDate = date("Y-m-d");


$sql = "UPDATE proposals SET approval_date = '$currentDate', status = '$decision', client_response = '$response', signature = '$signature', second_sig = '$second_sig' WHERE proposal_id = '$proposal_id'";
if ($conn->query($sql)) {
    if (allows_notifications($conn, $proposal_id, "employee") == true){
        proposal_update($conn, $proposal_id, "1");
    }
    $_SESSION['message'] = "Approval status successful";

    

    header("Location: client-approval.php?proposal_id=$proposal_id");
    echo "New deliverable created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
