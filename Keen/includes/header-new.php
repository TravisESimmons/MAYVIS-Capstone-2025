<?php

// Replace this with your own root url when testing
define("BASE_URL", "");

// start session to access session variables
if (!isset($_SESSION)) {
    session_start();
};

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        MAYVIS -
        <?php echo $title ?>
    </title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body class="bg-dark text-light">
    <header class="position-relative mb-4">
        <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
            <div class="container">
                <a href="<?php
                            if (isset($_SESSION['user_login_status'])) {
                                if ($_SESSION['user_status'] == 0) {
                                    echo BASE_URL . "/client-dashboard.php";
                                } else {
                                    echo BASE_URL . "/employee-dashboard.php";
                                }
                            } else {
                                echo BASE_URL . "/index.php";
                            }
                            ?>" class="navbar-brand d-flex align-items-center fw-bold text-white">
                    <img src="<?php echo BASE_URL ?>/resources/keen-transparent.png" alt="Keen Logo" width="90" height="90">
                    MAYVIS
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse justify-content-end navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                        <?php if (isset($_SESSION['user_login_status'])) : ?>
                            <?php
                            if ($_SESSION['user_status'] == 0) : ?>
                                <!-- user is CLIENT -->
                                <li class="nav-item"><a href="<?php echo BASE_URL ?>/client-dashboard.php" class="nav-link text-white">Dashboard</a></li>
                                <li class="nav-item me-4"><a href="<?php echo BASE_URL ?>/client-proposals.php" class="nav-link text-white">My Proposals</a></li>
                            <?php else : ?>
                                <!-- user is EMPLOYEE/ADMINISTRATOR -->
                                <li class="nav-item"><a href="<?php echo BASE_URL ?>/proposals.php" class="nav-link text-white">Proposals</a></li>
                                <li class="nav-item me-4"><a href="<?php echo BASE_URL ?>/templates.php" class="nav-link text-white">Templates</a></li>
                            <?php endif; ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src=<?php
                                    if (isset($_SESSION['profile_pic_filename'])) {
                                        echo "./images/thumbs-square-small/" . $_SESSION['profile_pic_filename'];
                                    } else {
                                        if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
                                            echo "https://ui-avatars.com/api/?name=" . $_SESSION['first_name'] . "+" . $_SESSION['last_name'];
                                        } else {
                                            echo "https://ui-avatars.com/api/?size=48";
                                        }
                                    } ?> alt="Profile Picture" class="rounded-circle" height="48" width="48"></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo BASE_URL ?>/profile.php">My Profile</a>
                                    <a class="dropdown-item" href="<?php echo BASE_URL ?>/login/index.php?logout">Log
                                        Out</a>
                                </div>
                            </li>
                        <?php else : ?>
                            <li><a href="<?php echo BASE_URL ?>/login/index.php" class="nav-link text-white">Log In</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>