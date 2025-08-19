<?php
$title = "Forgot Password";

include("./../includes/header-new.php");
$errors = isset($_GET['errors']) ? explode(",", $_GET['errors']) : [];

?>

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-gray: #f8fafc;
    --border-color: #e5e7eb;
    --text-muted: #64748b;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.forgot-password-container {
    max-width: 480px;
    margin: 0 auto;
    padding: 2rem;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.forgot-password-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    width: 100%;
    border: 1px solid var(--border-color);
}

.forgot-password-header {
    text-align: center;
    margin-bottom: 2rem;
}

.forgot-password-header h2 {
    color: var(--dark-color);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.forgot-password-header p {
    color: var(--text-muted);
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.btn-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid;
}

.alert-warning {
    background-color: #fef3c7;
    border-color: #f59e0b;
    color: #92400e;
}

.alert p {
    margin: 0;
    font-weight: 500;
}

.success-message {
    background-color: #d1fae5;
    border: 1px solid var(--success-color);
    color: #065f46;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1.5rem;
    text-align: center;
    font-weight: 500;
}

.back-link {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.back-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.back-link a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

@media (max-width: 576px) {
    .forgot-password-container {
        padding: 1rem;
    }
    
    .forgot-password-card {
        padding: 2rem 1.5rem;
    }
}
</style>

<div class="forgot-password-container">
    <div class="forgot-password-card">
        <div class="forgot-password-header">
            <h2>Forgot Password?</h2>
            <p>Don't worry! Enter your email address below and we'll send you a link to reset your password.</p>
        </div>

        <?php if (count($errors) > 0): ?>
            <div class="alert alert-warning">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="./functions/send-reset-link.php" name="reset-password-email-form">
            <div class="form-group">
                <label for="user_email" class="form-label">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email" id="user_email" name="user_email" class="form-control" required placeholder="Enter your email address">
            </div>
            
            <div class="form-group">
                <button type="submit" name="password_reset_link" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </div>
        </form>

        <?php if (isset($_GET["reset"]) && $_GET["reset"] == "success"): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                Password reset link sent! Please check your email for further instructions.
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="../login/index.php">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>
</div>