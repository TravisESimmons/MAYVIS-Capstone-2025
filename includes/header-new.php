<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_name = "";
$user_type = "";
$user_avatar = "";

if (isset($_SESSION['user_id'])) {
    include_once 'connect.php';
    
    // Check if user is employee or client
    $employee_check = $conn->prepare("SELECT employee_first_name, employee_last_name FROM employees WHERE user_id = ?");
    $employee_check->bind_param("i", $_SESSION['user_id']);
    $employee_check->execute();
    $employee_result = $employee_check->get_result();
    
    if ($employee_result->num_rows > 0) {
        $employee = $employee_result->fetch_assoc();
        $user_name = $employee['employee_first_name'] . ' ' . $employee['employee_last_name'];
        $user_type = "employee";
    } else {
        // Check if client (user_status = 0 means client)
        $client_check = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id = ? AND user_status = '0'");
        $client_check->bind_param("i", $_SESSION['user_id']);
        $client_check->execute();
        $client_result = $client_check->get_result();
        
        if ($client_result->num_rows > 0) {
            $client = $client_result->fetch_assoc();
            $user_name = $client['first_name'] . ' ' . $client['last_name'];
            $user_type = "client";
        }
    }
    
    // Get user's profile picture
    $picture_check = $conn->prepare("SELECT filename FROM profile_pictures WHERE user_id = ?");
    $picture_check->bind_param("i", $_SESSION['user_id']);
    $picture_check->execute();
    $picture_result = $picture_check->get_result();
    
    if ($picture_result->num_rows > 0) {
        $picture = $picture_result->fetch_assoc();
        // Use file modification time for cache busting instead of current time
        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/mayvis/images/thumbs-square-small/" . $picture['filename'];
        $cache_buster = file_exists($image_path) ? filemtime($image_path) : time();
        $user_avatar = "/mayvis/images/thumbs-square-small/" . $picture['filename'] . "?v=" . $cache_buster;
    } else {
        // Generate avatar using initials
        $initials = strtoupper(substr($user_name, 0, 1));
        if (strpos($user_name, ' ') !== false) {
            $name_parts = explode(' ', $user_name);
            $initials = strtoupper(substr($name_parts[0], 0, 1) . substr($name_parts[1], 0, 1));
        }
        $user_avatar = "https://ui-avatars.com/api/?size=48&name=" . urlencode($initials) . "&background=6366f1&color=ffffff";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - MAYVIS' : 'MAYVIS'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
        }

        .modern-navbar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: var(--shadow-lg);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .brand-logo:hover {
            box-shadow: var(--shadow-md);
            transform: scale(1.05);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.2);
        }

        .nav-link.active {
            color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.2);
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            transition: var(--transition);
            cursor: pointer;
        }

        .profile-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
        }

        /* Authentication buttons for non-logged-in users */
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }

        /* Contact email link styling */
        .nav-link[href^="mailto:"] {
            transition: var(--transition);
        }

        .nav-link[href^="mailto:"]:hover {
            color: #10b981 !important;
            background: rgba(16, 185, 129, 0.2);
        }

        /* CLEAN DROPDOWN POSITIONING */
        .dropdown-menu {
            border: none !important;
            box-shadow: var(--shadow-lg) !important;
            border-radius: var(--border-radius) !important;
            padding: 0.5rem 0 !important;
            margin-top: 8px !important;
            min-width: 200px !important;
            background: white !important;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 9999 !important;
        }

        .dropdown-menu[data-bs-popper] {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            z-index: 9999 !important;
            margin-top: 8px !important;
            transform: none !important;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background: var(--bg-secondary);
            color: var(--primary-color);
        }

        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.25rem;
            }

            .brand-logo {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php 
                if (empty($user_type)) {
                    echo '/mayvis/index.php';
                } elseif ($user_type === 'employee') {
                    echo '/mayvis/employee-dashboard.php';
                } else {
                    echo '/mayvis/client-dashboard.php';
                }
            ?>">
                <img src="/mayvis/resources/keen-transparent.png" alt="MAYVIS Logo" class="brand-logo">
                MAYVIS
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($user_type === 'employee'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/mayvis/proposals.php">
                                <i class="fas fa-file-alt me-2"></i>Proposals
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/mayvis/templates.php">
                                <i class="fas fa-layer-group me-2"></i>Templates
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/mayvis/clients.php">
                                <i class="fas fa-users me-2"></i>Clients
                            </a>
                        </li>
                    <?php elseif ($user_type === 'client'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/mayvis/client-proposals.php">
                                <i class="fas fa-file-alt me-2"></i>My Proposals
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- User Profile Dropdown -->
                <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown profile-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo htmlspecialchars($user_avatar); ?>" alt="Profile" class="profile-avatar me-2" id="headerProfileImage">
                            <span class="text-white"><?php echo htmlspecialchars($user_name); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/mayvis/profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/mayvis/login/index.php?logout=1"><i class="fas fa-sign-out-alt me-2"></i>Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <?php else: ?>
                <!-- Authentication buttons for non-logged-in users -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link me-3" href="/mayvis/about.php">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-3" href="mailto:info@mayvis.ca">
                            <i class="fas fa-envelope me-1"></i>Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light me-2" href="/mayvis/login/index.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Sign In
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
