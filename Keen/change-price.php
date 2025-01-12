<?php 
$title = "Change Price";
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
        $price = $row['value'];
    }
}

?>

<form action="change-price-submit.php?proposal_id=<?php echo $proposal_id?>" method="POST" class="needs-validation" novalidate>
<div class="form-group container-lg">
        <h2 class="mb-3">Change Proposal Price</h2>
        <label for="new-price">New Price</label>
        <input type="text" class="form-control mb-3" id="new-price" name="new-price" value="<?php echo htmlspecialchars($price); ?>"required>
        <div class="invalid-feedback my-3">
            Please provide a valid price
        </div>
        <div class="mt-4">
            <input type="submit" value="Submit" class="btn btn-primary">
        <a href="proposal-details.php?proposal_id=<?php echo $proposal_id ?>" class="btn btn-danger">Cancel</a>
        </div>
        </div>

</form>