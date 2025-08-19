<?php
$title = "Employee Dashboard";
include 'includes/header-new.php';
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT employee_first_name, employee_last_name FROM employees WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['employee_first_name'] . " " . $row['employee_last_name'];
} else {
    $user_name = "Employee";
}

// Fetch favorite templates
$favoritesQuery = "SELECT f.deliverable_id, d.category, d.title, d.description, d.price 
FROM favourites AS f 
JOIN deliverables AS d ON f.deliverable_id = d.deliverable_id 
WHERE f.user_id = $user_id";
$favoritesResult = $conn->query($favoritesQuery);

// Fetch recent activity
$recentActivityQuery = "SELECT proposal_id, proposal_title AS title, creation_date, value 
FROM proposals 
WHERE employee_id = $user_id OR client_id = $user_id 
ORDER BY creation_date DESC LIMIT 5";
$recentActivityResult = $conn->query($recentActivityQuery);


function shortenText($text, $maxChars = 100)
{
    if (strlen($text) <= $maxChars) {
        return $text;
    }
    $cutOffText = substr($text, 0, $maxChars);
    $lastSpace = strrpos($cutOffText, ' ');
    return $lastSpace === false ? $cutOffText . "..." : substr($cutOffText, 0, $lastSpace) . "...";
}

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

    /* Modern Welcome Banner */
    .welcome-banner {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .welcome-banner .content {
        position: relative;
        z-index: 2;
    }

    .welcome-banner h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .welcome-banner p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Modern Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .action-btn {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-lg);
        padding: 2rem 1.5rem;
        text-decoration: none;
        color: var(--text-dark);
        transition: var(--transition);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-color);
        transform: scaleY(0);
        transition: var(--transition);
    }

    .action-btn:hover {
        color: var(--text-dark);
        text-decoration: none;
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-color);
    }

    .action-btn:hover::before {
        transform: scaleY(1);
    }

    .action-btn i {
        font-size: 2rem;
        color: var(--primary-color);
        flex-shrink: 0;
    }

    .action-btn-content {
        flex-grow: 1;
    }

    .action-btn-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--text-dark);
    }

    .action-btn-subtitle {
        color: var(--text-light);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Modern Cards */
    .modern-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .modern-card-header {
        background: var(--bg-gradient);
        color: white;
        padding: 1.5rem;
        border-radius: 0;
        border: none;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card-header i {
        font-size: 1.25rem;
    }

    .modern-card-body {
        padding: 2rem;
    }

    /* Activity Items */
    .activity-item {
        padding: 1.5rem 0;
        border-bottom: 1px solid #e5e7eb;
        transition: var(--transition);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: var(--bg-secondary);
        margin: 0 -2rem;
        padding-left: 2rem;
        padding-right: 2rem;
        border-radius: var(--border-radius);
    }

    .activity-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .activity-meta {
        color: var(--text-light);
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .activity-meta i {
        color: var(--primary-color);
    }

    .activity-value {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .activity-actions {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-top: 0.75rem;
    }

    /* Template Cards */
    .template-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .template-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-color);
    }

    .template-title {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        text-decoration: none;
        display: block;
        transition: var(--transition);
    }

    .template-title:hover {
        color: var(--primary-dark);
        text-decoration: none;
    }

    .template-category {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .template-description {
        color: var(--text-light);
        margin-bottom: 1rem;
        line-height: 1.6;
        font-size: 0.925rem;
    }

    .template-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1rem;
    }

    .template-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    /* Modern Buttons */
    .btn-modern {
        background: var(--bg-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-modern:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.625rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        cursor: pointer;
    }

    .btn-danger-modern:hover {
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    /* Container improvements */
    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .welcome-banner h1 {
            font-size: 2rem;
        }
        
        .action-buttons {
            grid-template-columns: 1fr;
        }
        
        .main-container {
            padding: 1rem;
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--text-light);
    }
</style>
<div class="main-container">
    <!-- Modern Welcome Banner -->
    <div class="welcome-banner">
        <div class="content">
            <h1>
                <i class="fas fa-tachometer-alt"></i>
                Welcome back, <?php echo htmlspecialchars($user_name); ?>
            </h1>
            <p>Manage your proposals, templates, and clients from your professional dashboard</p>
        </div>
    </div>

    <!-- Modern Action Buttons -->
    <div class="action-buttons">
        <a href="proposal-creation.php" class="action-btn">
            <i class="fas fa-plus-circle"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">Create Proposal</div>
                <div class="action-btn-subtitle">Start a new client proposal</div>
            </div>
        </a>
        <a href="create-template.php" class="action-btn">
            <i class="fas fa-layer-group"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">Create Template</div>
                <div class="action-btn-subtitle">Build reusable templates</div>
            </div>
        </a>
        <a href="your-proposals.php" class="action-btn">
            <i class="fas fa-comments"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">Client Responses</div>
                <div class="action-btn-subtitle">View client feedback</div>
            </div>
        </a>
        <a href="employee-usercontrol.php" class="action-btn">
            <i class="fas fa-users-cog"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">User Control</div>
                <div class="action-btn-subtitle">Manage system users</div>
            </div>
        </a>
        <a href="templates.php" class="action-btn">
            <i class="fas fa-folder-open"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">Browse Templates</div>
                <div class="action-btn-subtitle">View all templates</div>
            </div>
        </a>
        <a href="proposals.php" class="action-btn">
            <i class="fas fa-file-alt"></i>
            <div class="action-btn-content">
                <div class="action-btn-title">All Proposals</div>
                <div class="action-btn-subtitle">Manage all proposals</div>
            </div>
        </a>
    </div>

    <div class="row">
        <!-- Recent Activity Section -->
        <div class="col-lg-6 mb-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <i class="fas fa-clock"></i>Recent Activity
                </div>
                <div class="modern-card-body">
                    <?php if ($recentActivityResult->num_rows > 0) : ?>
                        <?php while ($row = $recentActivityResult->fetch_assoc()) : ?>
                            <div class="activity-item">
                                <div class="activity-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="activity-meta">
                                    <i class="fas fa-calendar-alt"></i>
                                    Created: <?php echo date('M j, Y', strtotime($row['creation_date'])); ?>
                                </div>
                                <div class="activity-actions">
                                    <span class="activity-value">$<?php echo number_format($row['value'], 2); ?></span>
                                    <a href="proposal-details.php?proposal_id=<?php echo $row['proposal_id']; ?>" class="btn-modern">
                                        <i class="fas fa-eye"></i>View Details
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h5>No Recent Activity</h5>
                            <p>Your recent proposals and activities will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Favorite Templates Section -->
        <div class="col-lg-6 mb-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <i class="fas fa-heart"></i>Favorite Templates
                </div>
                <div class="modern-card-body">
                    <?php if ($favoritesResult->num_rows > 0) : ?>
                        <?php while ($row = $favoritesResult->fetch_assoc()) : ?>
                            <div class="template-card">
                                <a href="update-template.php?deliverable_id=<?php echo $row['deliverable_id']; ?>" class="template-title">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                                <div class="template-category">
                                    <?php echo htmlspecialchars($row['category']); ?>
                                </div>
                                <div class="template-description">
                                    <?php echo strip_tags(shortenText($row['description'])); ?>
                                </div>
                                <div class="template-actions">
                                    <span class="template-price">$<?php echo number_format($row['price'], 2); ?></span>
                                    <form method="POST" action="delete-fav-template.php" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this from favorites?');">
                                        <input type="hidden" name="deliverable_id" value="<?php echo $row['deliverable_id']; ?>">
                                        <button type="submit" class="btn-danger-modern" title="Remove from favorites">
                                            <i class="fas fa-heart-broken"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="empty-state">
                            <i class="fas fa-heart"></i>
                            <h5>No Favorite Templates</h5>
                            <p>Templates you mark as favorites will appear here for quick access.</p>
                            <a href="templates.php" class="btn-modern" style="margin-top: 1rem;">
                                <i class="fas fa-search"></i>Browse Templates
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        // Modern tooltip initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add loading states to action buttons
            document.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.style.opacity = '0.7';
                    this.style.transform = 'scale(0.98)';
                });
            });

            // Add smooth animations on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards
            document.querySelectorAll('.modern-card, .template-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>

</body>

</html>