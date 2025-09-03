<?php
$title = "User Control Panel";
include 'includes/header-new.php';
include 'connect.php';
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
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Page Header */
    .page-header {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
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
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }
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

    /* Control Grid */
    .control-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .control-section {
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
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--bg-secondary);
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Contact/User Cards */
    .item-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.75rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e5e7eb;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .item-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--bg-gradient);
        transition: var(--transition);
        opacity: 0;
    }

    .item-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-color);
    }

    .item-card:hover::before {
        opacity: 1;
    }

    .item-card:last-child {
        margin-bottom: 0;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .card-info {
        flex: 1;
    }

    .card-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .card-details {
        color: var(--text-light);
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .card-details p {
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-details i {
        color: var(--primary-color);
        width: 16px;
        text-align: center;
    }

    .card-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-assigned {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-unassigned {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    /* Edit Button */
    .edit-btn {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .edit-btn:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .edit-btn:active {
        transform: translateY(0);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-assigned {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-unassigned {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    /* Action Button */
    .edit-btn {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .edit-btn:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-light);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: var(--border-radius);
        border: 2px dashed #e2e8f0;
    }

    .empty-state i {
        font-size: 3.5rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }

    .empty-state h4 {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .control-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .control-section {
            padding: 1.5rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
        }

        .card-status {
            align-items: flex-start;
            flex-direction: row;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-users-cog"></i>
                User Control Panel
            </h1>
            <p class="page-subtitle">Manage contacts and user accounts</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
        <a href="/mayvis/submit-new-contact.php" class="btn-nav">
            <i class="fas fa-user-plus"></i>
            Add New Contact
        </a>
    </div>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="control-section" style="grid-column: 1 / -1; text-align: center;">
            <div class="empty-state">
                <i class="fas fa-lock"></i>
                <h3>Access Denied</h3>
                <p>Please sign in to view the user control panel.</p>
            </div>
        </div>
    <?php else: ?>
        <!-- Control Grid -->
        <div class="control-grid">
            <!-- Contacts Section -->
            <div class="control-section">
                <h3 class="section-title">
                    <i class="fas fa-address-book"></i>
                    Created Contacts
                </h3>
                
                <?php
                $sql = "SELECT c.*, cl.client_name FROM contacts c 
                        LEFT JOIN clients cl ON c.client_id = cl.client_id 
                        ORDER BY c.contact_id ASC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        $contact_id = $row->contact_id;
                        $first_name = $row->first_name;
                        $last_name = $row->last_name;
                        $user_id = $row->user_id;
                        $client_name = $row->client_name ?? "Unknown Company";
                        
                        $status_class = isset($user_id) ? 'status-assigned' : 'status-unassigned';
                        $status_text = isset($user_id) ? 'Assigned' : 'Unassigned';
                        $user_display = isset($user_id) ? "User ID: $user_id" : "No user assigned";
                ?>
                        <div class="item-card">
                            <div class="card-header">
                                <div class="card-info">
                                    <div class="card-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></div>
                                    <div class="card-details">
                                        <p><i class="fas fa-building"></i> Company: <?php echo htmlspecialchars($client_name); ?></p>
                                        <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($user_display); ?></p>
                                    </div>
                                </div>
                                <div class="card-status">
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <i class="fas <?php echo isset($user_id) ? 'fa-check-circle' : 'fa-clock'; ?>"></i>
                                        <?php echo $status_text; ?>
                                    </span>
                                    <a href="usercontrol-contact.php?contact_id=<?php echo $contact_id; ?>" class="edit-btn">
                                        <i class="fas fa-edit"></i>
                                        Edit Contact
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                ?>
                    <div class="empty-state">
                        <i class="fas fa-address-book"></i>
                        <h4>No Contacts Found</h4>
                        <p>No contacts have been created yet.</p>
                    </div>
                <?php } ?>
            </div>

            <!-- Users Section -->
            <div class="control-section">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Existing Users
                </h3>
                
                <?php
                $sql = "SELECT * FROM users ORDER BY user_id ASC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        $user_id = $row->user_id;
                        $user_name = $row->user_name;
                        $user_email = $row->user_email;
                        $first_name = $row->first_name;
                        $last_name = $row->last_name;
                        $user_status = $row->user_status ?? 1;
                        
                        $status_class = $user_status ? 'status-active' : 'status-unassigned';
                        $status_text = $user_status ? 'Active' : 'Inactive';
                ?>
                        <div class="item-card">
                            <div class="card-header">
                                <div class="card-info">
                                    <div class="card-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></div>
                                    <div class="card-details">
                                        <p><i class="fas fa-user"></i> Username: <?php echo htmlspecialchars($user_name); ?></p>
                                        <p><i class="fas fa-envelope"></i> Email: <?php echo htmlspecialchars($user_email); ?></p>
                                        <p><i class="fas fa-id-badge"></i> User ID: <?php echo $user_id; ?></p>
                                    </div>
                                </div>
                                <div class="card-status">
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <i class="fas <?php echo $user_status ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                        <?php echo $status_text; ?>
                                    </span>
                                    <a href="user-control-user.php?user_id=<?php echo $user_id; ?>" class="edit-btn">
                                        <i class="fas fa-edit"></i>
                                        Edit User
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                ?>
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>No Users Found</h4>
                        <p>No user accounts have been created yet.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const cards = document.querySelectorAll('.control-section, .item-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });

    // Add loading states to edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.opacity = '0.7';
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        });
    });
});
</script>

</body>
</html>

<?php
include 'includes/footer.php';
?>