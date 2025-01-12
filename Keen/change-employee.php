<?php 
$title = "Change Author";
$proposal_id = $_GET['proposal_id'];

include 'includes/header-new.php';
include 'connect.php';

$sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";

// echo $sql; 
$result = mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    $message = "<p>There was a problem searching</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $employee_creator = $row['employee_creator'];
    }
}

?>

<form action="change-employee-submit.php?proposal_id=<?php echo $proposal_id?>" method="POST" class="needs-validation" novalidate>
<div class="form-group container-lg">

        <label for="employee-name">Change Proposal Creator</label>
        <input type="text" class="form-control mb-4" id="employee-name" name="employee-name" value="<?php echo htmlspecialchars($employee_creator); ?>"required>
        <div class="invalid-feedback">
            Please provide a valid name
        </div>
        <input type="submit" value="Submit" class="btn btn-primary">
    <a href="proposal-details.php?proposal_id=<?php echo $proposal_id ?>" class="btn btn-danger">Cancel</a>
    </div>


</form>