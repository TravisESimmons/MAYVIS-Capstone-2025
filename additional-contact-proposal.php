<?php 
$title = "Add another contact";

include 'includes/header-new.php';

$client_id = $_GET['client_id'];

include 'connect.php';

$sql = "SELECT * FROM clients WHERE client_id = '$client_id'";

// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $client_name = $row['client_name'];
    }
}

?>
<div class="container">
<h2>Add another Contact to: <?php echo $client_name ?></h2>
<form action="additional-contact-submit.php?client_id=<?php echo $client_id?>" method="POST" class="needs-validation" novalidate>
<div class="form-group">

        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
            <div class="invalid-feedback">
                Please provide your first name.
            </div>
        </div>

        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
            <div class="invalid-feedback">
                Please provide your last name.
            </div>
        </div>

        <div class="form-group">
            <label for="contactEmail">Contact Email:</label>
            <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
            <div class="invalid-feedback">
                Please provide a valid email address.
            </div>
        </div>
    </div>
    <input type="submit" value="Submit" class="btn btn-primary">

</form>
</div>
