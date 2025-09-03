<?php 
    include 'connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $category = $_POST['category']; 
    }

    $currentDate = date("Y-m-d");

    $sql = "INSERT INTO deliverables (title, description, price, category, updated_date) VALUES ('$title', '$description', '$price', '$category', '$currentDate')";
    if ($conn->query($sql)) {
        $_SESSION['message'] = "Template added successfully";

        

        header('Location: templates.php');
        echo "New deliverable created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

?>