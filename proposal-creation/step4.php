<h2 class="mb-4">Deliverables</h2>
<?php
if (isset($_POST['existingClientID'])) {
    $existingClientID = $_POST['existingClientID'];

    // You can fetch additional data about the existing client from your database if needed
} else {
    // If 'Use Existing Client' is not checked, handle the new client data
    $companyName = $_POST['companyName'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactEmail = $_POST['contactEmail'];
}
$title = $_POST['title'];
$dateCreated = $_POST['dateCreated'];

$personalLetter = $_POST['personalLetter'];
?>

<style>
    label {
        font-weight: bold;
        color: #ffff;
        /* White text color */
        margin-bottom: 0.5rem;
        /* Add some space between label and input */
        display: block;
        /* Display labels on their own line */
    }
</style>

<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="mt-4 text-dark">
    <form action="proposal-creation.php" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="step" value="5">
        <!-- Hidden inputs for passing existing data -->
        <?php echo isset($existingClientID) ? "<input type='hidden' name='existingClientID' value='$existingClientID'>" : ""; ?>
        <?php if (!isset($existingClientID)) { ?>
            <input type="hidden" name="companyName" value="<?php echo $companyName; ?>">
            <input type="hidden" name="firstName" value="<?php echo $firstName; ?>">
            <input type="hidden" name="lastName" value="<?php echo $lastName; ?>">
            <input type="hidden" name="contactEmail" value="<?php echo $contactEmail; ?>">
        <?php } ?>
        <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
        <input type="hidden" name="dateCreated" value="<?php echo htmlspecialchars($dateCreated); ?>">
        <input type="hidden" name="personalLetter" value='<?php echo $personalLetter; ?>'>

        <!-- Deliverables Selection -->
        <div class="col-md-12 px-0">
            <?php
            $sql = "SELECT * FROM deliverables";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div class="form-group">';
                echo '<label for="deliverables">Choose Deliverables:</label>';
                echo '<select id="deliverables" name="deliverables[]" multiple required class="form-control custom-select" style="height: 300px;">';
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['deliverable_id'] . "'>" . $row['title'] . " ($" . $row['price'] . ")</option>";
                }
                echo '</select>';
                echo '</div>';
            } else {
                echo "<p>No deliverables found.</p>";
            }
            ?>
            <div id="quantityInputs"></div>
            <div id="errorAlert" class="alert alert-danger d-none">
                Please select at least one deliverable.
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            var selectedDeliverables = $('#deliverables option:selected').length;
            if (selectedDeliverables === 0) {
                e.preventDefault(); // Prevent form submission
                $('#errorAlert').removeClass('d-none'); // Show error alert
            } else {
                $('#errorAlert').addClass('d-none'); // Hide error alert if deliverables are selected
            }
        });

        $('#deliverables').change(function() {
            $('#quantityInputs').empty(); // Clear previous quantity inputs
            $(this).find('option:selected').each(function() {
                var deliverableId = $(this).val();
                var deliverableTitle = $(this).text();
                $('#quantityInputs').append('<div class="form-group">' +
                    '<label for="quantity_' + deliverableId + '" style="color: #ffff;">Quantity for ' + deliverableTitle + ':</label>' + // Add colon here
                    '<input type="number" id="quantity_' + deliverableId + '" name="quantity[' + deliverableId + ']" class="form-control" value="1" min="1">' +
                    '</div>');
            });
        });
    });
</script>