<?php
if (isset ($_POST['existingClientID'])) {
    $existingClientID = $_POST['existingClientID'];

    // You can fetch additional data about the existing client from your database if needed
} else {
    // If 'Use Existing Client' is not checked, handle the new client data
    $companyName = mysqli_real_escape_string($conn, $_POST['companyName']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $contactEmail = mysqli_real_escape_string($conn, $_POST['contactEmail']);
}
$title = mysqli_real_escape_string($conn, $_POST['title']);
$dateCreated = $_POST['dateCreated'];

$personalLetter = mysqli_real_escape_string($conn, $_POST['personalLetter']);

$deliverables = $_POST['deliverables'];
$quantities = $_POST['quantity']; // Corresponding quantities array
$deliverablesWithQuantities = array_combine($deliverables, $quantities);


$newCompany = "false";
$client_id = "";
$lastCompanyId = "";



?>


<?php
if (isset ($_SESSION['user_id'])) {
    // check if session user_id is set
    $user_id = $_SESSION['user_id'];

    // sql query
    // replace * with "employee_id" if you only need that
    $get_employee = "SELECT * FROM employees where user_id = " . $user_id;

    $result = $conn->query($get_employee);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // setting variables
        $employee_id = $row["employee_id"];
        $employee_Fname = $row['employee_first_name'];
        $employee_Lname = $row['employee_last_name'];
        $employeFullName = "$employee_Fname " . "$employee_Lname";


        $user_id = $row["user_id"];
    } else {
        echo "0 results";
    }
    echo "UserID: $user_id. EmployeeID: $employee_id";
}
?>



<?php

if (isset ($_POST['existingClientID'])) {
    $get_client = "SELECT * FROM clients where client_id = " . $existingClientID;

    $result = $conn->query($get_client);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // setting variables
        $client = $row["client_id"];
        $client_name = $row['client_name'];
        $companyName = $client_name;
    } else {
        echo "0 results";
    }

    $proposal_id = $existingClientID;
    //
    $sql3 = "INSERT INTO proposals (creation_date, proposal_title, proposal_letter, client_id, employee_id, employee_creator) VALUES ('$dateCreated', '$title', '$personalLetter', '$existingClientID', '$employee_id', '$employeFullName')";
    if ($conn->query($sql3)) {
        $lastProposalID = $conn->insert_id; // Get the ID of the last inserted company
        $proposal_id = $lastProposalID;
        //   echo "New proposal  created successfully";
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn->error;
    }

    $proposal_total = 0; // Initialize proposal total
    $sql = "INSERT INTO ordered_deliverables (deliverable_id, quantity, proposal_id) VALUES ";
    foreach ($deliverablesWithQuantities as $deliverableId => $quantity) {
        $sql .= "($deliverableId, $quantity, $lastProposalID), ";
        $getPrice = "SELECT price FROM deliverables WHERE deliverable_id = '$deliverableId'";
        $result = mysqli_query($conn, $getPrice);
        if (mysqli_error($conn)) {
            $message = "<p>There was a problem searching</p>";
        } else {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $deliverable_price = $row['price'];
                    $proposal_total += $deliverable_price * $quantity; // Update proposal total
                }
            } else {
                $message = "<p>Sorry no records to show</p>";
            }
        }
    }
    
    $sql = rtrim($sql, ", "); // Remove the trailing comma and space
    if (mysqli_query($conn, $sql)) { // Execute the SQL query to insert ordered deliverables
        $sql2 = "UPDATE proposals SET value = $proposal_total WHERE proposal_id = $existingClientID";
        if (mysqli_query($conn, $sql2)) { // Execute the SQL query to update proposal value
            echo "<p>Proposal record updated successfully</p>";
        } else {
            echo "Error updating proposal record: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting ordered deliverables: " . mysqli_error($conn);
    }

    $sql = rtrim($sql, ", "); // Remove the trailing comma and space
    if (mysqli_query($conn, $sql)) { // Execute the SQL query to insert ordered deliverables
        $sql2 = "UPDATE proposals SET value = $proposal_total WHERE proposal_id = $lastProposalID";
        if (mysqli_query($conn, $sql2)) { // Execute the SQL query to update proposal value
            echo "<p>Proposal record updated successfully</p>";
        } else {
            echo "Error updating proposal record: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting ordered deliverables: " . mysqli_error($conn);
    }
    


    // You can fetch additional data about the existing client from your database if needed
} else {
    // If 'Use Existing Client' is not checked, handle the new client data
    $sql1 = "INSERT INTO clients (client_name) VALUES ('$companyName')";
    if ($conn->query($sql1)) {
        $lastCompanyId = $conn->insert_id; // Get the ID of the last inserted company
        // Insert contact information into the second table
        // echo "New client created successfully";
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
    }
    $sql2 = "INSERT INTO contacts (first_name, last_name, email, client_id) VALUES ('$firstName', '$lastName', '$contactEmail', '$lastCompanyId')";
    if ($conn->query($sql2)) {
        // echo "New contact created successfully";
    } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
    }
    $sql3 = "INSERT INTO proposals (creation_date, proposal_title, proposal_letter, client_id, employee_id, employee_creator) VALUES ('$dateCreated', '$title', '$personalLetter', '$lastCompanyId', '$employee_id', '$employeFullName')";
    if ($conn->query($sql3)) {
        $lastProposalID = $conn->insert_id; // Get the ID of the last inserted company
        $proposal_id = $lastProposalID;
        //   echo "New proposal  created successfully";
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn->error;
    }

    $proposal_total = 0; // Initialize proposal total
    $sql = "INSERT INTO ordered_deliverables (deliverable_id, quantity, proposal_id) VALUES ";
    foreach ($deliverablesWithQuantities as $deliverableId => $quantity) {
        $sql .= "($deliverableId, $quantity, $lastProposalID), ";
        $getPrice = "SELECT price FROM deliverables WHERE deliverable_id = '$deliverableId'";
        $result = mysqli_query($conn, $getPrice);
        if (mysqli_error($conn)) {
            $message = "<p>There was a problem searching</p>";
        } else {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $deliverable_price = $row['price'];
                    $proposal_total += $deliverable_price * $quantity; // Update proposal total
                }
            } else {
                $message = "<p>Sorry no records to show</p>";
            }
        }
    }
    
    $sql = rtrim($sql, ", "); // Remove the trailing comma and space
    if (mysqli_query($conn, $sql)) { // Execute the SQL query to insert ordered deliverables
        $sql2 = "UPDATE proposals SET value = $proposal_total WHERE proposal_id = $lastProposalID";
        if (mysqli_query($conn, $sql2)) { // Execute the SQL query to update proposal value
            echo "<p>Proposal record updated successfully</p>";
        } else {
            echo "Error updating proposal record: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting ordered deliverables: " . mysqli_error($conn);
    }
    
}



//$lastProposalID = 12; // comment this out



if ($lastCompanyId) {
    $client_id = $lastCompanyId;
} else if ($existingClientID) {
    $client_id = $existingClientID;
} else {

}

if (isset ($_SESSION['user_id'])) {
    $currentUser = $_SESSION['user_id'];
    echo "<p>user id: $currentUser";

}



?>
</div>


<?php 
       header("Location: proposal-details.php?proposal_id=$proposal_id");
?>