<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming your form sends the proposal_id via POST
    $proposal_id = $_GET['proposal_id'];
    $new_price = $_POST['new-price'];    
    // Sanitize inputs to prevent SQL injection
    $proposal_id = mysqli_real_escape_string($conn, $proposal_id);
    $new_price = mysqli_real_escape_string($conn, $new_price);
    
    // Update the database
    $sql = "UPDATE proposals SET value = '$new_price' WHERE proposal_id = '$proposal_id'";
    if ($conn->query($sql)) {
        $_SESSION['message'] = "<p class='bg-success text-light'>Approval status successful</p>";
        header("Location: proposal-details.php?proposal_id=$proposal_id");
        exit; // Terminate script after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
