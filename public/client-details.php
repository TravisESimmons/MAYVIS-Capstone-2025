<?php
$title = "Client Details";
include 'includes/header-new.php';
include 'connect.php';

// Get client ID from URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($client_id === 0) {
    header("Location: clients.php");
    exit;
}

// Fetch client information
$client_sql = "SELECT * FROM clients WHERE client_id = ?";
$stmt = $conn->prepare($client_sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$client_result = $stmt->get_result();

if ($client_result->num_rows === 0) {
    header("Location: clients.php");
    exit;
}

$client = $client_result->fetch_assoc();

// Fetch client's proposals
$proposals_sql = "SELECT p.*, 
                         COUNT(od.deliverable_id) as deliverable_count,
                         SUM(d.price * COALESCE(od.quantity, 1)) as total_value
                  FROM proposals p 
                  LEFT JOIN ordered_deliverables od ON p.proposal_id = od.proposal_id
                  LEFT JOIN deliverables d ON od.deliverable_id = d.deliverable_id
                  WHERE p.client_id = ?
                  GROUP BY p.proposal_id
                  ORDER BY p.creation_date DESC";
$proposals_stmt = $conn->prepare($proposals_sql);
$proposals_stmt->bind_param("i", $client_id);
$proposals_stmt->execute();
$proposals_result = $proposals_stmt->get_result();

// Get client statistics
$stats_sql = "SELECT 
                COUNT(*) as total_proposals,
                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved_proposals,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_proposals,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected_proposals
              FROM proposals WHERE client_id = ?";
$stats_stmt = $conn->prepare($stats_sql);
$stats_stmt->bind_param("i", $client_id);
$stats_stmt->execute();
$stats_result = $stats_stmt->get_result();
$stats = $stats_result->fetch_assoc();
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Navigation */
    .nav-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
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

    /* Client Info Card */
    .client-info-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .client-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .client-avatar {
        width: 80px;
        height: 80px;
        background: var(--bg-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .client-info {
        flex: 1;
    }

    .client-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .client-email {
        color: var(--primary-color);
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .client-company {
        color: var(--text-light);
        font-size: 1rem;
    }

    .client-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .detail-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .detail-value {
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 500;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
        border: 1px solid #e5e7eb;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-number.total { color: var(--primary-color); }
    .stat-number.approved { color: var(--success-color); }
    .stat-number.pending { color: var(--warning-color); }
    .stat-number.rejected { color: var(--error-color); }

    .stat-label {
        color: var(--text-light);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        font-weight: 600;
    }

    /* Proposals Section */
    .proposals-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Proposal Cards */
    .proposals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .proposal-card {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: var(--transition);
    }

    .proposal-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .proposal-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .proposal-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .proposal-id {
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .proposal-status {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        flex-shrink: 0;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .proposal-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: var(--text-light);
    }

    .proposal-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        text-align: right;
    }

    .proposal-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-proposal {
        flex: 1;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: var(--transition);
        font-size: 0.875rem;
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .page-header .content {
            flex-direction: column;
            text-align: center;
        }
        
        .client-header {
            flex-direction: column;
            text-align: center;
        }
        
        .client-details-grid {
            grid-template-columns: 1fr;
        }
        
        .proposals-grid {
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
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user"></i>
                    Client Details
                </h1>
                <p class="page-subtitle">Complete client profile and proposal history</p>
            </div>
            <div class="header-actions">
                <a href="/mayvis/proposal-creation.php?client_id=<?php echo $client_id; ?>" class="btn-header">
                    <i class="fas fa-plus"></i>
                    New Proposal
                </a>
                <a href="edit-client.php?id=<?php echo $client_id; ?>" class="btn-header">
                    <i class="fas fa-edit"></i>
                    Edit Client
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/clients.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Clients
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <!-- Client Information Card -->
    <div class="client-info-card">
        <div class="client-header">
            <div class="client-avatar">
                <?php echo strtoupper(substr($client['client_name'], 0, 2)); ?>
            </div>
            <div class="client-info">
                <h2 class="client-name"><?php echo htmlspecialchars($client['client_name']); ?></h2>
                <div class="client-email">
                    <i class="fas fa-envelope"></i>
                    <?php echo htmlspecialchars($client['email']); ?>
                </div>
                <?php if (!empty($client['company'])): ?>
                    <div class="client-company">
                        <i class="fas fa-building"></i>
                        <?php echo htmlspecialchars($client['company']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="client-details-grid">
            <?php if (!empty($client['phone'])): ?>
                <div class="detail-item">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">
                        <i class="fas fa-phone"></i>
                        <?php echo htmlspecialchars($client['phone']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($client['address']) || !empty($client['city'])): ?>
                <div class="detail-item">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php 
                        $address_parts = [];
                        if (!empty($client['address'])) $address_parts[] = $client['address'];
                        if (!empty($client['city'])) $address_parts[] = $client['city'];
                        if (!empty($client['province'])) $address_parts[] = $client['province'];
                        if (!empty($client['postal_code'])) $address_parts[] = $client['postal_code'];
                        echo htmlspecialchars(implode(', ', $address_parts));
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="detail-item">
                <div class="detail-label">Client Since</div>
                <div class="detail-value">
                    <i class="fas fa-calendar"></i>
                    <?php echo date('M j, Y', strtotime($client['created_date'] ?? 'now')); ?>
                </div>
            </div>

            <?php if (!empty($client['notes'])): ?>
                <div class="detail-item">
                    <div class="detail-label">Notes</div>
                    <div class="detail-value">
                        <i class="fas fa-sticky-note"></i>
                        <?php echo htmlspecialchars($client['notes']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number total"><?php echo $stats['total_proposals']; ?></div>
            <div class="stat-label">Total Proposals</div>
        </div>
        <div class="stat-card">
            <div class="stat-number approved"><?php echo $stats['approved_proposals']; ?></div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card">
            <div class="stat-number pending"><?php echo $stats['pending_proposals']; ?></div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number rejected"><?php echo $stats['rejected_proposals']; ?></div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Proposals Section -->
    <div class="proposals-section">
        <h2 class="section-title">
            <i class="fas fa-file-alt"></i>
            Proposal History
        </h2>

        <?php if ($proposals_result->num_rows > 0): ?>
            <div class="proposals-grid">
                <?php while ($proposal = $proposals_result->fetch_assoc()): ?>
                    <div class="proposal-card">
                        <div class="proposal-header">
                            <div>
                                <h3 class="proposal-title"><?php echo htmlspecialchars($proposal['proposal_title']); ?></h3>
                                <div class="proposal-id">ID: #<?php echo $proposal['proposal_id']; ?></div>
                            </div>
                            <div class="proposal-status status-<?php echo strtolower($proposal['status']); ?>">
                                <?php echo htmlspecialchars($proposal['status']); ?>
                            </div>
                        </div>
                        
                        <div class="proposal-meta">
                            <span>
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M j, Y', strtotime($proposal['creation_date'])); ?>
                            </span>
                            <span>
                                <i class="fas fa-list"></i>
                                <?php echo $proposal['deliverable_count']; ?> items
                            </span>
                        </div>

                        <div class="proposal-value">
                            $<?php echo number_format($proposal['total_value'] ?? 0, 2); ?> CAD
                        </div>

                        <div class="proposal-actions">
                            <a href="/mayvis/proposal-details.php?id=<?php echo $proposal['proposal_id']; ?>" class="btn-proposal btn-view">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>No Proposals Yet</h3>
                <p>This client doesn't have any proposals yet. Create their first proposal to get started!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const cards = document.querySelectorAll('.client-info-card, .stat-card, .proposals-section, .page-header');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add hover effects to proposal cards
    const proposalCards = document.querySelectorAll('.proposal-card');
    proposalCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animate stats on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const finalValue = parseInt(stat.textContent);
                    let currentValue = 0;
                    const increment = Math.max(1, finalValue / 30);
                    
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            stat.textContent = finalValue;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(currentValue);
                        }
                    }, 50);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsGrid = document.querySelector('.stats-grid');
    if (statsGrid) {
        statsObserver.observe(statsGrid);
    }
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
