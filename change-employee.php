<?php 
$title = "Change Author";
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
        $employee_creator = $row['employee_creator'];
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

    /* DROPDOWN FIX - Override any conflicting styles */
    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
        z-index: 999999 !important;
        transform: none !important;
        inset: auto 0px auto auto !important;
        margin: 0 !important;
        margin-top: 8px !important;
    }

    .dropdown-menu[data-bs-popper] {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
        z-index: 999999 !important;
        transform: none !important;
        inset: auto 0px auto auto !important;
    }

    .profile-dropdown {
        position: relative !important;
    }

    .profile-dropdown .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        right: 0 !important;
        left: auto !important;
    }

    /* Ensure navbar stays on top */
    .modern-navbar {
        z-index: 999998 !important;
    }

    header.sticky-top {
        z-index: 999998 !important;
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

    /* Form Card */
    .form-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
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
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Buttons */
    .btn-primary {
        background: var(--bg-gradient);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        margin-right: 1rem;
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
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .invalid-feedback {
        color: var(--error-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .form-card {
            padding: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-primary, .btn-danger {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-edit"></i>
                Change Proposal Author
            </h1>
            <p class="page-subtitle">Update the creator information for this proposal</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="change-employee-submit.php?proposal_id=<?php echo $proposal_id?>" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="employee-name" class="form-label">Proposal Creator Name:</label>
                <input type="text" class="form-control" id="employee-name" name="employee-name" value="<?php echo htmlspecialchars($employee_creator); ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid name
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
                <a href="proposal-details.php?proposal_id=<?php echo $proposal_id ?>" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>