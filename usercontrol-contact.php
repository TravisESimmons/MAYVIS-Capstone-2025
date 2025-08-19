<?php 
include 'connect.php';
$title = "Edit Contact";
include 'includes/header-new.php';

$contact_id = $_GET['contact_id'] ?? null;

if (!$contact_id || !is_numeric($contact_id)) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM contacts WHERE contact_id = ?");
$stmt->bind_param("i", $contact_id);
$stmt->execute();
$result = $stmt->get_result();

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

    /* Form Elements */
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

    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control.is-valid {
        border-color: var(--success-color);
    }

    /* Validation Feedback */
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: var(--error-color);
    }

    .valid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: var(--success-color);
    }

    /* Button Styling */
    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        border: 2px solid transparent;
        cursor: pointer;
        font-size: 1rem;
        margin-right: 1rem;
    }

    .btn-primary {
        background: var(--bg-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: var(--error-color);
        color: white;
        border-color: var(--error-color);
    }

    .btn-danger:hover {
        background: #dc2626;
        border-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }

    /* Contact Info Display */
    .contact-info {
        background: #f8fafc;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-color);
    }

    .contact-info h3 {
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-light);
    }

    /* Button Container */
    .button-container {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
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

        .button-container {
            flex-direction: column;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-edit"></i>
                Edit Contact
            </h1>
            <p class="page-subtitle">Update contact information and details</p>
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

    <!-- Current Contact Info -->
    <div class="contact-info">
        <h3>
            <i class="fas fa-info-circle"></i>
            Current Contact Information
        </h3>
        <div class="contact-detail">
            <i class="fas fa-user"></i>
            <strong>Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>
        </div>
        <div class="contact-detail">
            <i class="fas fa-envelope"></i>
            <strong>Email:</strong> <?php echo htmlspecialchars($email); ?>
        </div>
        <div class="contact-detail">
            <i class="fas fa-id-badge"></i>
            <strong>Contact ID:</strong> <?php echo htmlspecialchars($contact_id); ?>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-edit"></i>
            Update Contact Details
        </h2>

        <form action="contact-edit-submit.php?contact_id=<?php echo $contact_id?>" method="POST" class="needs-validation" novalidate>
            <!-- First Name -->
            <div class="form-group">
                <label for="firstName" class="form-label">
                    <i class="fas fa-user"></i>
                    First Name
                </label>
                <input type="text" class="form-control" id="firstName" name="firstName" 
                       value="<?php echo htmlspecialchars($first_name); ?>" required 
                       placeholder="Enter first name">
                <div class="invalid-feedback">
                    Please provide a valid first name.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="lastName" class="form-label">
                    <i class="fas fa-user"></i>
                    Last Name
                </label>
                <input type="text" class="form-control" id="lastName" name="lastName" 
                       value="<?php echo htmlspecialchars($last_name); ?>" required 
                       placeholder="Enter last name">
                <div class="invalid-feedback">
                    Please provide a valid last name.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="contactEmail" class="form-label">
                    <i class="fas fa-envelope"></i>
                    Email Address
                </label>
                <input type="email" class="form-control" id="contactEmail" name="contactEmail" 
                       value="<?php echo htmlspecialchars($email); ?>" required 
                       placeholder="Enter email address">
                <div class="invalid-feedback">
                    Please provide a valid email address.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="button-container">
                <input type="submit" value="Update Contact" class="btn btn-primary">
                <a href="employee-usercontrol.php" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const containers = document.querySelectorAll('.form-container, .page-header, .contact-info');
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
    const form = document.querySelector('.needs-validation');
    const submitBtn = document.querySelector('input[type="submit"]');
    
    // Real-time validation feedback
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') || this.classList.contains('is-valid')) {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            }
        });

        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--primary-color)';
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            submitBtn.style.opacity = '0.7';
            submitBtn.value = 'Updating Contact...';
        }
        
        form.classList.add('was-validated');
    });
});
</script>

</body>
</html>
