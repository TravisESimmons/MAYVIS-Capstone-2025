<?php
// Start output buffering to prevent header issues
ob_start();

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection - correct path from proposal-creation folder
require_once dirname(__DIR__) . '/connect.php';

// Initialize variables
$proposal_id = null;
$errors = [];

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data
    $existingClientID = $_POST['existingClientID'] ?? null;
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $dateCreated = $_POST['dateCreated'] ?? date('Y-m-d');
    $personalLetter = mysqli_real_escape_string($conn, $_POST['personalLetter'] ?? '');
    $deliverables = $_POST['deliverables'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    
    // Validate required fields
    if (empty($title)) {
        $errors[] = "Proposal title is required";
    }
    if (empty($personalLetter)) {
        $errors[] = "Proposal letter is required";
    }
    if (empty($deliverables)) {
        $errors[] = "At least one deliverable is required";
    }
    
    // Get employee information
    $employee_id = null;
    $employeFullName = '';
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $get_employee = "SELECT * FROM employees WHERE user_id = ?";
        $stmt = $conn->prepare($get_employee);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $employee_id = $row["employee_id"];
            $employee_Fname = $row['employee_first_name'];
            $employee_Lname = $row['employee_last_name'];
            $employeFullName = "$employee_Fname $employee_Lname";
        } else {
            $errors[] = "Employee not found";
        }
    } else {
        $errors[] = "User not logged in";
    }
    
    // If no errors, proceed with database operations
    if (empty($errors)) {
        $conn->autocommit(FALSE); // Start transaction
        
        try {
            $client_id = null;
            
            if ($existingClientID) {
                // Use existing client
                $client_id = $existingClientID;
            } else {
                // Create new client
                $companyName = mysqli_real_escape_string($conn, $_POST['companyName'] ?? '');
                $firstName = mysqli_real_escape_string($conn, $_POST['firstName'] ?? '');
                $lastName = mysqli_real_escape_string($conn, $_POST['lastName'] ?? '');
                $contactEmail = mysqli_real_escape_string($conn, $_POST['contactEmail'] ?? '');
                
                if (empty($companyName) || empty($firstName) || empty($lastName) || empty($contactEmail)) {
                    throw new Exception("All client fields are required for new clients");
                }
                
                // Insert new client
                $sql1 = "INSERT INTO clients (client_name) VALUES (?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("s", $companyName);
                if (!$stmt1->execute()) {
                    throw new Exception("Error creating client: " . $conn->error);
                }
                $client_id = $conn->insert_id;
                
                // Insert contact
                $sql2 = "INSERT INTO contacts (first_name, last_name, email, client_id) VALUES (?, ?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("sssi", $firstName, $lastName, $contactEmail, $client_id);
                if (!$stmt2->execute()) {
                    throw new Exception("Error creating contact: " . $conn->error);
                }
            }
            
            // Create proposal
            $sql3 = "INSERT INTO proposals (creation_date, proposal_title, proposal_letter, client_id, employee_id, employee_creator) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("ssssis", $dateCreated, $title, $personalLetter, $client_id, $employee_id, $employeFullName);
            if (!$stmt3->execute()) {
                throw new Exception("Error creating proposal: " . $conn->error);
            }
            $proposal_id = $conn->insert_id;
            
            // Process deliverables
            $proposal_total = 0;
            $deliverablesWithQuantities = array_combine($deliverables, $quantities);
            
            foreach ($deliverablesWithQuantities as $deliverableId => $quantity) {
                // Get deliverable price
                $getPrice = "SELECT price FROM deliverables WHERE deliverable_id = ?";
                $priceStmt = $conn->prepare($getPrice);
                $priceStmt->bind_param("i", $deliverableId);
                $priceStmt->execute();
                $priceResult = $priceStmt->get_result();
                
                if ($priceResult->num_rows > 0) {
                    $priceRow = $priceResult->fetch_assoc();
                    $deliverable_price = $priceRow['price'];
                    $proposal_total += $deliverable_price * $quantity;
                    
                    // Insert ordered deliverable
                    $sqlDel = "INSERT INTO ordered_deliverables (deliverable_id, quantity, proposal_id) VALUES (?, ?, ?)";
                    $stmtDel = $conn->prepare($sqlDel);
                    $stmtDel->bind_param("iii", $deliverableId, $quantity, $proposal_id);
                    if (!$stmtDel->execute()) {
                        throw new Exception("Error inserting deliverable: " . $conn->error);
                    }
                } else {
                    throw new Exception("Deliverable not found: " . $deliverableId);
                }
            }
            
            // Update proposal total
            $sqlUpdate = "UPDATE proposals SET value = ? WHERE proposal_id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("di", $proposal_total, $proposal_id);
            if (!$stmtUpdate->execute()) {
                throw new Exception("Error updating proposal total: " . $conn->error);
            }
            
            // Commit transaction
            $conn->commit();
            
            // Set success message
            $_SESSION['message'] = "Proposal created successfully!";
            
            // Clean output buffer and redirect
            ob_end_clean();
            header("Location: /mayvis/proposal-details.php?proposal_id=$proposal_id");
            exit;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $errors[] = $e->getMessage();
        }
        
        $conn->autocommit(TRUE); // Reset autocommit
    }
}

// If we get here, there were errors or no form submission
// Clean output buffer and redirect back
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    ob_end_clean();
    header("Location: /mayvis/proposal-creation.php?step=4");
    exit;
} else {
    // No form submission, redirect to step 1
    ob_end_clean();
    header("Location: /mayvis/proposal-creation.php");
    exit;
}
?>