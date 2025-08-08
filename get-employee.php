<?php
// Not meant to be the actual employee home page, just a default landing page for when logged in.
require_once("./login/classes/Login.php");

$login = new Login();


if ($login->isUserLoggedIn() == true) {
    // user is logged in; initialize the header variables
    $title = "Test";
    include("./includes/header-new.php");

    // include prepared statements because we will be editing user data
    // include("./process/prepared.php");

} else {
    // not logged in: redirect to the login page
    header("Location:./login/index.php");
}

// connect to database
include('connect.php');

?>

<div class="container">
    <?php
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
            $employee_first = $row["employee_first_name"];
            $employee_last = $row["employee_last_name"];
            $user_id = $row["user_id"];
        } else {
            echo "0 results";
        }

    }
    ?>
    <!-- displaying -->
    <h2>
        <?php echo $employee_first . $employee_last; ?>
    </h2>
    <p>Your employee ID:
        <?php echo $employee_id; ?>
    </p>
    <p>Your user ID:
        <?php echo $user_id; ?>
    </p>
</div>