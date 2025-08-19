<?php
$title = "Proposal Details";
include 'includes/header-new.php';
include 'connect.php';

$proposal_id = $_GET['proposal_id'] ?? null;

if (!$proposal_id) {
    header('Location: /mayvis/proposals.php');
    exit;
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Get proposal details
$sql = "SELECT p.*, c.client_name FROM proposals p 
        LEFT JOIN clients c ON p.client_id = c.client_id 
        WHERE p.proposal_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $proposal_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: /mayvis/proposals.php');
    exit;
}

$proposal = $result->fetch_assoc();

// Get employee details
$emp_sql = "SELECT employee_first_name, employee_last_name FROM employees WHERE employee_id = ?";
$emp_stmt = $conn->prepare($emp_sql);
$emp_stmt->bind_param("i", $proposal['employee_id']);
$emp_stmt->execute();
$emp_result = $emp_stmt->get_result();
$employee = $emp_result->fetch_assoc();

// Get deliverables
$del_sql = "SELECT DISTINCT od.deliverable_id, od.quantity, d.price, d.title, d.description 
            FROM ordered_deliverables od 
            JOIN deliverables d ON od.deliverable_id = d.deliverable_id 
            WHERE od.proposal_id = ?";
$del_stmt = $conn->prepare($del_sql);
$del_stmt->bind_param("i", $proposal_id);
$del_stmt->execute();
$deliverables_result = $del_stmt->get_result();

// Status configurations
$status_config = [
    0 => ['class' => 'error', 'text' => 'Denied', 'icon' => 'times-circle'],
    1 => ['class' => 'warning', 'text' => 'Pending Review', 'icon' => 'clock'],
    2 => ['class' => 'success', 'text' => 'Approved', 'icon' => 'check-circle']
];

$sent_config = [
    0 => ['class' => 'warning', 'text' => 'Draft', 'icon' => 'edit'],
    1 => ['class' => 'success', 'text' => 'Sent to Client', 'icon' => 'paper-plane']
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
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
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

    /* Proposal Overview Cards */
    .overview-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .proposal-card, .status-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    /* Info Items */
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-light);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        color: var(--text-dark);
        font-weight: 600;
        text-align: right;
    }

    .info-value.editable {
        color: var(--primary-color);
        cursor: pointer;
        text-decoration: underline;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
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

    /* Proposal Content */
    .proposal-content {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .content-section {
        margin-bottom: 2rem;
    }

    .content-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .proposal-letter {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        line-height: 1.6;
        color: var(--text-dark);
        white-space: pre-wrap;
        border-left: 4px solid var(--primary-color);
    }

    .client-response {
        background: #fef3c7;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        line-height: 1.6;
        color: var(--text-dark);
        border-left: 4px solid var(--warning-color);
    }

    /* Deliverables */
    .deliverables-grid {
        display: grid;
        gap: 1rem;
    }

    .deliverable-item {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: var(--transition);
    }

    .deliverable-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .deliverable-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .deliverable-title {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .deliverable-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .deliverable-description {
        color: var(--text-light);
        margin-bottom: 0.75rem;
        line-height: 1.5;
    }

    .deliverable-quantity {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Action Buttons */
    .actions-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        justify-content: center;
        text-align: center;
        border: none;
        cursor: pointer;
    }

    .action-btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .action-btn-primary:hover {
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
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-btn-success {
        background: var(--success-color);
        color: white;
    }

    .action-btn-success:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .action-btn-warning:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Alert Messages */
    .alert-modern {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sent-notice {
        background: rgba(6, 182, 212, 0.1);
        border: 1px solid rgba(6, 182, 212, 0.3);
        color: var(--accent-color);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-top: 1rem;
        font-style: italic;
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .overview-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-file-alt"></i>
                <?php echo htmlspecialchars($proposal['proposal_title']); ?>
            </h1>
            <p class="page-subtitle">Proposal Details & Management</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/proposals.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Proposals
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <?php if (isset($message)): ?>
        <div class="alert-modern">
            <i class="fas fa-check-circle"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Overview Section -->
    <div class="overview-grid">
        <!-- Proposal Information -->
        <div class="proposal-card">
            <h2 class="card-title">
                <i class="fas fa-info-circle"></i>
                Proposal Information
            </h2>
            
            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-user"></i>
                    Created By
                </span>
                <span class="info-value <?php echo $proposal['sent_status'] == 0 ? 'editable' : ''; ?>">
                    <?php if ($proposal['sent_status'] == 0): ?>
                        <a href="/mayvis/change-employee.php?proposal_id=<?php echo $proposal_id; ?>">
                            <?php echo htmlspecialchars($proposal['employee_creator']); ?> (Edit)
                        </a>
                    <?php else: ?>
                        <?php echo htmlspecialchars($proposal['employee_creator']); ?>
                    <?php endif; ?>
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-calendar"></i>
                    Created Date
                </span>
                <span class="info-value"><?php echo date('M j, Y', strtotime($proposal['creation_date'])); ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-building"></i>
                    Client
                </span>
                <span class="info-value"><?php echo htmlspecialchars($proposal['client_name'] ?? 'N/A'); ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-dollar-sign"></i>
                    Proposal Value
                </span>
                <span class="info-value <?php echo $proposal['sent_status'] == 0 ? 'editable' : ''; ?>">
                    <?php if ($proposal['sent_status'] == 0): ?>
                        <a href="/mayvis/change-price.php?proposal_id=<?php echo $proposal_id; ?>">
                            $<?php echo number_format($proposal['value'], 2); ?> (Edit)
                        </a>
                    <?php else: ?>
                        $<?php echo number_format($proposal['value'], 2); ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Status Information -->
        <div class="status-card">
            <h2 class="card-title">
                <i class="fas fa-chart-line"></i>
                Status Overview
            </h2>
            
            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-check-circle"></i>
                    Approval Status
                </div>
                <div class="status-badge status-<?php echo $status_config[$proposal['status']]['class']; ?>">
                    <i class="fas fa-<?php echo $status_config[$proposal['status']]['icon']; ?>"></i>
                    <?php echo $status_config[$proposal['status']]['text']; ?>
                </div>
            </div>

            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-paper-plane"></i>
                    Delivery Status
                </div>
                <div class="status-badge status-<?php echo $sent_config[$proposal['sent_status']]['class']; ?>">
                    <i class="fas fa-<?php echo $sent_config[$proposal['sent_status']]['icon']; ?>"></i>
                    <?php echo $sent_config[$proposal['sent_status']]['text']; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Proposal Content -->
    <div class="proposal-content">
        <div class="content-section">
            <div class="section-title">
                <i class="fas fa-file-alt"></i>
                Proposal Letter
                <?php if ($proposal['sent_status'] == 0): ?>
                    <a href="/mayvis/change-letter.php?proposal_id=<?php echo $proposal_id; ?>" class="action-btn action-btn-secondary" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-edit"></i>
                        Edit Letter
                    </a>
                <?php endif; ?>
            </div>
            <div class="proposal-letter">
                <?php echo nl2br(htmlspecialchars($proposal['proposal_letter'])); ?>
            </div>
        </div>

        <?php if ($proposal['status'] != 1 && !empty($proposal['client_response'])): ?>
            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-comment"></i>
                    Client Response
                </div>
                <div class="client-response">
                    <?php echo nl2br(htmlspecialchars($proposal['client_response'])); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Deliverables Section -->
    <div class="proposal-content">
        <div class="content-section">
            <h2 class="card-title">
                <i class="fas fa-boxes"></i>
                Ordered Deliverables
            </h2>
            
            <?php if ($deliverables_result->num_rows > 0): ?>
                <div class="deliverables-grid">
                    <?php while ($deliverable = $deliverables_result->fetch_assoc()): ?>
                        <div class="deliverable-item">
                            <div class="deliverable-header">
                                <span class="deliverable-title"><?php echo htmlspecialchars($deliverable['title']); ?></span>
                                <span class="deliverable-price">$<?php echo number_format($deliverable['price'], 2); ?></span>
                            </div>
                            <div class="deliverable-description">
                                <?php echo htmlspecialchars($deliverable['description']); ?>
                            </div>
                            <div class="deliverable-quantity">
                                Quantity: <?php echo $deliverable['quantity']; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="color: var(--text-light); text-align: center; padding: 2rem;">No deliverables found for this proposal.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Actions Section -->
    <?php if ($proposal['sent_status'] == 0): ?>
        <div class="actions-section">
            <h2 class="card-title">
                <i class="fas fa-tools"></i>
                Available Actions
            </h2>
            
            <div class="actions-grid">
                <a href="/mayvis/additional-contact-proposal.php?client_id=<?php echo $proposal['client_id']; ?>" class="action-btn action-btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Add Contact
                </a>
                
                <a href="/mayvis/send-now.php?proposal_id=<?php echo $proposal_id; ?>" class="action-btn action-btn-success">
                    <i class="fas fa-paper-plane"></i>
                    Send to Client
                </a>
            </div>
            
            <div class="sent-notice">
                <i class="fas fa-info-circle"></i>
                Once sent, you will no longer be able to make changes, and the client will be notified.
            </div>
        </div>
    <?php else: ?>
        <div class="actions-section">
            <div class="alert-modern">
                <i class="fas fa-check-circle"></i>
                This proposal has been successfully sent to the client and is now locked for editing.
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const cards = document.querySelectorAll('.proposal-card, .status-card, .proposal-content, .actions-section');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add loading states to action buttons
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.transform = 'scale(0.98)';
        });
    });
});
</script>

</body>
</html>