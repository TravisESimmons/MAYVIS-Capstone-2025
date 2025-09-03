<?php
$title = "Add New Client";
include 'includes/header-new.php';
include 'connect.php';

// Handle form submission
$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = trim($_POST['client_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    // Validation
    if (empty($client_name)) {
        $errors[] = "Client name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Check if email already exists
    if (empty($errors)) {
        $check_email = $conn->prepare("SELECT client_id FROM clients WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $result = $check_email->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "A client with this email already exists.";
        }
        $check_email->close();
    }

    // Insert new client if no errors
    if (empty($errors)) {
        $sql = "INSERT INTO clients (client_name, email, phone, company, address, city, province, postal_code, notes, created_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $client_name, $email, $phone, $company, $address, $city, $province, $postal_code, $notes);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Client added successfully!";
            header("Location: clients.php");
            exit;
        } else {
            $errors[] = "Error adding client: " . $conn->error;
        }
        $stmt->close();
    }
}
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
        padding: 2rem;
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
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Navigation */
    .nav-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
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
        box-shadow: var(--shadow-xl);
        border: 1px solid #e5e7eb;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary-color);
    }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-row.two-columns {
        grid-template-columns: 1fr 1fr;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-label.required::after {
        content: '*';
        color: var(--error-color);
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        color: var(--text-dark);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-control:hover {
        border-color: var(--primary-color);
    }

    /* Textarea */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Submit Button */
    .submit-btn {
        background: var(--bg-gradient);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        font-size: 1rem;
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

    /* Alert Messages */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success-color);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--error-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .form-container {
            padding: 1.5rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.5rem;
        }

        .form-row.two-columns {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-plus"></i>
                Add New Client
            </h1>
            <p class="page-subtitle">Create a new client profile for your business</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/clients.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Clients
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-address-book"></i>
            Client Information
        </h2>

        <form method="POST" action="add-client.php" id="clientForm">
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Basic Information
                </h3>
                
                <div class="form-row two-columns">
                    <div class="form-group">
                        <label class="form-label required" for="client_name">Client Name</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" 
                               value="<?php echo htmlspecialchars($_POST['client_name'] ?? ''); ?>" required 
                               placeholder="Enter client full name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required 
                               placeholder="client@example.com">
                    </div>
                </div>

                <div class="form-row two-columns">
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" 
                               placeholder="(555) 123-4567">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="company">Company</label>
                        <input type="text" class="form-control" id="company" name="company" 
                               value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>" 
                               placeholder="Company name">
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Address Information
                </h3>
                
                <div class="form-group">
                    <label class="form-label" for="address">Street Address</label>
                    <input type="text" class="form-control" id="address" name="address" 
                           value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>" 
                           placeholder="123 Main Street">
                </div>

                <div class="form-row two-columns">
                    <div class="form-group">
                        <label class="form-label" for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" 
                               value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>" 
                               placeholder="Edmonton">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="province">Province</label>
                        <select class="form-control" id="province" name="province">
                            <option value="">Select Province</option>
                            <option value="AB" <?php echo ($_POST['province'] ?? '') === 'AB' ? 'selected' : ''; ?>>Alberta</option>
                            <option value="BC" <?php echo ($_POST['province'] ?? '') === 'BC' ? 'selected' : ''; ?>>British Columbia</option>
                            <option value="MB" <?php echo ($_POST['province'] ?? '') === 'MB' ? 'selected' : ''; ?>>Manitoba</option>
                            <option value="NB" <?php echo ($_POST['province'] ?? '') === 'NB' ? 'selected' : ''; ?>>New Brunswick</option>
                            <option value="NL" <?php echo ($_POST['province'] ?? '') === 'NL' ? 'selected' : ''; ?>>Newfoundland and Labrador</option>
                            <option value="NS" <?php echo ($_POST['province'] ?? '') === 'NS' ? 'selected' : ''; ?>>Nova Scotia</option>
                            <option value="ON" <?php echo ($_POST['province'] ?? '') === 'ON' ? 'selected' : ''; ?>>Ontario</option>
                            <option value="PE" <?php echo ($_POST['province'] ?? '') === 'PE' ? 'selected' : ''; ?>>Prince Edward Island</option>
                            <option value="QC" <?php echo ($_POST['province'] ?? '') === 'QC' ? 'selected' : ''; ?>>Quebec</option>
                            <option value="SK" <?php echo ($_POST['province'] ?? '') === 'SK' ? 'selected' : ''; ?>>Saskatchewan</option>
                            <option value="NT" <?php echo ($_POST['province'] ?? '') === 'NT' ? 'selected' : ''; ?>>Northwest Territories</option>
                            <option value="NU" <?php echo ($_POST['province'] ?? '') === 'NU' ? 'selected' : ''; ?>>Nunavut</option>
                            <option value="YT" <?php echo ($_POST['province'] ?? '') === 'YT' ? 'selected' : ''; ?>>Yukon</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="postal_code">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" 
                           value="<?php echo htmlspecialchars($_POST['postal_code'] ?? ''); ?>" 
                           placeholder="T5K 2M5" style="max-width: 200px;">
                </div>
            </div>

            <!-- Additional Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-sticky-note"></i>
                    Additional Information
                </h3>
                
                <div class="form-group">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" 
                              placeholder="Any additional notes about this client..."><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <i class="fas fa-user-plus"></i>
                Add Client
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const containers = document.querySelectorAll('.form-container, .page-header');
    containers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        setTimeout(() => {
            container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Form validation
    const form = document.getElementById('clientForm');
    const submitBtn = document.querySelector('.submit-btn');

    form.addEventListener('submit', function(e) {
        const clientName = document.getElementById('client_name').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (!clientName || !email) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            return false;
        }

        // Add loading state to submit button
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Client...';
    });

    // Postal code formatting
    const postalCodeInput = document.getElementById('postal_code');
    postalCodeInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').toUpperCase();
        if (value.length > 3) {
            value = value.substring(0, 3) + ' ' + value.substring(3, 6);
        }
        e.target.value = value;
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = `(${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6, 10)}`;
        } else if (value.length >= 3) {
            value = `(${value.substring(0, 3)}) ${value.substring(3)}`;
        }
        e.target.value = value;
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
