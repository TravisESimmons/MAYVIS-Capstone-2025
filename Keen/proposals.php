<?php
include('connect.php');
$title = "Proposals";
include 'includes/header-new.php';

if (isset($_SESSION['user_id'])) {
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
        $user_id = $row["user_id"];
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$proposals_per_page = 4;
$offset = ($page - 1) * $proposals_per_page;

$sql = "SELECT * FROM proposals";

if (!empty($search)) {
    $sql .= " WHERE proposal_title LIKE '%$search%' OR client_id IN (SELECT client_id FROM clients WHERE client_name LIKE '%$search%')";
}

$sql .= " ORDER BY creation_date DESC LIMIT $proposals_per_page OFFSET $offset";

$result = $conn->query($sql);
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <div class="container">
        <div class="">
            <h2 class="my-4">All MAYVIS Created Proposals</h2>
            <div class="mb-4">
                <a href="proposal-creation.php" class="btn btn-primary mr-3"><span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                </svg>
                    </span>Create Proposal</a>
                <a href="your-proposals.php" class="btn btn-secondary">Your Proposals</a>
                <!-- <a href="templates.php" class='btn btn-success'>Go to Templates</a> -->
            </div>
        </div>

        <div class="flex">
            <?php
            if (isset($_SESSION['user_id'])) {
                // echo "<a href='proposal-creation.php' class='btn btn-primary mb-3'>Create Proposal</a>";

                echo "
                <form method='get' action='' class='row'>
                    <div class='form-group col-6 pr-0'>
                        <input type='text' name='search' class='form-control rounded-0 rounded-left border-0 rounded-left' placeholder='Search by Proposal Title or Company Name' value='$search'>
                    </div>
                    <div class='col flex pl-0'>
                        <button type='submit' class='btn btn-light rounded-0 rounded-right border-light'><span class=\"mr-3\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-search\" viewBox=\"0 0 16 16\">
                        <path d=\"M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0\"/>
                      </svg></span>Search</button>
                        <!-- <a href='your-proposals.php' class='ml-2'>Reset</a> -->
                    </div>
                </form>
                ";

                $output = "";
                $sent_message = array("0"=>"Unsent", "1"=>"Sent");
                $sent_badge = array("0"=>"badge-secondary", "1"=>"badge-light");
                $approval_message = array("0"=>"Denied", "1"=>"Unapproved", "2"=>"Approved");
                $approval_badge = array("0"=>"badge-danger", "1"=>"badge-secondary", "2"=>"badge-success");
                while ($row = $result->fetch_object()) {
                    $proposal_id = $row->proposal_id;
                    $client_id = $row->client_id;
                    $proposal_title = $row->proposal_title;
                    $proposal_letter = $row->proposal_letter;
                    $creation_date = $row->creation_date;
                    $sent_status = $row->sent_status;
                    $approval_status = $row->status;
                    $get_client = "SELECT * FROM clients where client_id= " . $client_id;
                    $result2 = $conn->query($get_client);

                    if ($result2->num_rows > 0) {
                        $row = $result2->fetch_assoc();
                        $client_name = $row['client_name'];
                    }
                    // start div
                    $output .= "<div class=\"my-4 p-3 shadow-sm rounded\">";
                    // header stuff
                    $output .= "<h3 class=\"mb-0\">$proposal_title</h3>";
                    $output .= "<h6 class=\"text-muted\">$client_name - $creation_date</h6>";

                    // statuses
                    $output .= "<p class=\"mb-4\">

                    <span class=\"badge $sent_badge[$sent_status] mr-2 px-2\">$sent_message[$sent_status]</span>
                    <span class=\"badge $approval_badge[$approval_status] mr-2 px-2\">$approval_message[$approval_status]</span>
                    
                    </p>";
                
                    // button
                    $output .= "<a href='proposal-details.php?proposal_id=$proposal_id' class='btn btn-primary btn-sm'>View Details
                    <span><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-arrow-right\" viewBox=\"0 0 16 16\">
                    <path fill-rule=\"evenodd\" d=\"M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8\"/>
                  </svg></span>
                    </a>";
                    // end div
                    $output .= "</div>";
                }
                echo $output;

                // Pagination
                $total_pages_sql = "SELECT COUNT(*) AS total FROM proposals";
                $total_pages_result = $conn->query($total_pages_sql);
                $total_pages_row = $total_pages_result->fetch_assoc();
                $total_pages = ceil($total_pages_row['total'] / $proposals_per_page);

                echo "<nav aria-label='Page navigation'>";
                echo "<ul class='pagination justify-content-center'>";
                if ($page > 1) {
                    echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "&search=$search'>&laquo; Previous</a></li>";
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i&search=$search'>$i</a></li>";
                }
                if ($page < $total_pages) {
                    echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=$search'>Next &raquo;</a></li>";
                }
                echo "</ul>";
                echo "</nav>";
            } else {
                echo "<h3>Please Sign in to view Proposals</h3>";
            }
            ?>
        </div>

    </div>


</body>

</html>