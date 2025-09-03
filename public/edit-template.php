<?php
$title = "Edit Template";
include 'includes/header-new.php';
include 'connect.php';

// Check if template data is passed via URL parameters
if (isset($_GET['deliverable_id']) && isset($_GET['title']) && isset($_GET['description']) && isset($_GET['price']) && isset($_GET['category'])) {
    // Get template data from URL parameters
    $deliverable_id = $_GET['deliverable_id'];
    $template_title = $_GET['title'];
    $description = $_GET['description'];
    $price = $_GET['price'];
    $category = $_GET['category'];
} else {
    // Handle case where data is not provided
    $deliverable_id = "";
    $template_title = "";
    $description = "";
    $price = "";
    $category = "";
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

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
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
        margin-top: 1rem;
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
            padding: 1.5rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Template
            </h1>
            <p class="page-subtitle">Modify template details and information</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/templates.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Templates
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-file-edit"></i>
            Template Information
        </h2>

        <form method="POST" action="update-template.php" id="editTemplateForm">
            <!-- Hidden field to pass deliverable_id to update_template.php -->
            <input type="hidden" name="deliverable_id" value="<?php echo htmlspecialchars($deliverable_id); ?>">
            
            <!-- Title -->
            <div class="form-group">
                <label class="form-label" for="title">
                    <i class="fas fa-heading"></i>
                    Title
                </label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?php echo htmlspecialchars($template_title); ?>" required 
                       placeholder="Enter template title">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label" for="description">
                    <i class="fas fa-align-left"></i>
                    Description
                </label>
                <textarea class="form-control" id="description" name="description" required 
                          placeholder="Enter template description"><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label class="form-label" for="price">
                    <i class="fas fa-dollar-sign"></i>
                    Price (CAD)
                </label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" 
                       value="<?php echo htmlspecialchars($price); ?>" required 
                       placeholder="0.00">
            </div>

            <!-- Category -->
            <div class="form-group">
                <label class="form-label" for="category">
                    <i class="fas fa-tag"></i>
                    Category
                </label>
                <input type="text" class="form-control" id="category" name="category" 
                       value="<?php echo htmlspecialchars($category); ?>" required 
                       placeholder="Enter category">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                Update Template
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

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

    // Add loading state to submit button
    const form = document.getElementById('editTemplateForm');
    const submitBtn = document.querySelector('.submit-btn');
    
    form.addEventListener('submit', function() {
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Template...';
    });

    // Form validation feedback
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.style.borderColor = 'var(--success-color)';
            } else {
                this.style.borderColor = 'var(--error-color)';
            }
        });

        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--primary-color)';
        });
    });
});
</script>

</body>
</html>