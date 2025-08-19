<?php
$title = "Deliverables";
include 'includes/header-new.php';
include('connect.php');
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
        font-size: 2.5rem;
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

    /* Content Area */
    .content-container {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid #e5e7eb;
    }

    /* Deliverables Grid */
    .deliverables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .deliverable-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        border: 2px solid #e5e7eb;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .deliverable-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .deliverable-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--bg-gradient);
    }

    .deliverable-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .deliverable-description {
        color: var(--text-light);
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .deliverable-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .deliverable-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .deliverable-category {
        background: var(--bg-gradient);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .deliverable-id {
        font-size: 0.75rem;
        color: var(--text-light);
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
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
    }

    /* Error State */
    .error-message {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 1rem;
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Stats Bar */
    .stats-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: var(--border-radius);
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .content-container {
            padding: 1.5rem;
        }
        
        .deliverables-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.75rem;
        }

        .stats-bar {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-boxes"></i>
                Deliverables
            </h1>
            <p class="page-subtitle">Browse and manage all available deliverable templates</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-buttons">
        <a href="/mayvis/templates.php" class="btn-nav">
            <i class="fas fa-arrow-left"></i>
            Back to Templates
        </a>
        <a href="/mayvis/employee-dashboard.php" class="btn-nav">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </a>
    </div>

    <!-- Content Container -->
    <div class="content-container">
        <?php 
        $sql = "SELECT * FROM deliverables ORDER BY category, title";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_error($conn)) {
            echo '<div class="error-message">';
            echo '<i class="fas fa-exclamation-triangle"></i>';
            echo '<span>There was a problem loading deliverables. Please try again later.</span>';
            echo '</div>';
        } else {
            $total_deliverables = mysqli_num_rows($result);
            
            if ($total_deliverables > 0) {
                // Calculate stats
                $categories = [];
                $total_value = 0;
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    $categories[$row['category']] = ($categories[$row['category']] ?? 0) + 1;
                    $total_value += floatval($row['price']);
                }
                $unique_categories = count($categories);
                $avg_price = $total_value / $total_deliverables;
                
                // Stats Bar
                echo '<div class="stats-bar">';
                echo '<div class="stat-item">';
                echo '<span class="stat-number">' . $total_deliverables . '</span>';
                echo '<span class="stat-label">Total Deliverables</span>';
                echo '</div>';
                echo '<div class="stat-item">';
                echo '<span class="stat-number">' . $unique_categories . '</span>';
                echo '<span class="stat-label">Categories</span>';
                echo '</div>';
                echo '<div class="stat-item">';
                echo '<span class="stat-number">$' . number_format($avg_price, 0) . '</span>';
                echo '<span class="stat-label">Average Price</span>';
                echo '</div>';
                echo '</div>';
                
                // Deliverables Grid
                echo '<div class="deliverables-grid">';
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = htmlspecialchars($row['title']);
                    $description = htmlspecialchars($row['description']);
                    $deliverable_id = htmlspecialchars($row['deliverable_id']);
                    $price = number_format(floatval($row['price']), 2);
                    $category = htmlspecialchars($row['category']);
                    
                    echo '<div class="deliverable-card">';
                    echo '<div class="deliverable-id">ID: ' . $deliverable_id . '</div>';
                    echo '<div class="deliverable-title">' . $title . '</div>';
                    echo '<div class="deliverable-description">' . $description . '</div>';
                    echo '<div class="deliverable-meta">';
                    echo '<div class="deliverable-price">$' . $price . '</div>';
                    echo '<div class="deliverable-category">' . $category . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                // Empty State
                echo '<div class="empty-state">';
                echo '<i class="fas fa-box-open"></i>';
                echo '<h3>No Deliverables Found</h3>';
                echo '<p>There are currently no deliverables available in the system.</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const containers = document.querySelectorAll('.content-container, .page-header');
    containers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        setTimeout(() => {
            container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animate deliverable cards
    const cards = document.querySelectorAll('.deliverable-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 300 + (index * 50));
    });
});
</script>

</body>
</html>