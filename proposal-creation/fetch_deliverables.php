<?php 

$conn = mysqli_connect("localhost", "emah10", "MfyowmbyZXRFLvp", "emah10_dmit2590");

if (mysqli_connect_errno()) {
    echo "failed to connect to MySQL" . mysqli_connect_error();
} else {
    echo "Yay we are connected";
}



// Fetch deliverables based on the selected category
if(isset($_POST['category'])) {
    $category = $_POST['category'];
    
    // Query to fetch deliverables based on category
    $sql = "SELECT * FROM deliverables WHERE category = ?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("s", $category);
    
    // Execute statement
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    // Get result
    $result = $stmt->get_result();
    if ($result === false) {
        die("Get result failed: " . $stmt->error);
    }
    
    // Check if there are any deliverables found
    if ($result->num_rows > 0) {
        // Start building options
        $options = "<option value=''>Select Deliverable</option>";
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['deliverable_id'] . "'>" . $row['title'] . "</option>";
        }
        // Send options back as response
        echo $options;
    } else {
        // If no deliverables found for the category
        echo "<option value=''>No deliverables found for this category</option>";
    }
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>