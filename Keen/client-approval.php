<?php
$title = "Client Proposal View";
include 'includes/header-new.php';
include 'connect.php';

$proposal_id = $_GET['proposal_id'];

// Check if the proposal has been viewed and update the 'seen' flag
$sql_update_seen = "UPDATE proposals SET seen = 1 WHERE proposal_id = '$proposal_id'";
mysqli_query($conn, $sql_update_seen);

$proposal_title = $proposal_letter = $creation_date = $status_message = $value = $client_name = $employee_Fname = $employee_Lname = "";
$status_badge = $status = "";


// Fetching the proposal details
$sql = "SELECT p.*, e.employee_first_name, e.employee_last_name, c.client_name
        FROM proposals p
        JOIN employees e ON p.employee_id = e.employee_id
        JOIN clients c ON p.client_id = c.client_id
        WHERE p.proposal_id = '$proposal_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $proposal_title = $row['proposal_title'];
    $proposal_letter = $row['proposal_letter'];
    $creation_date = $row['creation_date'];
    $status = $row['status'];
    $value = $row['value'];
    $client_name = $row['client_name'];
    $employee_Fname = $row['employee_first_name'];
    $employee_Lname = $row['employee_last_name'];

    if ($status == "1") {
        $status_message = "Approval status: Waiting for approval";
        $status_badge = '<span class="badge badge-info">&#10070;</span>';
    } elseif ($status == "0") {
        $status_message = "Approval status: Proposal Denied";
        $status_badge = '<span class="badge badge-danger">&#10008;</span>';
    } elseif ($status == "2") {
        $status_message = "Approval status: Proposal Approved";
        $status_badge = '<span class="badge badge-success">&#10004;</span>';
    }
}

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
}
?>

<body>

    <body>
        <?php


        $sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";

        // echo $sql; 
        $result = mysqli_query($conn, $sql);

        if (mysqli_error($conn)) {
            $message = "<p>There was a problem searching</p>";
        } else {
            if (mysqli_num_rows($result) > 0) {
                $display = "<div class=\"bg-dark text-light justify-content-center container-lg\" >";
                while ($row = mysqli_fetch_assoc($result)) {
                    $proposal_title = $row['proposal_title'];
                    $proposal_letter = $row['proposal_letter'];
                    $client_response = $row['client_response'];
                    $second_sig = $row['second_sig'];
                    $employee_creator = $row['employee_creator'];
                    $creation_date = $row['creation_date'];
                    $status = $row['status'];
                    $value = $row['value'];
                    $signature = $row['signature'];

                    $client_id = $row['client_id'];
                    $employee_id = $row['employee_id'];
                    $sql2 = "SELECT * FROM employees WHERE employee_id = '$employee_id'";

                    // echo $sql; 
                    $result2 = mysqli_query($conn, $sql2);
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $employee_Fname = $row['employee_first_name'];
                        $employee_Lname = $row['employee_last_name'];
                    }

                    if (mysqli_error($conn)) {
                        $message = "<p>There was a problem searching</p>";
                    }

                    if ($status === "1") {
                        $setStatus = "";
                        $setStatus .= "><p>Approval status: Waiting for approval";
                        $setStatus .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
              </svg></p></div>';
                    } elseif ($status === "0") {
                        $setStatus = "";
                        $setStatus .= "class='bg-danger text-light p-2'><p>Approval status: Proposal Denied";
                        $setStatus .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
              </svg></p></div>';
                    } elseif ($status === "2") {
                        $setStatus = "";
                        $setStatus .= "class='bg-success text-ligh p-2t'><p>Approval status: Proposal Approved";
                        $setStatus .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
              </svg></p></div>';
                    } else {
                        echo "status error";
                    }


                    $display .= "<div class=\"bg-dark text-light\">";

                    $display .= "<h2>Detailed View of <span class='font-weight-bold'>$proposal_title</span></h2>";
                    $display .= "<div>";


                    $display .= "<h3>Personal Letter: </h3>";
                    $display .= "$proposal_letter";

                    $display .= "<p>Proposal Value: <span class='font-weight-bold'>$$value</span</p>";

                    $display .= "</div>";

                    $get_client = "SELECT * FROM clients where client_id= " . $client_id;

                    $result = $conn->query($get_client);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        // setting variables
                        $client_name = $row['client_name'];
                    } else {
                        echo "0 results";
                    }
                    $display .= "<p>Client : <span class='font-weight-bold'>$client_name</span></p>";
                    $display .= "<p class=\"mb-3\">Created by: <span class='font-weight-bold'> $employee_creator</span>";
                    $display .= "<p class=\"mb-3\">Date Created: <span class='font-weight-bold'>$creation_date</span></p>";


                    if ($client_response !== "" && $client_response !== null) {

                        $display .= "<p>Client Response: $client_response</p>";
                    } else {
                        $display .= "";
                    }


                    if ($signature !== "" && $signature !== null) {

                        $display .= "<p>Signed By: $signature</p>";
                    } else {
                        $display .= "";
                    }

                    $display .= '       
                ';

                    $display .= "<div $setStatus </p></div>";



                    $display .= "<div class='col-3>'";
                    $display .= "<hr>";
                    $display .= "<h2 class='mt-4 mb-4'>Ordered Deliverables</h2>";


                    $get_deliverables = "
                    SELECT DISTINCT od.deliverable_id, od.quantity, d.price, d.title, d.description
                    FROM ordered_deliverables od
                    JOIN deliverables d ON od.deliverable_id = d.deliverable_id
                    WHERE od.proposal_id = $proposal_id
                ";
                    $result = $conn->query($get_deliverables);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Setting variables
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            $title = $row['title'];
                            $description = $row['description'];

                            // Displaying data
                            $display .= "<h3> $title</h3>";
                            $display .= "<p>Description: $description</p>";
                            $display .= "<p>Deliverable price: $price</p>";
                            $display .= "<p>Quantity: $quantity</p>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $display .= '</div>';
                    $display .= "</div>";





                    $display .= "</div>";
                }


                $display .= "</div>";
            }

            $display .= " </div>";
            echo $display;
        }



        ?>
        <div class="container-lg">
            <?php




            ?>

            <?php
            if ($status === "0" || $status === "2") {
                //echo "status: $status";
                $hideform = "d-none";
            } else {
                $hideform = "";
            }

            ?>
            <?php
            //echo "<p>sig: $second_sig</p>";
            if ($second_sig === "1") {
                $second_display = "            
            <form action='second-approval-submit.php?proposal_id=$proposal_id' method='POST'
            class='needs-validation' novalidate>";


                $second_display .= '          
            <label for="signature">Second Signature:</label><br>
            <input type="text" id="signature" name="signature" class="form-control" required><br><br>
            <div class="invalid-feedback">
                Please provide a digital signature
            </div>
            
            
            <div class="form-group">
            <label for="response"> Second Response:</label><br>
            <textarea id="response" name="response" rows="4" cols="50" required></textarea><br><br>
        </div>
        <div class="form-group">
        <label for="decision">Decision:</label><br>
        <select id="decision" name="decision" required>
            <option value="2">Approve</option>
            <option value="0">Denied</option>
        </select><br><br>
    </div>';


                $second_display .= '<input type="submit" value="Submit"class="btn-primary">';
                $second_display .= "</form>";
                echo $second_display;
            } else {

                //   echo "sig status: $second_sig";
            }
            ?>
            <form action="client-submit-approval.php?proposal_id=<?= $proposal_id ?>" method="POST" class="needs-validation <?php echo $hideform ?>" novalidate>
                <input type="hidden" name="step" value="2">

                <div class="form-group">

                    <label for="signature">Signature:</label><br>
                    <input type="text" id="signature" name="signature" class="form-control" required><br><br>
                    <div class="invalid-feedback">
                        Please provide a digital signature
                    </div>

                    <label for="second_sig">This will require another signature:</label><br>
                    <input type="checkbox" id="second_sig" name="second_sig" value="yes">

                </div>
                <div class="form-group">
                    <label for="response">Response:</label><br>
                    <textarea id="response" name="response" rows="4" cols="50" required></textarea><br><br>
                </div>


                <div class="form-group">
                    <label for="decision">Decision:</label><br>
                    <select id="decision" name="decision" required>
                        <option value="2">Approve</option>
                        <option value="0">Denied</option>
                    </select><br><br>
                </div>
                <input type="submit" value="Submit" class="btn-primary">
            </form>

            <!-- Terms and Conditions Link -->
            <div class="mt-3" data-step="11" data-intro="Read the terms and conditions here.">
                <a href="terms-conditions.php" class="btn btn-link">View Terms and Conditions</a>
            </div>

            <!-- Back to Dashboard Link -->
            <div class="mt-3" data-step="12" data-intro="Go back to the dashboard.">
                <a href="client-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>


        <?php include 'includes/footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    </body>

    </html>