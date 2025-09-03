<?php
$title = "Your Proposals";
include('includes/header-new.php');
include('connect.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $get_employee = "SELECT * FROM employees where user_id = $user_id";
    $result = $conn->query($get_employee);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row["employee_id"];
        $user_id = $row["user_id"];
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$proposals_per_page = 6;
$offset = ($page - 1) * $proposals_per_page;

$sql = "SELECT * FROM proposals WHERE employee_id = $employee_id";

if (!empty($search)) {
    $search_term = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (proposal_title LIKE '%$search_term%' OR client_id IN (SELECT client_id FROM clients WHERE client_name LIKE '%$search_term%'))";
}

$total_proposals_sql = "SELECT COUNT(*) AS total_proposals FROM proposals WHERE employee_id = $employee_id";
if (!empty($search)) {
    $total_proposals_sql .= " AND (proposal_title LIKE '%$search_term%' OR client_id IN (SELECT client_id FROM clients WHERE client_name LIKE '%$search_term%'))";
}
$total_proposals_result = $conn->query($total_proposals_sql);
$total_proposals_row = $total_proposals_result->fetch_assoc();
$total_proposals = $total_proposals_row['total_proposals'];
$total_pages = ceil($total_proposals / $proposals_per_page);

$sql .= " ORDER BY creation_date DESC LIMIT $proposals_per_page OFFSET $offset";
$result = $conn->query($sql);
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
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .proposal-stats {
        text-align: right;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
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

    /* Controls Section */
    .controls-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .search-container {
        flex: 1;
        min-width: 300px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        color: var(--text-dark);
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

    .action-buttons {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn-action {
        background: var(--bg-gradient);
        color: white;
        padding: 1rem 1.75rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 700;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-dark);
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
    }

    /* Proposals Grid */
    .proposals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .proposal-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .proposal-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-color);
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
        margin-bottom: 1.5rem;
    }

    .proposal-title {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .proposal-meta {
        color: var(--text-light);
        font-size: 0.925rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .proposal-meta i {
        color: var(--primary-color);
    }

    .proposal-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-sent {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-unsent {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-denied {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
    }

    .proposal-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-proposal {
        padding: 0.75rem 1.25rem;
        border: 2px solid var(--primary-color);
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
        background: var(--primary-color);
        color: white;
    }

    .btn-proposal:hover {
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: var(--primary-dark);
        color: white;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .pagination-btn {
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        text-decoration: none;
        color: var(--text-dark);
        background: white;
        transition: var(--transition);
        font-weight: 600;
    }

    .pagination-btn:hover {
        color: var(--primary-color);
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

    .empty-state h3 {
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .page-header .content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .controls-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-container {
            min-width: auto;
        }
        
        .proposals-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="main-container">
    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
        <a href="/mayvis/proposals.php" class="btn-nav">
            <i class="fas fa-file-alt"></i>
            All Proposals
        </a>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-user-edit"></i>
                Your Proposals
            </h1>
            <div class="proposal-stats">
                <span class="stat-number"><?php echo $total_proposals; ?></span>
                <span class="stat-label">Total Proposals</span>
            </div>
        </div>
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <form method="GET" style="margin: 0;">
                <input type="text" name="search" class="search-input" 
                       placeholder="Search proposals by title or client name..." 
                       value="<?php echo htmlspecialchars($search); ?>"
                       onchange="this.form.submit()">
                <input type="hidden" name="page" value="1">
            </form>
        </div>
        
        <div class="action-buttons">
            <a href="/mayvis/proposal-creation.php" class="btn-action">
                <i class="fas fa-plus"></i>
                Create Proposal
            </a>
        </div>
    </div>

    <!-- Proposals Grid -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="proposals-grid">
                <?php 
                $sent_message = array("0"=>"Draft", "1"=>"Sent");
                $approval_message = array("0"=>"Denied", "1"=>"Pending Review", "2"=>"Approved");
                
                while ($row = $result->fetch_object()): 
                    $proposal_id = $row->proposal_id;
                    $client_id = $row->client_id;
                    $proposal_title = $row->proposal_title;
                    $creation_date = date('M j, Y', strtotime($row->creation_date));
                    $sent_status = $row->sent_status;
                    $approval_status = $row->status;
                    
                    // Get client name
                    $get_client = "SELECT * FROM clients where client_id = " . intval($client_id);
                    $result2 = $conn->query($get_client);
                    $client_name = "Unknown Client";
                    if ($result2 && $result2->num_rows > 0) {
                        $client_row = $result2->fetch_assoc();
                        $client_name = $client_row['client_name'];
                    }
                ?>
                    <div class="proposal-card">
                        <div class="proposal-header">
                            <h3 class="proposal-title"><?php echo htmlspecialchars($proposal_title); ?></h3>
                            <div class="proposal-meta">
                                <span><i class="fas fa-building"></i><?php echo htmlspecialchars($client_name); ?></span>
                                <span><i class="fas fa-calendar"></i><?php echo $creation_date; ?></span>
                            </div>
                        </div>
                        
                        <div class="proposal-badges">
                            <span class="status-badge status-<?php echo $sent_status == 0 ? 'unsent' : 'sent'; ?>">
                                <i class="fas fa-<?php echo $sent_status == 0 ? 'edit' : 'paper-plane'; ?>"></i>
                                <?php echo $sent_message[$sent_status]; ?>
                            </span>
                            <span class="status-badge status-<?php 
                                echo $approval_status == 0 ? 'denied' : ($approval_status == 2 ? 'approved' : 'pending'); 
                            ?>">
                                <i class="fas fa-<?php 
                                    echo $approval_status == 0 ? 'times-circle' : ($approval_status == 2 ? 'check-circle' : 'clock'); 
                                ?>"></i>
                                <?php echo $approval_message[$approval_status]; ?>
                            </span>
                        </div>
                        
                        <div class="proposal-actions">
                            <a href="/mayvis/proposal-details.php?proposal_id=<?php echo $proposal_id; ?>" class="btn-proposal">
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
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
                               class="pagination-btn <?php echo $page == $i ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>No Proposals Found</h3>
                <p>
                    <?php if (!empty($search)): ?>
                        No proposals match your search criteria. Try adjusting your search terms.
                    <?php else: ?>
                        You haven't created any proposals yet. Start by creating your first proposal.
                    <?php endif; ?>
                </p>
                <a href="/mayvis/proposal-creation.php" class="btn-action">
                    <i class="fas fa-plus"></i>
                    Create Your First Proposal
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-lock"></i>
            <h3>Please Sign In</h3>
            <p>You need to be logged in to view your proposals.</p>
            <a href="/mayvis/login/" class="btn-action">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading states to action buttons
    document.querySelectorAll('.btn-proposal, .btn-action').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.style.transform = 'scale(0.98)';
        });
    });

    // Smooth animations on load
    const cards = document.querySelectorAll('.proposal-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

</body>
</html>