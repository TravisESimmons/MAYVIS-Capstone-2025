<?php 
include 'connect.php';
$title = "Edit User";
include 'includes/header-new.php';

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE user_id = '$user_id'";

// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['user_email'];

        $user_name = $row['user_name'];


    }
}


?>
<div class='container'>
<form action="user-edit-submit.php?user_id=<?php echo $user_id?>" method="POST" class="needs-validation" novalidate>
<div class="form-group ">

        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($first_name); ?>" required>
            <div class="invalid-feedback">
                Please provide your first name.
            </div>
        </div>

        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($last_name); ?>" required>
            <div class="invalid-feedback">
                Please provide your last name.
            </div>
        </div>

        <div class="form-group">
            <label for="userName">User Name:</label>
            <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($user_name); ?>" required>
            <div class="invalid-feedback">
                Please provide your user name.
            </div>
        </div>

        <div class="form-group">
            <label for="userEmail">User Email:</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($email); ?>" required>
            <div class="invalid-feedback">
                Please provide a valid email address.
            </div>
        </div>
    </div>
    <input type="submit" value="Submit" class="btn btn-primary">
    <a href="employee-usercontrol.php" class="btn btn-danger">Cancel</a>

</form>
</div>
