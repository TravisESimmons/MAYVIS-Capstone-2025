<?php 
include 'connect.php';
$title = "Edit Contact";
include 'includes/header-new.php';

$contact_id = $_GET['contact_id'];

$sql = "SELECT * FROM contacts WHERE contact_id = '$contact_id'";

// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];


    }
}


?>
<div class='container'>
<form action="contact-edit-submit.php?contact_id=<?php echo $contact_id?>" method="POST" class="needs-validation" novalidate>
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
            <label for="contactEmail">Contact Email:</label>
            <input type="email" class="form-control" id="contactEmail" name="contactEmail" value="<?php echo htmlspecialchars($email); ?>" required>
            <div class="invalid-feedback">
                Please provide a valid email address.
            </div>
        </div>
    </div>
    <input type="submit" value="Submit" class="btn btn-primary">
    <a href="employee-usercontrol.php" class="btn btn-danger">Cancel</a>
</form>
</div>
