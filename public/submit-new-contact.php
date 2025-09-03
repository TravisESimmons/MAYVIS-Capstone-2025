<?php
$title = "Add New Contact";
include 'includes/header-new.php';
include 'connect.php';

// Initialize variables
$success_message = '';
$error_message = '';
$first_name = '';
$last_name = '';
$email = '';
$client_id = '';
$company_name = '';
$create_new_company = false;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $create_new_company = isset($_POST['create_new_company']) && $_POST['create_new_company'] === '1';
    
    // Validation
    $errors = [];
    
    if (empty($first_name)) {
        $errors[] = "First name is required";
    }
    
    if (empty($last_name)) {
        $errors[] = "Last name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    
    if ($create_new_company) {
        $company_name = trim($_POST['company_name'] ?? '');
        if (empty($company_name)) {
            $errors[] = "Company name is required when creating a new company";
        }
    } else {
        $client_id = $_POST['client_id'] ?? '';
        if (empty($client_id)) {
            $errors[] = "Please select an existing company or create a new one";
        }
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $check_email = "SELECT contact_id FROM contacts WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "This email address is already associated with another contact";
        }
    }
    
    // If no errors, process the submission
    if (empty($errors)) {
        $conn->autocommit(false); // Start transaction
        
        try {
            $final_client_id = $client_id;
            
            // Create new company if requested
            if ($create_new_company) {
                $create_client = "INSERT INTO clients (client_name) VALUES (?)";
                $stmt = $conn->prepare($create_client);
                $stmt->bind_param("s", $company_name);
                
                if (!$stmt->execute()) {
                    throw new Exception("Failed to create new company");
                }
                
                $final_client_id = $conn->insert_id;
            }
            
            // Create the contact
            $create_contact = "INSERT INTO contacts (first_name, last_name, email, client_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($create_contact);
            $stmt->bind_param("sssi", $first_name, $last_name, $email, $final_client_id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to create contact");
            }
            
            $conn->commit();
            $success_message = "Contact successfully created!";
            
            // Clear form fields on success
            $first_name = '';
            $last_name = '';
            $email = '';
            $client_id = '';
            $company_name = '';
            $create_new_company = false;
            
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = $e->getMessage();
        }
        
        $conn->autocommit(true);
    } else {
        $error_message = implode('<br>', $errors);
    }
}

// Get existing clients for dropdown
$clients_query = "SELECT client_id, client_name FROM clients ORDER BY client_name ASC";
$clients_result = $conn->query($clients_query);
?>

<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-color: #ec4899;
        --accent-color: #06b6d4;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --border-radius: 12px;
        --border-radius-lg: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --error-color: #ef4444;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .main-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Page Header */
    .page-header {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .page-header .content {
        position: relative;
        z-index: 2;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Navigation */
    .nav-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-nav {
        background: white;
        color: var(--text-dark);
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .btn-nav:hover {
        color: var(--primary-color);
        text-decoration: none;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Form Container */
    .form-container {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    /* Alert Messages */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--error-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    /* Form Elements */
    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--bg-secondary);
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-label.required::after {
        content: " *";
        color: var(--error-color);
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        box-sizing: border-box;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Checkbox */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        border: 2px solid #e5e7eb;
        transition: var(--transition);
        cursor: pointer;
    }

    .checkbox-group:hover {
        border-color: var(--primary-color);
    }

    .checkbox-group input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: var(--primary-color);
    }

    .checkbox-label {
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        user-select: none;
    }

    /* Submit Button */
    .submit-btn {
        background: var(--bg-gradient);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        justify-content: center;
        width: 100%;
        margin-top: 2rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .form-container {
            padding: 2rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
    }

    /* Animation for company name field */
    .company-field {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out, margin 0.3s ease-out;
        margin-bottom: 0;
    }

    .company-field.active {
        max-height: 100px;
        margin-bottom: 1.5rem;
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-plus"></i>
                Add New Contact
            </h1>
            <p class="page-subtitle">Create a new contact and associate with a company</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/employee-usercontrol.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to User Control
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <?php if (!empty($success_message)): ?>
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div><?php echo $error_message; ?></div>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <!-- Contact Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Contact Information
                </h3>
                
                <div class="form-group">
                    <label for="first_name" class="form-label required">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-input" 
                           value="<?php echo htmlspecialchars($first_name); ?>" 
                           placeholder="Enter first name" required>
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label required">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-input" 
                           value="<?php echo htmlspecialchars($last_name); ?>" 
                           placeholder="Enter last name" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label required">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="<?php echo htmlspecialchars($email); ?>" 
                           placeholder="Enter email address" required>
                </div>
            </div>

            <!-- Company Association Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-building"></i>
                    Company Association
                </h3>

                <div class="form-group">
                    <div class="checkbox-group" onclick="toggleCompanyOption()">
                        <input type="checkbox" id="create_new_company" name="create_new_company" value="1" 
                               <?php echo $create_new_company ? 'checked' : ''; ?>>
                        <label for="create_new_company" class="checkbox-label">
                            Create New Company
                        </label>
                    </div>
                </div>

                <div class="form-group company-field" id="company-name-field">
                    <label for="company_name" class="form-label required">Company Name</label>
                    <input type="text" id="company_name" name="company_name" class="form-input" 
                           value="<?php echo htmlspecialchars($company_name); ?>" 
                           placeholder="Enter company name">
                </div>

                <div class="form-group" id="existing-company-field">
                    <label for="client_id" class="form-label required">Select Existing Company</label>
                    <select id="client_id" name="client_id" class="form-select">
                        <option value="">Choose a company...</option>
                        <?php while ($client = $clients_result->fetch_assoc()): ?>
                            <option value="<?php echo $client['client_id']; ?>" 
                                    <?php echo ($client_id == $client['client_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($client['client_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-plus-circle"></i>
                Create Contact
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize company field visibility
    toggleCompanyFields();
    
    // Add smooth animations on load
    const container = document.querySelector('.form-container');
    container.style.opacity = '0';
    container.style.transform = 'translateY(20px)';
    setTimeout(() => {
        container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 100);

    // Add loading state to submit button
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.submit-btn');
    
    form.addEventListener('submit', function() {
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Contact...';
        submitBtn.disabled = true;
    });
});

function toggleCompanyOption() {
    const checkbox = document.getElementById('create_new_company');
    checkbox.checked = !checkbox.checked;
    toggleCompanyFields();
}

function toggleCompanyFields() {
    const checkbox = document.getElementById('create_new_company');
    const companyNameField = document.getElementById('company-name-field');
    const existingCompanyField = document.getElementById('existing-company-field');
    const companyNameInput = document.getElementById('company_name');
    const clientSelect = document.getElementById('client_id');
    
    if (checkbox.checked) {
        companyNameField.classList.add('active');
        existingCompanyField.style.display = 'none';
        companyNameInput.required = true;
        clientSelect.required = false;
        clientSelect.value = '';
    } else {
        companyNameField.classList.remove('active');
        existingCompanyField.style.display = 'block';
        companyNameInput.required = false;
        companyNameInput.value = '';
        clientSelect.required = true;
    }
}

// Listen for checkbox changes
document.getElementById('create_new_company').addEventListener('change', toggleCompanyFields);
</script>

</body>
</html>
