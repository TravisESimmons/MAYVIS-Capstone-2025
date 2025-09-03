<?php
include 'connect.php';

// Debugging: Print out the received POST data
var_dump($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming your form sends the proposal_id via POST
    $proposal_id = $_GET['proposal_id'];
    $personalLetter = $_POST['personalLetter'];
    // Sanitize inputs to prevent SQL injection
    $personalLetter = mysqli_real_escape_string($conn, $personalLetter);
    
    // Update the database
    $sql = "UPDATE proposals SET proposal_letter = '$personalLetter' WHERE proposal_id = '$proposal_id'";
    if ($conn->query($sql)) {
        $_SESSION['message'] = "<p class='bg-success text-light'>Approval status successful</p>";
        //echo "Letter: $personalLetter";
       header("Location: change-letter.php?proposal_id=$proposal_id");
        exit; // Terminate script after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
