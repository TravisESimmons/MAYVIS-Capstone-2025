<div class="step-header">
    <h2 class="step-title">
        <i class="fas fa-user-plus me-2"></i>Client Information
    </h2>
    <p class="step-description">Add a new client or select an existing one to start your proposal</p>
</div>

<?php
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

<form action="proposal-creation.php" method="POST" class="needs-validation modern-form" id="proposalForm" novalidate>
    <input type="hidden" name="step" value="2">

    <!-- Client Type Toggle -->
    <div class="client-type-toggle">
        <div class="form-check-modern">
            <input class="form-check-input" type="checkbox" id="existingClientCheckbox">
            <label class="form-check-label" for="existingClientCheckbox">
                <i class="fas fa-users me-2"></i>Use Existing Client
            </label>
        </div>
    </div>

    <!-- New Client Form -->
    <div id="newClientForm" class="client-form-section">
        <div class="form-grid">
            <div class="form-group">
                <label for="companyName" class="form-label">
                    <i class="fas fa-building me-1"></i>Company Name
                </label>
                <input type="text" class="form-control" id="companyName" name="companyName" 
                       placeholder="Enter company name" required>
                <div class="alert alert-danger" id="companyNameError" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i>Company name is required
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="firstName" class="form-label">
                        <i class="fas fa-user me-1"></i>First Name
                    </label>
                    <input type="text" class="form-control" id="firstName" name="firstName" 
                           placeholder="Enter first name" required>
                    <div class="alert alert-danger" id="firstNameError" style="display: none;">
                        <i class="fas fa-exclamation-circle me-1"></i>First name is required
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastName" class="form-label">
                        <i class="fas fa-user me-1"></i>Last Name
                    </label>
                    <input type="text" class="form-control" id="lastName" name="lastName" 
                           placeholder="Enter last name" required>
                    <div class="alert alert-danger" id="lastNameError" style="display: none;">
                        <i class="fas fa-exclamation-circle me-1"></i>Last name is required
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="contactEmail" class="form-label">
                    <i class="fas fa-envelope me-1"></i>Contact Email
                </label>
                <input type="email" class="form-control" id="contactEmail" name="contactEmail" 
                       placeholder="Enter email address" required>
                <div class="alert alert-danger" id="contactEmailError" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i>Valid email address is required
                </div>
                <div class="alert alert-warning" id="emailWarning" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-1"></i>This email already exists in our records
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Client Selection -->
    <div id="existingClientSelection" class="client-form-section" style="display: none;">
        <div class="form-group">
            <label for="clients" class="form-label">
                <i class="fas fa-search me-1"></i>Select Existing Client
            </label>
            <select id="clients" name="clients[]" class="form-control form-select">
                <option value="0">Choose a client...</option>
                <?php
                $sql = "SELECT * FROM clients ORDER BY client_name ASC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['client_id'] . "'>" . htmlspecialchars($row['client_name']) . "</option>";
                    }
                } else {
                    echo "<option disabled>No clients found</option>";
                }
                ?>
            </select>
            <div class="alert alert-danger" id="clientSelectionError" style="display: none;">
                <i class="fas fa-exclamation-circle me-1"></i>Please select an existing client
            </div>
        </div>
    </div>

    <!-- Form Error Message -->
    <div class="alert alert-danger" id="formError" style="display: none;">
        <i class="fas fa-exclamation-circle me-1"></i>Please fill out all required fields correctly
    </div>
</form>

<div class="wizard-navigation">
    <a href="/mayvis/proposals.php" class="btn-wizard btn-secondary-wizard">
        <i class="fas fa-arrow-left me-1"></i>Cancel
    </a>
    <button type="submit" form="proposalForm" class="btn-wizard btn-primary-wizard" id="nextButton">
        Next Step
        <i class="fas fa-arrow-right ms-1"></i>
    </button>
</div>

<style>
    .step-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--bg-secondary);
    }

    .step-title {
        color: var(--text-dark);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .step-description {
        color: var(--text-light);
        margin: 0;
        font-size: 1rem;
    }

    .client-type-toggle {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-check-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin: 0;
        accent-color: var(--primary-color);
    }

    .client-form-section {
        transition: var(--transition);
        opacity: 1;
    }

    .client-form-section.hidden {
        opacity: 0.3;
        pointer-events: none;
    }

    .form-grid {
        display: grid;
        gap: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        appearance: none;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .step-title {
            font-size: 1.25rem;
        }
        
        .client-type-toggle {
            padding: 1rem;
        }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const existingClientCheckbox = document.getElementById("existingClientCheckbox");
    const newClientForm = document.getElementById("newClientForm");
    const existingClientSelection = document.getElementById("existingClientSelection");
    const clientsDropdown = document.getElementById("clients");
    const inputs = document.querySelectorAll('#companyName, #firstName, #lastName, #contactEmail');
    const formError = document.getElementById("formError");
    const nextButton = document.getElementById("nextButton");

    // Toggle between new and existing client forms
    existingClientCheckbox.addEventListener("change", function () {
        if (existingClientCheckbox.checked) {
            newClientForm.style.display = "none";
            existingClientSelection.style.display = "block";
            clientsDropdown.required = true;
            inputs.forEach(input => {
                input.required = false;
                clearFieldError(input);
            });
        } else {
            newClientForm.style.display = "block";
            existingClientSelection.style.display = "none";
            clientsDropdown.required = false;
            clearFieldError(clientsDropdown);
            inputs.forEach(input => {
                input.required = true;
            });
        }
        formError.style.display = "none";
    });

    // Email validation for existing contacts
    const contacts = <?php echo json_encode($contacts); ?>;
    const emailInput = document.getElementById("contactEmail");
    const emailWarning = document.getElementById("emailWarning");

    emailInput.addEventListener("input", function () {
        const enteredEmail = emailInput.value.trim();
        if (enteredEmail === '') {
            emailWarning.style.display = "none";
        } else {
            if (contacts.includes(enteredEmail)) {
                emailWarning.style.display = "block";
                emailInput.classList.add('is-invalid');
            } else {
                emailWarning.style.display = "none";
                emailInput.classList.remove('is-invalid');
            }
        }
    });

    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', function() {
            if (input.value.trim()) {
                clearFieldError(input);
            }
        });
    });

    clientsDropdown.addEventListener('change', function() {
        if (clientsDropdown.value !== "0") {
            clearFieldError(clientsDropdown);
        }
    });

    function validateField(e) {
        const field = e.target;
        if (!field.value.trim()) {
            showFieldError(field);
        } else {
            clearFieldError(field);
        }
    }

    function showFieldError(field) {
        field.classList.add('is-invalid');
        const errorElement = document.getElementById(field.id + 'Error');
        if (errorElement) errorElement.style.display = 'block';
    }

    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        const errorElement = document.getElementById(field.id + 'Error');
        if (errorElement) errorElement.style.display = 'none';
    }

    // Form submission validation
    const form = document.querySelector('form.needs-validation');
    form.addEventListener('submit', function (event) {
        let isValid = true;
        formError.style.display = "none";

        if (!existingClientCheckbox.checked) {
            // Validate new client form
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    showFieldError(input);
                    isValid = false;
                }
            });

            // Check for email conflicts
            const enteredEmail = emailInput.value.trim();
            if (enteredEmail && contacts.includes(enteredEmail)) {
                emailWarning.style.display = "block";
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
        } else {
            // Validate existing client selection
            if (clientsDropdown.value === "0") {
                showFieldError(clientsDropdown);
                isValid = false;
            }
        }

        if (!isValid) {
            event.preventDefault();
            formError.style.display = "block";
            // Smooth scroll to error
            formError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            // Add loading state
            nextButton.disabled = true;
            nextButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
        }
    });
});
</script>