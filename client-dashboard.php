<?php
$title = "Client-Dashboard";
include 'includes/header-new.php';
include 'connect.php';

$hasUnopenedProposals = false;
$userName = "";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the client details associated with the user from the users table
    $sql = "SELECT u.first_name, u.last_name FROM users u WHERE u.user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and if the user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['first_name'] . " " . $row['last_name'];

        // Fetch the client_id associated with the user from the contacts table
        $sql_contact = "SELECT c.client_id FROM contacts c WHERE c.user_id = $user_id";
        $result_contact = mysqli_query($conn, $sql_contact);

        // Check if the query was successful and if the contact exists
        if ($result_contact && mysqli_num_rows($result_contact) > 0) {
            $row_contact = mysqli_fetch_assoc($result_contact);
            $client_id = $row_contact['client_id'];

            // Fetch proposals for the client
            $sql_proposals = "SELECT p.*, CONCAT(e.employee_first_name, ' ', e.employee_last_name) AS creator_name
                              FROM proposals p
                              JOIN employees e ON p.employee_id = e.employee_id
                              WHERE p.client_id = $client_id
                              ORDER BY p.creation_date DESC LIMIT 5";
            $result_proposals = mysqli_query($conn, $sql_proposals);

            // Check if there are any proposals
            if ($result_proposals && mysqli_num_rows($result_proposals) > 0) {
                while ($row_proposal = mysqli_fetch_assoc($result_proposals)) {
                    $recent_proposals[] = $row_proposal;
                    if ($row_proposal['seen'] == 0) {
                        $hasUnopenedProposals = true;
                    }
                }
            }
        }
    }
}

// Set default values if user is not logged in or no proposals found
if (empty($recent_proposals)) {
    $userName = "Guest";
    $recent_proposals = array();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    /* Modern CSS Variables */
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --secondary-color: #f8fafc;
        --accent-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --text-white: #ffffff;
        --bg-light: #f8fafc;
        --bg-dark: #1f2937;
        --bg-card: #ffffff;
        --border-color: #e5e7eb;
        --border-radius: 16px;
        --border-radius-sm: 8px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --glass-bg: rgba(255, 255, 255, 0.1);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        color: var(--text-dark);
        margin: 0;
        padding: 0;
        min-height: 100vh;
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

    .dashboard-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        padding: 3rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .dashboard-hero .container {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0;
    }

    .modern-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .notification-alert {
        background: linear-gradient(135deg, var(--accent-color) 0%, #059669 100%);
        border: none;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        color: white;
        text-align: center;
        animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-btn {
        padding: 0.875rem 2rem;
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #3730a3 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }

    .btn-light-modern {
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-light-modern:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    .proposal-card {
        background: var(--bg-dark);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary-color);
        transition: var(--transition);
    }

    .proposal-card:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-lg);
    }

    .proposal-link {
        color: var(--primary-light);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .proposal-link:hover {
        color: white;
        text-decoration: none;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }

    .status-denied {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    .whats-new-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        cursor: pointer;
        border: 1px solid var(--border-color);
    }

    .whats-new-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .service-guide {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
    }

    .service-guide img {
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow-md);
    }

    /* Modal Updates */
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--shadow-xl);
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .dashboard-hero {
            padding: 2rem 0;
        }

        .modern-btn {
            width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>

<body>
    <!-- Modern Hero Section -->
    <div class="dashboard-hero">
        <div class="container">
            <h1 class="hero-title">Welcome, <?php echo $userName; ?>!</h1>
            <p class="hero-subtitle">Manage your proposals and stay updated with the latest changes</p>
        </div>
    </div>

    <div class="container">
        <!-- New Proposal Alert -->
        <?php if ($hasUnopenedProposals) : ?>
            <div class="notification-alert">
                <i class="fas fa-bell me-2"></i>
                <strong>You have a new proposal!</strong> Click "My Proposals" to review it.
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="row mb-5">
            <div class="col-md-12">
                <a href="/mayvis/client-proposals.php" class="modern-btn btn-primary-modern w-100">
                    <i class="fas fa-file-contract"></i>
                    My Proposals
                </a>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4">
            <!-- How Our Service Works -->
            <div class="col-lg-4">
                <div class="modern-card h-100">
                    <div class="service-guide text-center">
                        <h3 class="mb-4">How Our Service Works</h3>
                        <img src="/mayvis/resources/HIW.jpg" alt="How Our Service Works" class="img-fluid mb-4" style="max-height: 200px;">
                        
                        <div class="text-start">
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 700;">1</div>
                                    <strong>Access Your Portal</strong>
                                </div>
                                <p class="ms-5 mb-0">Sign in to view and review your proposals through this portal.</p>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 700;">2</div>
                                    <strong>Review Proposals</strong>
                                </div>
                                <p class="ms-5 mb-0">Click proposal titles in your history to view detailed information.</p>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 700;">3</div>
                                    <strong>Submit Your Response</strong>
                                </div>
                                <p class="ms-5 mb-0">Leave your signature, response, and decision - then submit!</p>
                            </div>
                            
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 700;">4</div>
                                    <strong>Stay Updated</strong>
                                </div>
                                <p class="ms-5 mb-0">Check the "What's New" section for updates and changes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proposal History -->
            <div class="col-lg-8">
                <div class="glass-card">
                    <div class="p-4">
                        <h3 class="mb-4">
                            <i class="fas fa-history me-2"></i>
                            Proposal History
                        </h3>
                        
                        <div style="max-height: 500px; overflow-y: auto;">
                            <?php if (!empty($recent_proposals)) : ?>
                                <?php foreach ($recent_proposals as $proposal) : ?>
                                    <div class="proposal-card">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-2">
                                                    <a href="/mayvis/client-approval.php?proposal_id=<?php echo $proposal['proposal_id']; ?>" class="proposal-link">
                                                        <?php echo htmlspecialchars($proposal['proposal_title']); ?>
                                                    </a>
                                                </h5>
                                                <div class="text-light mb-2">
                                                    <i class="fas fa-dollar-sign me-2"></i>
                                                    <strong>Cost:</strong> <?php echo htmlspecialchars($proposal['value']); ?>
                                                </div>
                                                <div class="text-light">
                                                    <i class="fas fa-user me-2"></i>
                                                    <strong>Creator:</strong> <?php echo htmlspecialchars($proposal['creator_name']); ?>
                                                </div>
                                            </div>
                                            
                                            <?php if (isset($proposal['status'])) : ?>
                                                <span class="status-badge status-<?php echo $proposal['status'] == 1 ? 'pending' : ($proposal['status'] == 0 ? 'denied' : 'approved'); ?>">
                                                    <?php if ($proposal['status'] == 1): ?>
                                                        <i class="fas fa-clock"></i> Pending
                                                    <?php elseif ($proposal['status'] == 0): ?>
                                                        <i class="fas fa-times"></i> Denied
                                                    <?php else: ?>
                                                        <i class="fas fa-check"></i> Approved
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                    <h5>No proposals found</h5>
                                    <p class="text-light">Your proposal history will appear here once you receive proposals.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- What's New Section -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h3 class="text-center mb-4 text-white">
                    <i class="fas fa-sparkles me-2"></i>
                    What's New
                </h3>
                
                <div class="whats-new-card" data-bs-toggle="modal" data-bs-target="#changeLogModal">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-2">Changes in proposal submission process</h5>
                            <p class="mb-0 text-muted">We've improved how users can submit their changes and comments for proposals.</p>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">1 week ago</small>
                            <br>
                            <i class="fas fa-chevron-right text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Log Modal -->
    <div class="modal fade" id="changeLogModal" tabindex="-1" aria-labelledby="changeLogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-light">
                    <h5 class="modal-title" id="changeLogModalLabel">Change Log - Version 1.0</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    <p><strong>Version 1.0 (July 2025)</strong></p>
                    <ul>
                        <li>Implemented new proposal submission process: Streamlined the process of submitting proposals to improve efficiency.</li>
                        <li>Added notification for new proposals: Users now receive notifications when new proposals are available for review.</li>
                        <li>Improved user interface for better user experience: Made enhancements to the user interface to enhance usability and navigation.</li>
                        <li>Fixed dropdown navigation positioning and z-index issues.</li>
                        <li>Updated tutorial system for better user guidance.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

<?php include 'includes/footer.php'; ?>
</html>
