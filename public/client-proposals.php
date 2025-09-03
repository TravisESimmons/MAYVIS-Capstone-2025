<?php
$title = "Client-Proposals";
include 'includes/header-new.php';
include 'connect.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

function getClientID($user_id, $conn)
{
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT client_id FROM contacts WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['client_id'];
    } else {
        return null;
    }
}

function getProposals($client_id, $conn)
{
    $client_id = mysqli_real_escape_string($conn, $client_id);
    $sql = "SELECT p.*, CONCAT(e.employee_first_name, ' ', e.employee_last_name) AS employee_creator
            FROM proposals p
            JOIN employees e ON p.employee_id = e.employee_id
            WHERE p.client_id = '$client_id'";
    $result = mysqli_query($conn, $sql);
    $proposals = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $proposals[] = $row;
        }
    }
    return $proposals;
}

if ($user_id !== null) {
    $client_id = getClientID($user_id, $conn);
    $proposals = $client_id !== null ? getProposals($client_id, $conn) : array();
} else {
    echo "<script>alert('You are not logged in.'); window.location.href = 'login.php';</script>";
    exit;
}

// Status configurations
$status_config = [
    0 => ['class' => 'error', 'text' => 'Denied', 'icon' => 'times-circle'],
    1 => ['class' => 'warning', 'text' => 'Pending Review', 'icon' => 'clock'],
    2 => ['class' => 'success', 'text' => 'Approved', 'icon' => 'check-circle']
];

$sent_config = [
    0 => ['class' => 'draft', 'text' => 'Draft', 'icon' => 'edit'],
    1 => ['class' => 'sent', 'text' => 'Sent', 'icon' => 'paper-plane']
];
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .page-header {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
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
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Navigation */
    .nav-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-nav {
        background: white;
        color: var(--text-dark);
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .btn-nav:hover {
        color: var(--primary-color);
        text-decoration: none;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Proposals Grid */
    .proposals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .proposal-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .proposal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--bg-gradient);
        opacity: 0;
        transition: var(--transition);
    }

    .proposal-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-color);
    }

    .proposal-card:hover::before {
        opacity: 1;
    }

    .proposal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .proposal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
    }

    .proposal-creator {
        color: var(--text-light);
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badges {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-end;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        white-space: nowrap;
    }

    .status-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-error {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
    }

    .status-sent {
        background: rgba(6, 182, 212, 0.1);
        color: var(--accent-color);
    }

    .status-draft {
        background: rgba(107, 114, 128, 0.1);
        color: var(--text-light);
    }

    .proposal-preview {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    .proposal-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        font-size: 0.875rem;
    }

    .proposal-date {
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .proposal-value {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1rem;
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    /* Action Buttons */
    .action-btn {
        background: var(--primary-color);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-dark);
        border: 1px solid #e5e7eb;
    }

    .action-btn-secondary:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: white;
    }

    /* Footer */
    .page-footer {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .proposals-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .proposal-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .status-badges {
            flex-direction: row;
            align-items: flex-start;
        }
    }

    /* Loading Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .proposal-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .proposal-card:nth-child(1) { animation-delay: 0.1s; }
    .proposal-card:nth-child(2) { animation-delay: 0.2s; }
    .proposal-card:nth-child(3) { animation-delay: 0.3s; }
    .proposal-card:nth-child(4) { animation-delay: 0.4s; }
    .proposal-card:nth-child(5) { animation-delay: 0.5s; }
    .proposal-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-file-contract"></i>
                My Proposals
            </h1>
            <p class="page-subtitle">Review and manage your project proposals</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/client-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Proposals Content -->
    <?php if (!empty($proposals)): ?>
        <div class="proposals-grid">
            <?php foreach ($proposals as $proposal): ?>
                <div class="proposal-card" onclick="location.href='client-approval.php?proposal_id=<?= $proposal['proposal_id']; ?>'">
                    <div class="proposal-header">
                        <div>
                            <h3 class="proposal-title"><?= htmlspecialchars($proposal['proposal_title']); ?></h3>
                            <div class="proposal-creator">
                                <i class="fas fa-user"></i>
                                Created by <?= htmlspecialchars($proposal['employee_creator']); ?>
                            </div>
                        </div>
                        <div class="status-badges">
                            <div class="status-badge status-<?= $status_config[$proposal['status']]['class']; ?>">
                                <i class="fas fa-<?= $status_config[$proposal['status']]['icon']; ?>"></i>
                                <?= $status_config[$proposal['status']]['text']; ?>
                            </div>
                            <div class="status-badge status-<?= $sent_config[$proposal['sent_status']]['class']; ?>">
                                <i class="fas fa-<?= $sent_config[$proposal['sent_status']]['icon']; ?>"></i>
                                <?= $sent_config[$proposal['sent_status']]['text']; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="proposal-preview">
                        <?= htmlspecialchars(strip_tags(substr($proposal['proposal_letter'], 0, 150))); ?>...
                    </div>
                    
                    <div class="proposal-meta">
                        <div class="proposal-date">
                            <i class="fas fa-calendar"></i>
                            <?= date('M j, Y', strtotime($proposal['creation_date'])); ?>
                        </div>
                        <div class="proposal-value">
                            $<?= number_format($proposal['value'], 2); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-file-contract"></i>
            </div>
            <h3>No Proposals Yet</h3>
            <p>You don't have any proposals at the moment. Check back later or contact your account manager.</p>
            <a href="/mayvis/client-dashboard.php" class="action-btn">
                <i class="fas fa-tachometer-alt"></i>
                Go to Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click animations
    document.querySelectorAll('.proposal-card').forEach(card => {
        card.addEventListener('mousedown', function() {
            this.style.transform = 'translateY(-2px) scale(0.98)';
        });
        
        card.addEventListener('mouseup', function() {
            this.style.transform = 'translateY(-4px) scale(1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add loading state for navigation
    document.querySelectorAll('.btn-nav, .action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.transform = 'scale(0.98)';
        });
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>