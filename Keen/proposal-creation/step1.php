<div>
    <h2 class="mb-4">Add Client</h2>
    <?php
    // Check if form is submitted
    // Load contact table data
 // Load contact table data
 $contacts = array();
 $sql = "SELECT email FROM contacts";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
         $contacts[] = $row['email'];
     }
 }
    ?>
    <div>
        <?php
        // Check if form is submitted
        
        ?>
        <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <form action="proposal-creation.php" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="step" value="2">

        <div class="form-group">
            <label for="companyName">Company Name:</label>
            <input type="text" class="form-control" id="companyName" name="companyName" required>
            <!-- Error message placed here, outside the letter box -->
            <div class="alert alert-danger mt-2" id="companyNameError" style="display: none;">Please provide a company
                name.</div>
        </div>

        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
            <!-- Error message placed here, outside the letter box -->
            <div class="alert alert-danger mt-2" id="firstNameError" style="display: none;">Please provide your first
                name.</div>
        </div>

        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
            <!-- Error message placed here, outside the letter box -->
            <div class="alert alert-danger mt-2" id="lastNameError" style="display: none;">Please provide your last
                name.</div>
        </div>

        <div class="form-group">
            <label for="contactEmail">Contact Email:</label>
            <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
            <?php

            ?>
            <!-- Error message placed here, outside the letter box -->
            <div class="alert alert-danger mt-2" id="contactEmailError" style="display: none;">Please provide a valid
                email address.</div>
                <div class="alert alert-warning mt-2" id="emailWarning" style="display: none;">This email already exists in our records.</div>

        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="existingClientCheckbox">
            <label class="form-check-label" for="existingClientCheckbox">
                Use Existing Client
            </label>
        </div>

        <div id="existingClientSelection" style="display: none;" class="mt-4">
            <label for="clients">Choose Existing Client:</label>
            <select id="clients" name="clients[]" class="form-control" required>
                <?php
                $sql = "SELECT * FROM clients ORDER BY client_name ASC";
                $result = $conn->query($sql);
                echo "<option value='0'>Select Client</option>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['client_id'] . "'>" . $row['client_name'] . "</option>";
                    }
                } else {
                    echo "<option disabled>No clients found</option>";
                }
                ?>
            </select>
            <!-- Error message placed here, outside the letter box -->
            <div class="alert alert-danger mt-2" id="clientSelectionError" style="display: none;">Please select an
                existing client.</div>
        </div>
        <div class="mt-4">
            <a href="https://emah10.dmitstudent.ca/DMIT2590/Capstone/proposals.php" class="btn btn-danger">Cancel</a>
    
            <button type="submit" class="btn btn-primary" id="nextButton">Next</button>
        </div>
    </form>

    <!-- Error message placed here, outside the letter box -->
    <div class="alert alert-danger mt-2" id="formError" style="display: none;">Please fill out all required fields.
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const existingClientCheckbox = document.getElementById("existingClientCheckbox");
            const existingClientSelection = document.getElementById("existingClientSelection");
            const clientsDropdown = document.getElementById("clients");
            const inputs = document.querySelectorAll('#companyName, #firstName, #lastName, #contactEmail');
            const formError = document.getElementById("formError");
            const companyNameError = document.getElementById("companyNameError");
            const firstNameError = document.getElementById("firstNameError");
            const lastNameError = document.getElementById("lastNameError");
            const contactEmailError = document.getElementById("contactEmailError");
            const clientSelectionError = document.getElementById("clientSelectionError");
            const companyNameLabel = document.querySelector('label[for="companyName"]');
            const firstNameLabel = document.querySelector('label[for="firstName"]');
            const lastNameLabel = document.querySelector('label[for="lastName"]');
            const contactEmailLabel = document.querySelector('label[for="contactEmail"]');

            existingClientCheckbox.addEventListener("change", function () {
                if (existingClientCheckbox.checked) {
                    existingClientSelection.style.display = "block";
                    clientsDropdown.required = true;
                    inputs.forEach(input => {
                        input.required = false;
                        input.style.display = "none";
                        document.getElementById(input.id + "Error").style.display = "none";
                    });
                    companyNameLabel.style.display = "none";
                    firstNameLabel.style.display = "none";
                    lastNameLabel.style.display = "none";
                    contactEmailLabel.style.display = "none";
                } else {
                    existingClientSelection.style.display = "none";
                    clientsDropdown.required = false;
                    inputs.forEach(input => {
                        input.required = true;
                        input.style.display = "block";
                    });
                    companyNameLabel.style.display = "block";
                    firstNameLabel.style.display = "block";
                    lastNameLabel.style.display = "block";
                    contactEmailLabel.style.display = "block";
                }
            });

            const form = document.querySelector('form.needs-validation');

            form.addEventListener('submit', function (event) {
                let isValid = true;
                if (!existingClientCheckbox.checked) {
                    inputs.forEach((input, index) => {
                        if (!input.value) {
                            document.getElementById(input.id + "Error").style.display = "block";
                            isValid = false;
                        } else {
                            document.getElementById(input.id + "Error").style.display = "none";
                        }
                    });
                }

                if (existingClientCheckbox.checked && clientsDropdown.value === "0") {
                    clientSelectionError.style.display = "block";
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                    formError.style.display = "block";
                }
            });
        });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const contacts = <?php echo json_encode($contacts); ?>;
        const emailInput = document.getElementById("contactEmail");
        const emailWarning = document.getElementById("emailWarning");
        const form = document.getElementById("proposalForm");

        emailInput.addEventListener("input", function () {
            const enteredEmail = emailInput.value.trim();
            if (enteredEmail === '') {
                emailWarning.style.display = "none";
            } else {
                if (contacts.includes(enteredEmail)) {
                    emailWarning.style.display = "block";
                } else {
                    emailWarning.style.display = "none";
                }
            }
        });

        form.addEventListener('submit', function(event) {
            const enteredEmail = emailInput.value.trim();
            if (enteredEmail !== '' && contacts.includes(enteredEmail)) {
                emailWarning.style.display = "block";
                event.preventDefault();
            }
        });
    });
</script>

</div>