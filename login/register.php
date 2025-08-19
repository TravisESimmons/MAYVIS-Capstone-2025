<?php
/**
 * Registration Redirect - MAYVIS Business Model
 * 
 * MAYVIS operates on a professional service model where:
 * 1. Clients contact us via email to discuss their project needs
 * 2. Our team creates secure accounts for approved clients
 * 3. Clients receive login credentials to access their personalized proposals
 * 
 * This ensures quality service and proper account management.
 */

// Redirect to the main page with an informational message
$redirect_message = "account-creation-info";
header("Location: ../index.php?info=" . $redirect_message);
exit();
?>
