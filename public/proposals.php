<?php
include('connect.php');
$title = "Proposals";
include 'includes/header-new.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $get_employee = "SELECT * FROM employees where user_id = " . $user_id;
    $result = $conn->query($get_employee);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row["employee_id"];
        $user_id = $row["user_id"];
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$proposals_per_page = 8;
$offset = ($page - 1) * $proposals_per_page;

$sql = "SELECT p.*, c.client_name FROM proposals p LEFT JOIN clients c ON p.client_id = c.client_id WHERE 1=1";

if (!empty($search)) {
    $search_term = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (p.proposal_title LIKE '%$search_term%' OR c.client_name LIKE '%$search_term%')";
}

if (!empty($status_filter)) {
    $sql .= " AND p.status = '$status_filter'";
}

$sql .= " ORDER BY p.creation_date DESC LIMIT $proposals_per_page OFFSET $offset";
$result = $conn->query($sql);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM proposals p LEFT JOIN clients c ON p.client_id = c.client_id WHERE 1=1";
if (!empty($search)) {
    $count_sql .= " AND (p.proposal_title LIKE '%$search_term%' OR c.client_name LIKE '%$search_term%')";
}
if (!empty($status_filter)) {
    $count_sql .= " AND p.status = '$status_filter'";
}
$count_result = $conn->query($count_sql);
$total_proposals = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_proposals / $proposals_per_page);

// Get statistics
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as approved,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN sent_status = 1 THEN 1 ELSE 0 END) as sent
FROM proposals";
$stats_result = $conn->query($stats_sql);
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
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: var(--transition);
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

    .stat-label {
        color: var(--text-light);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .stat-total { color: var(--primary-color); }
    .stat-approved { color: var(--success-color); }
    .stat-pending { color: var(--warning-color); }
    .stat-sent { color: var(--accent-color); }

    /* Controls Section */
    .controls-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
    }

    .controls-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn-create {
        background: var(--bg-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-create:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary-modern {
        background: var(--bg-secondary);
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

    .btn-secondary-modern:hover {
        color: var(--primary-color);
        text-decoration: none;
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
    }

    /* Search and Filter Section */
    .search-filter-section {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 1rem;
        align-items: end;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .filter-select {
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        min-width: 150px;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .search-btn {
        background: var(--primary-color);
        color: white;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
    }

    .search-btn:hover {
        background: var(--primary-dark);
    }

    /* Proposals Grid */
    .proposals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .proposal-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .proposal-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .proposal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--bg-gradient);
    }

    .proposal-header {
        margin-bottom: 1rem;
    }

    .proposal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .proposal-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--text-light);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .client-name {
        font-weight: 600;
        color: var(--primary-color);
    }

    .proposal-date {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .proposal-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .badge-modern {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .badge-sent { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .badge-unsent { background: rgba(107, 114, 128, 0.1); color: var(--text-light); }
    .badge-approved { background: rgba(16, 185, 129, 0.1); color: var(--success-color); }
    .badge-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
    .badge-denied { background: rgba(239, 68, 68, 0.1); color: var(--error-color); }

    .proposal-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.75rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
    }

    .action-btn-primary {
        background: var(--primary-color);
        color: white;
        border: none;
    }

    .action-btn-primary:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Pagination */
    .pagination-container {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination-btn {
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        text-decoration: none;
        color: var(--text-dark);
        transition: var(--transition);
        font-weight: 500;
    }

    .pagination-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        text-decoration: none;
    }

    .pagination-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .controls-top {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-filter-section {
            grid-template-columns: 1fr;
        }
        
        .proposals-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="main-container">
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Page Header -->
        <div class="page-header">
            <div class="content">
                <h1 class="page-title">
                    <i class="fas fa-briefcase"></i>
                    Proposal Management
                </h1>
                <p class="mb-0">Manage and track all your client proposals in one place</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number stat-total"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total Proposals</div>
            </div>
            <div class="stat-card">
                <div class="stat-number stat-approved"><?php echo $stats['approved']; ?></div>
                <div class="stat-label">Approved</div>
            </div>
            <div class="stat-card">
                <div class="stat-number stat-pending"><?php echo $stats['pending']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number stat-sent"><?php echo $stats['sent']; ?></div>
                <div class="stat-label">Sent to Clients</div>
            </div>
        </div>

        <!-- Controls Section -->
        <div class="controls-section">
            <div class="controls-top">
                <h3 style="margin: 0; color: var(--text-dark);">All Proposals</h3>
                <div class="action-buttons">
                    <a href="/mayvis/proposal-creation.php" class="btn-create">
                        <i class="fas fa-plus"></i>
                        Create Proposal
                    </a>
                    <a href="/mayvis/your-proposals.php" class="btn-secondary-modern">
                        <i class="fas fa-user"></i>
                        Your Proposals
                    </a>
                </div>
            </div>

            <form method="GET" class="search-filter-section">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" class="search-input" 
                           placeholder="Search by proposal title or client name..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <select name="status" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="0" <?php echo $status_filter == '0' ? 'selected' : ''; ?>>Denied</option>
                    <option value="1" <?php echo $status_filter == '1' ? 'selected' : ''; ?>>Pending</option>
                    <option value="2" <?php echo $status_filter == '2' ? 'selected' : ''; ?>>Approved</option>
                </select>
                
                <button type="submit" class="search-btn">
                    <i class="fas fa-search me-1"></i>
                    Search
                </button>
            </form>
        </div>

        <!-- Proposals Grid -->
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="proposals-grid">
                <?php 
                $sent_message = array("0"=>"Unsent", "1"=>"Sent");
                $sent_class = array("0"=>"badge-unsent", "1"=>"badge-sent");
                $approval_message = array("0"=>"Denied", "1"=>"Pending", "2"=>"Approved");
                $approval_class = array("0"=>"badge-denied", "1"=>"badge-pending", "2"=>"badge-approved");
                
                while ($row = $result->fetch_object()): 
                ?>
                    <div class="proposal-card">
                        <div class="proposal-header">
                            <h3 class="proposal-title"><?php echo htmlspecialchars($row->proposal_title); ?></h3>
                            <div class="proposal-meta">
                                <span class="client-name">
                                    <i class="fas fa-building me-1"></i>
                                    <?php echo htmlspecialchars($row->client_name); ?>
                                </span>
                                <span class="proposal-date">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php echo date('M j, Y', strtotime($row->creation_date)); ?>
                                </span>
                            </div>
                        </div>

                        <div class="proposal-badges">
                            <span class="badge-modern <?php echo $sent_class[$row->sent_status]; ?>">
                                <i class="fas fa-<?php echo $row->sent_status ? 'paper-plane' : 'clock'; ?> me-1"></i>
                                <?php echo $sent_message[$row->sent_status]; ?>
                            </span>
                            <span class="badge-modern <?php echo $approval_class[$row->status]; ?>">
                                <i class="fas fa-<?php echo $row->status == 2 ? 'check-circle' : ($row->status == 1 ? 'clock' : 'times-circle'); ?> me-1"></i>
                                <?php echo $approval_message[$row->status]; ?>
                            </span>
                        </div>

                        <div class="proposal-actions">
                            <a href="/mayvis/proposal-details.php?proposal_id=<?php echo $row->proposal_id; ?>" 
                               class="action-btn action-btn-primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-container">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li>
                                <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                                   class="pagination-btn">
                                    <i class="fas fa-chevron-left me-1"></i>Previous
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li>
                                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                                   class="pagination-btn <?php echo $page == $i ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <li>
                                <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>" 
                                   class="pagination-btn">
                                    Next<i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-briefcase"></i>
                <h3>No Proposals Found</h3>
                <p>
                    <?php if (!empty($search) || !empty($status_filter)): ?>
                        No proposals match your current filters. Try adjusting your search criteria.
                    <?php else: ?>
                        You haven't created any proposals yet. Start by creating your first proposal.
                    <?php endif; ?>
                </p>
                <a href="/mayvis/proposal-creation.php" class="btn-create">
                    <i class="fas fa-plus"></i>
                    Create Your First Proposal
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-lock"></i>
            <h3>Access Required</h3>
            <p>Please sign in to view and manage proposals.</p>
            <a href="/mayvis/login/index.php" class="btn-create">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading states to action buttons
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.transform = 'scale(0.98)';
        });
    });

    // Smooth animations on load
    const cards = document.querySelectorAll('.proposal-card, .stat-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>

</body>
</html>