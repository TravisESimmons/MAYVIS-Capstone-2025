<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proposal_id = $_GET['proposal_id'];
    $sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";
// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $first_response = $row['client_response'];
        $first_sig = $row['signature'];
    } 
}
    // Retrieve form data

    $signature = mysqli_real_escape_string($conn, $_POST['signature']);
    $response = mysqli_real_escape_string($conn, $_POST['response']);
    $decision = $_POST['decision'];

    $updated_response = "<p>First Response: $first_response</p>";
    $updated_response .= "<p>Second Response: $response</p>";

    $updated_signature = "$first_sig & $signature";
    $updated_response = mysqli_real_escape_string($conn, $updated_response);
    $updated_signature = mysqli_real_escape_string($conn, $updated_signature);

}



$currentDate = date("Y-m-d");


$sql = "UPDATE proposals SET approval_date = '$currentDate', status = '$decision', client_response = '$updated_response', signature = '$updated_signature', second_sig = '3' WHERE proposal_id = '$proposal_id'";
if ($conn->query($sql)) {
    $_SESSION['message'] = "Approval status successful";

    

    header("Location: client-approval.php?proposal_id=$proposal_id");
    echo "New deliverable created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
