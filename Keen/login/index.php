<?php

/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

require_once("config/db.php");

require_once("classes/Login.php");


$login = new Login();


if ($login->isUserLoggedIn() == true) {


    if ($_SESSION['user_status'] == 0) {
        header("Location: ../client-dashboard.php");
        exit();
    } else {
        header("Location: ../employee-dashboard.php");
        exit();
    }
} else {
    // the user is not logged in.
    include("views/not_logged_in.php");
    include("../includes/footer.php");
}
