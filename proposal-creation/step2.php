<h2 class="mb-4">Initialize Proposal</h2>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'Use Existing Client' is checked
    if (isset($_POST['clients'][0]) && $_POST['clients'][0] !== "0") {
        // If 'Use Existing Client' is checked, handle the existing client data
        $existingClientID = $_POST['clients'][0]; // Assuming it's a single select
        //echo $_POST['clients'][0];

        // You can fetch additional data about the existing client from your database if needed
    } else {
        // If 'Use Existing Client' is not checked, handle the new client data
        $companyName = $_POST['companyName'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $contactEmail = $_POST['contactEmail'];
    }
}
?>

<div class="progress mb-4">
    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<form action="proposal-creation.php" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="step" value="3">

    <?php if (isset($existingClientID)) { ?>
        <?php //echo $existingClientID; 
        ?>
        <input type="hidden" name="existingClientID" value="<?php echo $existingClientID; ?>">
    <?php } else { ?>
        <?php //echo $companyName;  
        ?>
        <input type="hidden" name="companyName" value="<?php echo $companyName; ?>">
        <input type="hidden" name="firstName" value="<?php echo $firstName; ?>">
        <input type="hidden" name="lastName" value="<?php echo $lastName; ?>">
        <input type="hidden" name="contactEmail" value="<?php echo $contactEmail; ?>">
    <?php } ?>

    <div class="form-group">
        <label for="title">Title of Proposal:</label>
        <input type="text" class="form-control" id="title" name="title" required>
        <!-- Error message placed here, outside the field box -->
        <div class="alert alert-danger mt-2" id="titleError" style="display: none;">Please provide a title for the proposal.</div>
    </div>

    <div class="form-group">
        <label for="dateCreated">Date Created:</label>
        <input type="date" class="form-control" id="dateCreated" name="dateCreated" required>
        <!-- Error message placed here, outside the field box -->
        <div class="alert alert-danger mt-2" id="dateCreatedError" style="display: none;">Please provide the date the proposal was created.</div>
    </div>

    <div class="mt-4">
        <a onclick="history.go(-1)" class="btn btn-secondary" id="previousButton">Previous</a>
    
        <button type="submit" class="btn btn-primary">Next</button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('.needs-validation');
        const titleInput = document.getElementById('title');
        const dateCreatedInput = document.getElementById('dateCreated');
        const titleError = document.getElementById('titleError');
        const dateCreatedError = document.getElementById('dateCreatedError');

        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                if (!titleInput.value) {
                    titleError.style.display = 'block';
                } else {
                    titleError.style.display = 'none';
                }
                if (!dateCreatedInput.value) {
                    dateCreatedError.style.display = 'block';
                } else {
                    dateCreatedError.style.display = 'none';
                }
            }
            form.classList.add('was-validated');
        }, false);
    });
</script>