   <?php
   include 'connect.php';

    $client_id = $_GET['client_id'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactEmail = $_POST['contactEmail'];



$sql2 = "INSERT INTO contacts (first_name, last_name, email, client_id) VALUES ('$firstName', '$lastName', '$contactEmail', '$client_id')";
    if ($conn->query($sql2)) {
        // echo "New contact created successfully";
        header("Location: employee-usercontrol.php");

    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    ?>