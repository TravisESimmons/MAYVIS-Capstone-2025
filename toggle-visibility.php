<?php
// Toggle template visibility via AJAX
header('Content-Type: application/json');

// Start session and establish database connection
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the deliverable_id and visibility status from the POST parameters
    $deliverable_id = isset($_POST['deliverable_id']) ? intval($_POST['deliverable_id']) : 0;
    $visible = isset($_POST['visible']) ? intval($_POST['visible']) : 0;

    // Validate inputs
    if ($deliverable_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid deliverable ID']);
        exit;
    }

    // Ensure visible is either 0 or 1
    $visible = ($visible == 1) ? 1 : 0;

    try {
        // Perform database update
        $sql = "UPDATE deliverables SET visible = ? WHERE deliverable_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $visible, $deliverable_id);

        // Execute the update query
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Update successful
                echo json_encode([
                    'success' => true,
                    'message' => 'Template visibility updated successfully',
                    'deliverable_id' => $deliverable_id,
                    'visible' => $visible
                ]);
            } else {
                // No rows affected (template not found)
                http_response_code(404);
                echo json_encode(['error' => 'Template not found']);
            }
        } else {
            // Database error
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $conn->error]);
        }

        // Close statement
        $stmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }

    // Close database connection
    $conn->close();
} else {
    // Handle invalid request method
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
