<?php 
include "connect.php";
$title = "Client Management";
include 'includes/header-new.php';

// Get search and filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'client_name';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Build the query with search and sort
$sql = "SELECT c.*, COUNT(p.proposal_id) as proposal_count 
        FROM clients c 
        LEFT JOIN proposals p ON c.client_id = p.client_id 
        WHERE 1=1";

if (!empty($search)) {
    $search_term = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (c.client_name LIKE '%$search_term%' OR c.email LIKE '%$search_term%')";
}

$sql .= " GROUP BY c.client_id";
$sql .= " ORDER BY $sort $order";

$result = mysqli_query($conn, $sql);
$total_clients = mysqli_num_rows($result);
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

    .client-stats {
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

    .search-input::placeholder {
        color: var(--text-light);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .sort-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .sort-btn {
        background: var(--bg-secondary);
        border: 2px solid #e5e7eb;
        color: var(--text-dark);
        padding: 0.75rem 1.25rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        transition: var(--transition);
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sort-btn:hover, .sort-btn.active {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        border-color: var(--primary-color);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .add-client-btn {
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

    .add-client-btn:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Clients Grid */
    .clients-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .client-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .client-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-color);
    }

    .client-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--bg-gradient);
    }

    .client-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .client-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--bg-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: var(--shadow-md);
    }

    .client-name {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .client-email {
        color: var(--text-light);
        font-size: 0.925rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .client-stats-card {
        display: flex;
        justify-content: space-between;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        display: block;
    }

    .stat-label-small {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .client-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        padding: 0.75rem 1.25rem;
        border: 2px solid #e5e7eb;
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
        border-color: var(--primary-color);
    }

    .action-btn-secondary {
        background: white;
        color: var(--text-dark);
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-btn-primary:hover {
        color: white;
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .action-btn-secondary:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
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
        
        .sort-controls {
            justify-content: center;
        }
        
        .clients-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-container">
    <!-- Navigation -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="/mayvis/employee-dashboard.php" style="background: white; color: var(--text-dark); padding: 0.875rem 1.5rem; border-radius: var(--border-radius); text-decoration: none; font-weight: 600; transition: var(--transition); display: flex; align-items: center; gap: 0.5rem; border: 1px solid #e5e7eb;">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
        <a href="/mayvis/proposals.php" style="background: white; color: var(--text-dark); padding: 0.875rem 1.5rem; border-radius: var(--border-radius); text-decoration: none; font-weight: 600; transition: var(--transition); display: flex; align-items: center; gap: 0.5rem; border: 1px solid #e5e7eb;">
            <i class="fas fa-file-alt"></i>
            View Proposals
        </a>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                Client Management
            </h1>
            <div class="client-stats">
                <span class="stat-number"><?php echo $total_clients; ?></span>
                <span class="stat-label">Total Clients</span>
            </div>
        </div>
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <form method="GET" style="margin: 0;">
                <input type="text" name="search" class="search-input" 
                       placeholder="Search clients by name or email..." 
                       value="<?php echo htmlspecialchars($search); ?>"
                       onchange="this.form.submit()">
                <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                <input type="hidden" name="order" value="<?php echo $order; ?>">
            </form>
        </div>
        
        <div class="sort-controls">
            <a href="?search=<?php echo urlencode($search); ?>&sort=client_name&order=<?php echo ($sort == 'client_name' && $order == 'ASC') ? 'DESC' : 'ASC'; ?>" 
               class="sort-btn <?php echo $sort == 'client_name' ? 'active' : ''; ?>">
                <i class="fas fa-sort-alpha-<?php echo ($sort == 'client_name' && $order == 'ASC') ? 'down' : 'up'; ?>"></i>
                Name
            </a>
            <a href="?search=<?php echo urlencode($search); ?>&sort=proposal_count&order=DESC" 
               class="sort-btn <?php echo $sort == 'proposal_count' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                Activity
            </a>
        </div>
        
        <a href="/mayvis/add-client.php" class="add-client-btn">
            <i class="fas fa-plus"></i>
            Add New Client
        </a>
    </div>

    <!-- Clients Grid -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="clients-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="client-card">
                    <div class="client-avatar">
                        <?php echo strtoupper(substr($row['client_name'], 0, 2)); ?>
                    </div>
                    
                    <div class="client-name"><?php echo htmlspecialchars($row['client_name']); ?></div>
                    <div class="client-email">
                        <i class="fas fa-envelope"></i>
                        <?php echo htmlspecialchars($row['email'] ?? 'No email provided'); ?>
                    </div>
                    
                    <div class="client-stats-card">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $row['proposal_count']; ?></span>
                            <span class="stat-label-small">Proposals</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">
                                <?php echo $row['client_id']; ?>
                            </span>
                            <span class="stat-label-small">Client ID</span>
                        </div>
                    </div>
                    
                    <div class="client-actions">
                        <a href="/mayvis/proposal-creation.php?client_id=<?php echo $row['client_id']; ?>" 
                           class="action-btn action-btn-primary">
                            <i class="fas fa-plus"></i>
                            New Proposal
                        </a>
                        <a href="/mayvis/client-details.php?id=<?php echo $row['client_id']; ?>" 
                           class="action-btn action-btn-secondary">
                            <i class="fas fa-eye"></i>
                            View Details
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>No Clients Found</h3>
            <p>
                <?php if (!empty($search)): ?>
                    No clients match your search criteria. Try adjusting your search terms.
                <?php else: ?>
                    You haven't added any clients yet. Start by adding your first client.
                <?php endif; ?>
            </p>
            <a href="/mayvis/add-client.php" class="add-client-btn">
                <i class="fas fa-plus"></i>
                Add Your First Client
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
    const cards = document.querySelectorAll('.client-card');
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

<?php include 'includes/footer.php'; ?>