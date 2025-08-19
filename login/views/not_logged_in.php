<?php

$title = "Log In";

include("./../includes/header-new.php");
                   
?>

<style>
    .login-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem 0;
    }

    .login-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-xl);
        padding: 3rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(10px);
    }

    .login-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-label {
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .btn-login {
        background: var(--bg-gradient);
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: var(--transition);
        width: 100%;
        margin-bottom: 1rem;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .forgot-link, .register-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-link:hover, .register-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .register-link {
        display: inline-block;
        text-align: center;
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        background: transparent;
        color: var(--primary-color);
        transition: var(--transition);
        width: 100%;
        margin-top: 1rem;
    }

    .register-link:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary-dark);
        border-left: 4px solid var(--primary-color);
    }
</style>

<!-- login form box -->
<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card">
                    <h2 class="login-title">Welcome Back</h2>
                    <?php
                    // Check if $login is set and has errors or messages
                    if (isset($login) && ($login->errors || $login->messages || isset($_SESSION['registration_success']))) : ?>
                        <div class="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <?php
                            // Display errors or messages
                            if ($login->errors) {
                                foreach ($login->errors as $error) {
                                    echo $error;
                                }
                            }
                            if ($login->messages) {
                                foreach ($login->messages as $message) {
                                    echo $message;
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="index.php" name="loginform" class="login_form">
                        <div class="mb-3">
                            <label for="login_input_username" class="form-label">Username or Email Address</label>
                            <input id="login_input_username" class="form-control" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : ''; ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="login_input_password" class="form-label">Password</label>
                            <input id="login_input_password" class="form-control" type="password" name="user_password" autocomplete="off" required />
                        </div>
                        <div class="mb-3 text-end">
                            <a href="./forgot-password.php" class="forgot-link">Forgot Password?</a>
                        </div>
                        <button type="submit" name="login" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                        <a href="mailto:info@mayvis.ca" class="register-link">
                            <i class="fas fa-envelope me-2"></i>Need an Account? Contact Us
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>