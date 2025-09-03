<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = "Templates";
include 'includes/header-new.php';
include 'connect.php';

$user_id = $_SESSION['user_id'] ?? null;
$welcome_message = "Welcome to our Templates Page!";

if ($user_id) {
    $stmt = $conn->prepare("SELECT employee_first_name, employee_last_name FROM employees WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_first_name = $row['employee_first_name'];
        $welcome_message = "Welcome back, $user_first_name!";
    }
}

$viewHidden = isset($_GET['viewHidden']) ? (bool)$_GET['viewHidden'] : false;
$templates_sql = "SELECT deliverable_id, title, description, price, category, visible FROM deliverables ORDER BY category ASC, title ASC";
$templates_result = $conn->query($templates_sql);

// Get statistics
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN visible = 1 THEN 1 ELSE 0 END) as visible_count,
    COUNT(DISTINCT category) as categories_count
FROM deliverables";
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
        margin: 0 0 0.5rem 0;
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
        color: var(--primary-color);
    }

    .stat-label {
        color: var(--text-light);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

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
        align-items: center;
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
        border: none;
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

    .visibility-toggle {
        background: white;
        border: 2px solid #e5e7eb;
        color: var(--text-dark);
        padding: 0.75rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .visibility-toggle:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .visibility-toggle.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Search Section */
    .search-container {
        position: relative;
        margin-bottom: 1rem;
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

    /* Category Sections */
    .category-section {
        background: white;
        border-radius: var(--border-radius-lg);
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .category-header {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-header:hover {
        background: #e5e7eb;
    }

    .category-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .category-count {
        background: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .category-icon {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .expand-icon {
        color: var(--text-light);
        transition: var(--transition);
        font-size: 1.25rem;
    }

    .category-header.expanded .expand-icon {
        transform: rotate(180deg);
    }

    .category-content {
        display: none;
        padding: 0;
    }

    .category-content.show {
        display: block;
    }

    /* Template Grid */
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .template-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .template-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .template-card.hidden-item {
        opacity: 0.7;
        border: 2px dashed #d1d5db;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        position: relative;
    }

    .template-card.hidden-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(0, 0, 0, 0.03) 10px,
            rgba(0, 0, 0, 0.03) 20px
        );
        pointer-events: none;
    }

    .template-card.hidden-item:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        border-color: #9ca3af;
    }

    .template-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--bg-gradient);
    }

    .template-header {
        margin-bottom: 1rem;
    }

    .template-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .template-description {
        color: var(--text-light);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .template-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .template-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
    }

    .action-btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .action-btn-primary:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
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
    }

    .action-btn-success {
        background: var(--success-color);
        color: white;
    }

    .action-btn-success:hover {
        background: #059669;
        color: white;
        text-decoration: none;
    }

    .action-btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .action-btn-warning:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
    }

    /* Visibility Badge */
    .visibility-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .visibility-badge.visible {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .visibility-badge.hidden {
        background: rgba(107, 114, 128, 0.1);
        color: var(--text-light);
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
        
        .action-buttons {
            flex-direction: column;
        }
        
        .templates-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .template-actions {
            flex-direction: column;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-layer-group"></i>
                Template Management
            </h1>
            <p class="mb-0"><?php echo htmlspecialchars($welcome_message); ?></p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $stats['total']; ?></div>
            <div class="stat-label">Total Templates</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $stats['visible_count']; ?></div>
            <div class="stat-label">Visible Templates</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $stats['categories_count']; ?></div>
            <div class="stat-label">Categories</div>
        </div>
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
        <div class="controls-top">
            <h3 style="margin: 0; color: var(--text-dark);">Template Library</h3>
            <div class="action-buttons">
                <a href="/mayvis/create-template.php" class="btn-create">
                    <i class="fas fa-plus"></i>
                    New Template
                </a>
                <a href="/mayvis/employee-dashboard.php" class="btn-secondary-modern">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
                <button class="visibility-toggle <?php echo $viewHidden ? 'active' : ''; ?>" id="viewHiddenBtn">
                    <i class="fas fa-<?php echo $viewHidden ? 'eye-slash' : 'eye'; ?>"></i>
                    <?php echo $viewHidden ? 'Hide Hidden' : 'Show Hidden'; ?>
                </button>
            </div>
        </div>

        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="search" class="search-input" placeholder="Search templates by title or description...">
        </div>
    </div>

    <!-- Templates by Category -->
    <?php if ($templates_result->num_rows > 0): ?>
        <?php
        $categories = [];
        $templates_result->data_seek(0); // Reset result pointer
        foreach ($templates_result as $template) {
            $category = $template['category'];
            if (!isset($categories[$category])) {
                $categories[$category] = ['visible' => false, 'templates' => []];
            }
            $categories[$category]['templates'][] = $template;
            if ($template['visible']) {
                $categories[$category]['visible'] = true;
            }
        }

        foreach ($categories as $category => $data):
            $categoryTemplates = $data['templates'];
            $visibleCount = count(array_filter($categoryTemplates, function($t) { return $t['visible']; }));
        ?>
            <div class="category-section" data-category="<?php echo htmlspecialchars($category); ?>">
                <div class="category-header" onclick="toggleCategory('<?php echo htmlspecialchars($category); ?>')">
                    <div class="category-title">
                        <i class="fas fa-folder category-icon"></i>
                        <?php echo htmlspecialchars($category); ?>
                        <span class="category-count"><?php echo count($categoryTemplates); ?></span>
                    </div>
                    <i class="fas fa-chevron-down expand-icon"></i>
                </div>
                
                <div class="category-content" id="category-<?php echo htmlspecialchars($category); ?>">
                    <div class="templates-grid">
                        <?php foreach ($categoryTemplates as $template): ?>
                            <?php if ($template['visible'] || $viewHidden): ?>
                                <div class="template-card template-item <?php echo !$template['visible'] ? 'hidden-item' : ''; ?>" 
                                     data-deliverable-id="<?php echo $template['deliverable_id']; ?>"
                                     data-visible="<?php echo $template['visible']; ?>">
                                    
                                    <div class="visibility-badge <?php echo $template['visible'] ? 'visible' : 'hidden'; ?>">
                                        <?php echo $template['visible'] ? 'Visible' : 'Hidden'; ?>
                                    </div>

                                    <div class="template-header">
                                        <h4 class="template-title"><?php echo htmlspecialchars($template['title']); ?></h4>
                                        <p class="template-description"><?php echo htmlspecialchars($template['description']); ?></p>
                                        <div class="template-price">$<?php echo number_format($template['price'], 2); ?></div>
                                    </div>

                                    <div class="template-actions">
                                        <a href="/mayvis/edit-template.php?deliverable_id=<?php echo $template['deliverable_id']; ?>" 
                                           class="action-btn action-btn-primary">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <button onclick="addToFavorites(<?php echo $template['deliverable_id']; ?>)" 
                                                class="action-btn action-btn-success">
                                            <i class="fas fa-heart"></i>
                                            Favorite
                                        </button>
                                        <button onclick="toggleVisibility(<?php echo $template['deliverable_id']; ?>, <?php echo $template['visible'] ? 0 : 1; ?>)" 
                                                class="action-btn action-btn-<?php echo $template['visible'] ? 'warning' : 'secondary'; ?>">
                                            <i class="fas fa-<?php echo $template['visible'] ? 'eye-slash' : 'eye'; ?>"></i>
                                            <?php echo $template['visible'] ? 'Hide' : 'Show'; ?>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-layer-group"></i>
            <h3>No Templates Found</h3>
            <p>Start building your template library by creating your first template.</p>
            <a href="/mayvis/create-template.php" class="btn-create">
                <i class="fas fa-plus"></i>
                Create Your First Template
            </a>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const templateCards = document.querySelectorAll('.template-card');
        
        templateCards.forEach(card => {
            const title = card.querySelector('.template-title').textContent.toLowerCase();
            const description = card.querySelector('.template-description').textContent.toLowerCase();
            const matches = title.includes(searchTerm) || description.includes(searchTerm);
            
            card.style.display = matches ? 'block' : 'none';
        });

        // Show/hide category sections based on visible templates
        document.querySelectorAll('.category-section').forEach(section => {
            const visibleTemplates = section.querySelectorAll('.template-card[style*="block"], .template-card:not([style*="none"])');
            section.style.display = visibleTemplates.length > 0 ? 'block' : 'none';
        });
    });

    // Visibility toggle - enhanced to work without page reload
    const viewHiddenBtn = document.getElementById('viewHiddenBtn');
    viewHiddenBtn.addEventListener('click', function() {
        const currentUrl = new URL(window.location);
        const isViewingHidden = currentUrl.searchParams.get('viewHidden') === 'true';
        const newViewHidden = !isViewingHidden;
        
        // Update button appearance immediately
        const button = this;
        const icon = button.querySelector('i');
        const buttonText = button.childNodes[button.childNodes.length - 1];
        
        button.classList.toggle('active', newViewHidden);
        icon.className = `fas fa-${newViewHidden ? 'eye-slash' : 'eye'}`;
        buttonText.textContent = newViewHidden ? ' Hide Hidden' : ' Show Hidden';
        
        // Update URL without reload
        currentUrl.searchParams.set('viewHidden', newViewHidden);
        window.history.pushState({}, '', currentUrl.toString());
        
        // Toggle visibility of hidden templates
        const hiddenTemplates = document.querySelectorAll('.template-item[data-visible="0"]');
        const categoryContainers = document.querySelectorAll('.category-section');
        
        if (newViewHidden) {
            // Show hidden templates
            hiddenTemplates.forEach(template => {
                template.style.display = 'block';
                template.style.opacity = '0';
                template.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    template.style.transition = 'all 0.3s ease';
                    template.style.opacity = '1';
                    template.style.transform = 'translateY(0)';
                }, 50);
            });
            
            // Show categories that might have been hidden
            categoryContainers.forEach(category => {
                const templatesInCategory = category.querySelectorAll('.template-item');
                if (templatesInCategory.length > 0) {
                    category.style.display = 'block';
                }
            });
        } else {
            // Hide hidden templates
            hiddenTemplates.forEach(template => {
                template.style.transition = 'all 0.3s ease';
                template.style.opacity = '0';
                template.style.transform = 'translateY(-20px)';
                
                setTimeout(() => {
                    template.style.display = 'none';
                }, 300);
            });
            
            // Hide categories that have no visible templates
            setTimeout(() => {
                categoryContainers.forEach(category => {
                    const visibleTemplatesInCategory = category.querySelectorAll('.template-item[data-visible="1"]:not([style*="display: none"])');
                    if (visibleTemplatesInCategory.length === 0) {
                        category.style.transition = 'all 0.3s ease';
                        category.style.opacity = '0';
                        category.style.transform = 'translateY(-20px)';
                        
                        setTimeout(() => {
                            category.style.display = 'none';
                        }, 300);
                    }
                });
            }, 350);
        }
        
        // Update statistics
        updateStatistics();
    });

    // Smooth animations on load
    const cards = document.querySelectorAll('.template-card, .stat-card, .category-section');
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

function toggleCategory(category) {
    const content = document.getElementById(`category-${category}`);
    const header = content.previousElementSibling;
    
    if (content.classList.contains('show')) {
        content.classList.remove('show');
        header.classList.remove('expanded');
    } else {
        content.classList.add('show');
        header.classList.add('expanded');
    }
}

function toggleVisibility(deliverableId, newVisibility) {
    // Add loading state to button
    const button = $(`.template-item[data-deliverable-id="${deliverableId}"] button[onclick*="toggleVisibility"]`);
    const originalText = button.html();
    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
    
    $.ajax({
        type: "POST",
        url: "toggle-visibility.php",
        dataType: "json",
        data: {
            deliverable_id: deliverableId,
            visible: newVisibility
        },
        success: function(response) {
            if (response.success) {
                // Update the template card
                const templateCard = $(`.template-item[data-deliverable-id="${deliverableId}"]`);
                templateCard.attr('data-visible', newVisibility);
                
                // Update visibility badge
                const badge = templateCard.find('.visibility-badge');
                badge.removeClass('visible hidden').addClass(newVisibility ? 'visible' : 'hidden');
                badge.text(newVisibility ? 'Visible' : 'Hidden');
                
                // Update template card class
                templateCard.toggleClass('hidden-item', newVisibility === 0);
                
                // Update button
                button.attr('onclick', `toggleVisibility(${deliverableId}, ${newVisibility ? 0 : 1})`);
                button.removeClass('action-btn-warning action-btn-secondary').addClass(newVisibility ? 'action-btn-warning' : 'action-btn-secondary');
                button.html(`<i class="fas fa-${newVisibility ? 'eye-slash' : 'eye'}"></i> ${newVisibility ? 'Hide' : 'Show'}`);
                
                // Check if we need to hide the template based on current view mode
                const currentUrl = new URL(window.location);
                const isViewingHidden = currentUrl.searchParams.get('viewHidden') === 'true';
                
                // If we're not viewing hidden templates and this template was just hidden, hide it
                if (!isViewingHidden && newVisibility === 0) {
                    templateCard.fadeOut(300, function() {
                        // Check if this was the last visible template in this category
                        const categorySection = templateCard.closest('.category-section');
                        const visibleTemplatesInCategory = categorySection.find('.template-item[data-visible="1"]:visible');
                        
                        if (visibleTemplatesInCategory.length === 0) {
                            categorySection.fadeOut(300);
                        }
                    });
                }
                
                // Update statistics
                updateStatistics();
                
                // Show success message
                showNotification('Template visibility updated successfully!', 'success');
            } else {
                // Handle error from server
                showNotification(response.error || 'Failed to update template visibility', 'error');
                button.html(originalText);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            let errorMessage = 'An error occurred while updating template visibility.';
            
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            
            showNotification(errorMessage, 'error');
            button.html(originalText);
        },
        complete: function() {
            // Re-enable button
            button.prop('disabled', false);
        }
    });
}

// Function to update statistics
function updateStatistics() {
    const totalTemplates = $('.template-item').length;
    const visibleTemplates = $('.template-item[data-visible="1"]').length;
    const hiddenTemplates = totalTemplates - visibleTemplates;
    
    // Update stats if they exist on the page
    const totalStat = $('.stat-card .stat-number').eq(0);
    const visibleStat = $('.stat-card .stat-number').eq(1);
    
    if (totalStat.length) totalStat.text(totalTemplates);
    if (visibleStat.length) visibleStat.text(visibleTemplates);
}

function addToFavorites(deliverableId) {
    // Add loading state to button
    const button = $(`.template-item[data-deliverable-id="${deliverableId}"] button[onclick*="addToFavorites"]`);
    const originalText = button.html();
    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Adding...');
    
    $.ajax({
        type: "POST",
        url: "add_to_favorites.php",
        data: {
            deliverable_id: deliverableId
        },
        success: function(response) {
            showNotification('Template added to favorites!', 'success');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            showNotification('An error occurred while adding the template to favorites.', 'error');
        },
        complete: function() {
            // Re-enable button and restore text
            button.prop('disabled', false).html(originalText);
        }
    });
}

// Utility function for showing notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#3b82f6'
    };
    
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        background: ${colors[type]};
        color: white;
        font-weight: 600;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateX(400px);
        transition: transform 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        max-width: 400px;
    `;
    
    notification.innerHTML = `<i class="fas fa-${icons[type]}"></i> ${message}`;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}
</script>

</body>
</html>