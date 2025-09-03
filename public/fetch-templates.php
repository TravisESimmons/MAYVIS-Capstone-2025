<?php
// Include necessary files and initialize database connection if needed
include 'connect.php';

// Fetch templates from the database based on their visibility
$viewHidden = isset($_GET['view_hidden']) && $_GET['view_hidden'] == 'true';
$visibilityCondition = $viewHidden ? 'visible = 0' : 'visible = 1';

$templates_sql = "SELECT deliverable_id, title, description, price, category, visible FROM deliverables WHERE $visibilityCondition ORDER BY category ASC";
$templates_result = $conn->query($templates_sql);

if ($viewHidden) {
    echo '<h3>Viewing Hidden Templates</h3>';
} else {
    echo '<h3>Viewing Visible Templates</h3>';
}


// Check if templates are found
if ($templates_result->num_rows > 0) {
    // Initialize array to store categories and templates
    $categories = [];

    // Iterate through templates and organize them by category
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

    // Output the HTML for the accordion list
    foreach ($categories as $category => $data) {
        $visibleClass = $data['visible'] ? 'show' : 'hidden-item';
        echo '<div class="card">';
        echo '<div class="card-header" id="heading' . htmlspecialchars(str_replace(' ', '_', $category)) . '">';
        echo '<h2 class="mb-0">';
        echo '<button class="btn btn-link text-left ' . $visibleClass . '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . htmlspecialchars(str_replace(' ', '_', $category)) . '" aria-expanded="' . ($data['visible'] ? 'true' : 'false') . '" aria-controls="collapse' . htmlspecialchars(str_replace(' ', '_', $category)) . '">';
        echo htmlspecialchars($category);
        echo '</button>';
        echo '</h2>';
        echo '</div>';
        // Add 'collapsed' class to collapse element to ensure it's closed by default
        echo '<div id="collapse' . htmlspecialchars(str_replace(' ', '_', $category)) . '" class="collapse ' . $visibleClass . ' collapsed" aria-labelledby="heading' . htmlspecialchars(str_replace(' ', '_', $category)) . '" data-parent="#templateAccordion">';
        echo '<div class="card-body">';
        foreach ($data['templates'] as $template) {
            echo '<div class="template-item mb-3 ' . ($template['visible'] ? '' : 'hidden-item') . '">';
            echo '<h5 class="card-title text-dark">' . htmlspecialchars($template['title']) . '</h5>';
            $allowedTags = '<strong><em><b><i><u><br><p><ul><ol><li>';
            echo '<p class="card-text text-dark">' . htmlspecialchars_decode(strip_tags($template['description'], $allowedTags)) . '</p>';
            echo '<div class="dropdown">';
            echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton' . $template['deliverable_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
            echo '<i class="fas fa-ellipsis-v"></i>';
            echo '</button>';
            echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $template['deliverable_id'] . '">';
            echo '<li><a class="dropdown-item" href="#" onclick="editTemplate(' . $template['deliverable_id'] . '); return false;">Edit</a></li>';
            echo '<li><a class="dropdown-item" href="#" onclick="deleteTemplate(' . $template['deliverable_id'] . '); return false;">Delete</a></li>';
            echo '<li><a class="dropdown-item" href="#" onclick="toggleTemplateVisibility(' . $template['deliverable_id'] . ', ' . ($template['visible'] ? 'true' : 'false') . '); return false;">' . ($template['visible'] ? 'Hide' : 'Unhide') . '</a></li>';
            echo '<li><a class="dropdown-item" href="#" onclick="addToFavorites(' . $template['deliverable_id'] . '); return false;">Add to Favorites</a></li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // No templates found
    echo '<p>No templates found.</p>';
}
