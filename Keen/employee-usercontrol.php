<?php
$title = "User Control Panel";
include 'includes/header-new.php';
include 'connect.php';
?>

<div class="container">
    <div class="d-flex justify-content-between p-2">
        <div>
            <h3>Created Contacts</h3>
            <?php
            if (isset($_SESSION['user_id'])) {
                $sql = "SELECT * from contacts  ORDER BY contact_id ASC";
                // echo "<p>Showing proposals for employee_id = $employee_id</p>";
                $result = $conn->query($sql);
                $output = "";
                while ($row = $result->fetch_object()) {
                    $id_message = "";
                    $contact_id = $row->contact_id;

                    $first_name = $row->first_name;
                    $last_name = $row->last_name;

                    $user_id = $row->user_id;
                    $client_id = $row->client_id;

                    if (isset($user_id)) {
                        $id_message = $user_id;
                    } else {
                        $id_message = "not assigned";
                    }


                    $output .= "<div class='border border-secondary d-flex justify-content-between my-4 p-2'>";
                    $output .= "<div>";

                    $output .= "<p class='px-2'>$first_name $last_name</p>";
                    $output .= "<p class='px-2'>Company: $client_id</p>";
                    $output .= "</div>";

                    $output .= "<p class='px-2'>UserID: $id_message</p>";
                    $output .= "<div>";

                    $output .= "<a class='btn btn-danger' href='usercontrol-contact.php?contact_id=$contact_id' >Edit this contact</a>";
                    $output .= "</div>";





                    $output .= "</div>";
                }
                echo $output;
            } else {
                echo "<h3>Please Sign in to view</h3>";
            }
            ?>
        </div>
        <div>
            <h3>Existing Users</h3>
            <?php
            if (isset($_SESSION['user_id'])) {
                $sql = "SELECT * from users  ORDER BY user_id ASC";
                // echo "<p>Showing proposals for employee_id = $employee_id</p>";
                $result = $conn->query($sql);
                $output = "";
                while ($row = $result->fetch_object()) {
                    $user_id = $row->user_id;

                    $user_name = $row->user_name;

                    $user_email = $row->user_email;
                    $first_name = $row->first_name;
                    $last_name = $row->last_name;

                    $user_status = $row->user_status;


                    $output .= "<div class='border border-secondary d-flex justify-content-between my-4 p-2'>";
                    $output .= "<p class='px-3'>$first_name $last_name</p>";
                    $output .= "<div>";
                    $output .= "<p class='px-3'>Username: $user_name</p>";
                    $output .= "<p class='px-3'>Email: $user_email</p>";
                    $output .= "</div>";
                    $output .= "<div>";

                    $output .= "<a class='btn btn-danger' href='user-control-user.php?user_id=$user_id'>Edit this user</a>";
                    $output .= "</div>";




                    $output .= "</div>";
                }
                echo $output;
            } else {
                echo "<h3>Please Sign in to view</h3>";
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</div>

<?php
include 'includes/footer.php';

?>