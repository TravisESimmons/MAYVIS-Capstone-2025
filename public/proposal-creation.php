<?php
include 'connect.php';

// Check if step 5 is being processed (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 5) {
    // Process step 5 directly without any output
    include 'proposal-creation/step5.php';
    exit; // This will never be reached due to redirects in step5.php
}

$title = "Proposal Creation";
$currentStep = isset($_GET['step']) ? intval($_GET['step']) : 1;
include 'includes/header-new.php';
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
        margin: 0;
        padding: 0;
    }

    /* Modern Wizard Container */
    .wizard-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .wizard-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-xl);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        position: relative;
    }

    .wizard-header {
        background: var(--bg-gradient);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .wizard-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .wizard-header .content {
        position: relative;
        z-index: 2;
    }

    .wizard-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .wizard-subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }

    /* Modern Progress Bar */
    .progress-container {
        padding: 1.5rem 2rem;
        background: var(--bg-secondary);
        border-bottom: 1px solid #e5e7eb;
    }

    .progress-wrapper {
        position: relative;
        background: #e5e7eb;
        border-radius: 50px;
        height: 8px;
        overflow: hidden;
    }

    .progress-bar-modern {
        height: 100%;
        background: var(--bg-gradient);
        border-radius: 50px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .progress-bar-modern::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .progress-text {
        text-align: center;
        margin-top: 0.5rem;
        color: var(--text-light);
        font-weight: 500;
        font-size: 0.875rem;
    }

    /* Step Content */
    .step-content {
        padding: 2rem;
        min-height: 400px;
    }

    /* Modern Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-dark);
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

    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control.is-valid {
        border-color: var(--success-color);
    }

    /* Error Messages */
    .alert {
        padding: 0.75rem 1rem;
        border-radius: var(--border-radius);
        border: none;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
        border-left: 4px solid var(--error-color);
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border-left: 4px solid var(--success-color);
    }

    /* Navigation Buttons */
    .wizard-navigation {
        padding: 1.5rem 2rem;
        background: var(--bg-secondary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e5e7eb;
    }

    .btn-wizard {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-primary-wizard {
        background: var(--bg-gradient);
        color: white;
    }

    .btn-primary-wizard:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary-wizard {
        background: #e5e7eb;
        color: var(--text-dark);
    }

    .btn-secondary-wizard:hover {
        background: #d1d5db;
        color: var(--text-dark);
        text-decoration: none;
    }

    /* Step Indicators */
    .step-indicators {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .step-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e5e7eb;
        transition: var(--transition);
        position: relative;
    }

    .step-indicator.active {
        background: var(--primary-color);
        transform: scale(1.2);
    }

    .step-indicator.completed {
        background: var(--success-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .wizard-container {
            margin: 1rem auto;
            padding: 0 0.5rem;
        }
        
        .wizard-header {
            padding: 1.5rem 1rem;
        }
        
        .wizard-title {
            font-size: 1.5rem;
        }
        
        .step-content {
            padding: 1.5rem 1rem;
        }
        
        .wizard-navigation {
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
        }
    }

    /* Loading States */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--primary-color);
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="max-width: 800px; margin: 0 auto; padding: 2rem 1rem 0 1rem;">
    <!-- Navigation -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="/mayvis/employee-dashboard.php" style="background: white; color: var(--text-dark); padding: 0.875rem 1.5rem; border-radius: var(--border-radius); text-decoration: none; font-weight: 600; transition: var(--transition); display: flex; align-items: center; gap: 0.5rem; border: 1px solid #e5e7eb;">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
        <a href="/mayvis/proposals.php" style="background: white; color: var(--text-dark); padding: 0.875rem 1.5rem; border-radius: var(--border-radius); text-decoration: none; font-weight: 600; transition: var(--transition); display: flex; align-items: center; gap: 0.5rem; border: 1px solid #e5e7eb;">
            <i class="fas fa-file-alt"></i>
            View Proposals
        </a>
    </div>
</div>

<div class="wizard-container">
    <div class="wizard-card">
        <div class="wizard-header">
            <div class="content">
                <h1 class="wizard-title">Create New Proposal</h1>
                <p class="wizard-subtitle">Build professional proposals step by step</p>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="step-indicators">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <div class="step-indicator <?php 
                        if (!isset($_POST['step'])) {
                            echo $i == 1 ? 'active' : '';
                        } else {
                            $step = $_POST['step'];
                            if ($i < $step) echo 'completed';
                            else if ($i == $step) echo 'active';
                        }
                    ?>"></div>
                <?php endfor; ?>
            </div>
            <div class="progress-wrapper">
                <div class="progress-bar-modern" style="width: <?php 
                    if (!isset($_POST['step'])) {
                        echo '20%';
                    } else {
                        echo ($_POST['step'] * 20) . '%';
                    }
                ?>"></div>
            </div>
            <div class="progress-text">
                Step <?php echo !isset($_POST['step']) ? '1' : $_POST['step']; ?> of 5
            </div>
        </div>

        <div class="step-content">
            <?php
            if (!isset($_POST['step'])) {
                $step = 1;
            } else {
                $step = $_POST['step'];
            }

            switch ($step) {
                case 1:
                    include 'proposal-creation/step1.php';
                    break;
                case 2:
                    include 'proposal-creation/step2.php';
                    break;
                case 3:
                    include 'proposal-creation/step3.php';
                    break;
                case 4:
                    include 'proposal-creation/step4.php';
                    break;
                case 5:
                    // Step 5 is handled at the top of the file before any output
                    echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Processing your proposal...</div>';
                    break;
                default:
                    echo '<div class="alert alert-danger">Invalid step specified.</div>';
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Enhanced form validation and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time validation
        const inputs = document.querySelectorAll('.form-control[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearErrors);
        });

        function validateField(e) {
            const field = e.target;
            const errorElement = document.getElementById(field.id + 'Error');
            
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
                if (errorElement) errorElement.style.display = 'block';
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
                if (errorElement) errorElement.style.display = 'none';
            }
        }

        function clearErrors(e) {
            const field = e.target;
            const errorElement = document.getElementById(field.id + 'Error');
            
            if (field.value.trim()) {
                field.classList.remove('is-invalid');
                if (errorElement) errorElement.style.display = 'none';
            }
        }

        // Form submission with loading state
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Smooth progress bar animation
        const progressBar = document.querySelector('.progress-bar-modern');
        if (progressBar) {
            setTimeout(() => {
                progressBar.style.opacity = '1';
                progressBar.style.transform = 'scaleX(1)';
            }, 300);
        }
    });
</script>

</body>
</html>