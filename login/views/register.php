<?php
$title = "Register";

include("./../includes/header-new.php");
?>

<style>
    .register-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem 0;
    }

    .register-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-xl);
        padding: 3rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(10px);
    }

    .register-title {
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

    .btn-register {
        background: var(--bg-gradient);
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: var(--transition);
        width: 100%;
        margin-top: 1rem;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .login-link {
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
        text-decoration: none;
        font-weight: 500;
    }

    .login-link:hover {
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

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-row .form-group {
        flex: 1;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .register-card {
            padding: 2rem;
        }
    }
</style>

<!-- register form -->
<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-card">
                    <h2 class="register-title">Create Your Account</h2>
                    <?php
                    // Check if $registration is set and has errors or messages
                    if (isset($registration) && ($registration->errors || $registration->messages)) : ?>
                        <div class="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <?php
                            // Display errors or messages
                            if ($registration->errors) {
                                foreach ($registration->errors as $error) {
                                    echo $error . "<br>";
                                }
                            }
                            if ($registration->messages) {
                                foreach ($registration->messages as $message) {
                                    echo $message . "<br>";
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="register.php" name="registerform" class="registerForm">

                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="login_input_first_name" class="form-label">First Name</label>
                                <input id="login_input_first_name" class="form-control" type="text" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
                            </div>
                            <div class="form-group mb-3">
                                <label for="login_input_last_name" class="form-label">Last Name</label>
                                <input id="login_input_last_name" class="form-control" type="text" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="login_input_username" class="form-label">Username</label>
                            <input id="login_input_username" class="form-control" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : ''; ?>" required />
                        </div>

                        <div class="mb-3">
                            <label for="login_input_email" class="form-label">Email Address</label>
                            <input id="login_input_email" class="form-control" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : ''; ?>" required />
                        </div>

                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="login_input_password_new" class="form-label">Password</label>
                                <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="login_input_password_repeat" class="form-label">Confirm Password</label>
                                <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn-register">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                        
                        <a href="index.php" class="login-link">
                            <i class="fas fa-sign-in-alt me-2"></i>Already have an account? Sign In
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
            <!-- the first name input field uses a HTML5 pattern check -->
            <div class="form-group col-6">
                <label for="login_input_firstname" class="form-label">First Name</label>
                <input id="login_input_firstname" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
            </div>
            <!-- the ;ast name input field uses a HTML5 pattern check -->
            <div class="form-group col-6">
                <label for="login_input_lasttname" class="form-label">Last Name</label>
                <input id="login_input_lastname" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
            </div>
        </div>
        <!-- the user name input field uses a HTML5 pattern check -->
        <div class="form-group">
            <label for="login_input_username" class="form-label">Username (only letters and numbers, 2 to 64
                characters)</label>
            <input id="login_input_username" class="login_input form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
        </div>
        <!-- the email input field uses a HTML5 email type check -->
        <div class="form-group">
            <label for="login_input_email" class="form-label">User's email</label>
            <input id="login_input_email" class="login_input form-control" type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required />
        </div>
        <div class="form-group">
            <label for="login_input_password_new" class="form-label">Password (min. 6 characters)</label>

            <input id="login_input_password_new" class="login_input form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class="form-group">

            <label for="login_input_password_repeat" class="form-label">Repeat password</label>
            <input id="login_input_password_repeat" class="login_input form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
        </div>
        <div class="form-group d-flex flex-column justify-content-center mx-auto">
            <input type="submit" name="register" value="Register" class="btn btn-primary">
            <a href="index.php" class="register mt-3 text-light text-center">Back to Login Page</a>

        </div>


    </form>
</div>


<?php
include("./../includes/footer.php");
?>