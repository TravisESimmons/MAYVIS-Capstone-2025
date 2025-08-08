<?php
$title = "Employee Proposal View";
include 'includes/header-new.php';
include 'connect.php';


$proposal_id = $_GET['proposal_id'];


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
    echo $message;
}
?>

<body>

    <div class="container mt-5">
        <div class="proposal-details p-4 border rounded">

            <?php
            $sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_error($conn)) {
                $message = "<p>There was a problem searching</p>";
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $proposal_title = $row['proposal_title'];
                        $proposal_letter = $row['proposal_letter'];
                        $employee_creator = $row['employee_creator'];
                        $client_response = $row['client_response'];
                        $creation_date = $row['creation_date'];
                        $status = $row['status'];
                        $sentStatus = $row['sent_status'];
                        $value = $row['value'];
                        $client_id = $row['client_id'];
                        $employee_id = $row['employee_id'];
                        $sql2 = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
                        $result2 = mysqli_query($conn, $sql2);
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $employee_Fname = $row['employee_first_name'];
                            $employee_Lname = $row['employee_last_name'];
                        }

                        // Determine the approval status
                        $setStatus = "";
                        $statusText = "";
                        switch ($status) {
                            case "0":
                                $setStatus = "bg-danger text-light";
                                $statusText = "Proposal Denied";
                                break;
                            case "1":
                                $setStatus = "";
                                $statusText = "Waiting for approval";
                                break;
                            case "2":
                                $setStatus = "bg-success text-light";
                                $statusText = "Proposal Approved";
                                break;
                            default:
                                $statusText = "Status Error";
                        }

                        // Start displaying the proposal details
                        echo "<h2 class=\"mb-4\">Employee View of $proposal_title</h2>";
                        echo "<p class=\"mb-3\">Created by Employee: ";
                        if ($sentStatus === "0") {
                            // Allow editing if the proposal has not been sent
                            echo "<a href='change-employee.php?proposal_id=$proposal_id' class='font-weight-bold'>$employee_creator (Edit)</a>";
                        } else {
                            // Disable editing if the proposal has been sent
                            echo "<span class='font-weight-bold'>$employee_creator</span>";
                        }
                        echo "</p>";
                        echo "<p class=\"mb-3\">Creation Date: <span class='font-weight-bold'>$creation_date</span></p>";

                        // Display client name if available
                        $client_name = "N/A";
                        $get_client = "SELECT * FROM clients where client_id= " . $client_id;
                        $result = $conn->query($get_client);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $client_name = $row['client_name'];
                        }
                        echo "<p class=\"mb-3\">Client: <span class='font-weight-bold'>$client_name</span></p>";

                        // Display client response if available and status is not waiting for approval
                        if ($status !== "1") {
                            echo "<p class=\"mb-3\">Client Response:</p>";
                            echo "<p>$client_response</p>";
                        }

                        // Display proposal letter with option to edit
                        echo "<p class=\"mb-3\">Proposal Letter:</p>";
                        echo "$proposal_letter";
                        if ($sentStatus === "0") {
                            echo "<a href='change-letter.php?proposal_id=$proposal_id' class='btn btn-danger'>Edit Proposal Letter</a>";
                        }

                        // Display proposal status
                        echo "<div class=\"mb-3 $setStatus p-3 rounded\">";
                        echo "<p class=\"mb-0\">Approval status: $statusText</p>";
                        echo "</div>";

                        // Display price and allow editing if not sent
                        echo "<div class=\"mb-3\">";
                        echo "<p>Price: <span class='font-weight-bold'>$$value</span></p>";
                        if ($sentStatus === "0") {
                            echo "<a href='change-price.php?proposal_id=$proposal_id' class='btn btn-danger'>Edit Price</a>";
                        }
                        echo "</div>";

                        // Display additional actions based on sent status
                        if ($sentStatus === "0") {
                            echo "<a href='additional-contact-proposal.php?client_id=$client_id' class='btn btn-primary'>Add Another Contact</a>";
                            echo "<a href='send-now.php?proposal_id=$proposal_id' class='btn btn-success'>Send Now</a>";
                            echo "<p class=\"mt-2\">(You will no longer be able to make changes, and the client will be notified)</p>";
                        } elseif ($sentStatus === "1") {
                            echo "<p>Proposal successfully sent to client</p>";
                        }


                        // Display ordered deliverables
                        echo "<div class=\"mt-4\">";
                        echo "<h2>Ordered Deliverables</h2>";
                        $get_deliverables = "SELECT DISTINCT od.deliverable_id, od.quantity, d.price, d.title, d.description FROM ordered_deliverables od JOIN deliverables d ON od.deliverable_id = d.deliverable_id WHERE od.proposal_id = $proposal_id";
                        $result = $conn->query($get_deliverables);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $quantity = $row['quantity'];
                                $price = $row['price'];
                                $title = $row['title'];
                                $description = $row['description'];
                                echo "<h3>Deliverable: $title</h3>";
                                echo "<p>Description: $description</p>";
                                echo "<p>Deliverable price: $price</p>";
                                echo "<p>Quantity: $quantity</p>";
                            }
                        } else {
                            echo "No deliverables found.";
                        }
                        echo "</div>"; // Close ordered deliverables
                    }
                } else {
                    $message = "<p>Sorry no records to show</p>";
                }
            }
            ?>

        </div> <!-- Close proposal-details -->
    </div> <!-- Close container -->

    <div class="container mt-3 flex">
        <a href="proposals.php" class="btn btn-primary">Back to Proposals</a>
        <a href="employee-dashboard.php
" class="btn btn-secondary">Back to Dashboards</a>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <style>
        /* Custom styles for proposal details */
        /* body {
            background-color: #f8f9fa;
        } */

        /* .proposal-details {
            background-color: #fff;
            color: #212529;
            border: 1px solid #dee2e6;
        } */

        .proposal-details h2 {
            margin-top: 0;
        }

        .btn-info {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-info:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

</body>

</html>