<?php
// [Modernization] Improved templates page, fixed broken favourite function, the show/hide button was broken for hiding templates, and fixed the buggy accordion. Fully updated UI as well. (Feb 28 2025)
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

$templates_sql = "SELECT deliverable_id, title, description, price, category, visible FROM deliverables ORDER BY category ASC";
$templates_result = $conn->query($templates_sql);
?>

<!DOCTYPE html>
<html lang="en">

<style>
    .template-item p {
        color: #333 !important;
    }

    .jumbotron {
        background-color: #007bff;
        color: white;
        padding: 2rem 1rem;
        margin-bottom: 3rem;
        border-radius: 0.3rem;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .eye-icon-box {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .eye-icon {
        color: black !important;
    }

    .bigger-eye {
        font-size: 18px;
    }

    .eye-icon:hover {
        color: #6c757d;
    }

    .buttons-container {
        padding-bottom: 1rem;
    }

    .btn-new-template {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-new-template:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .dropdown {
        display: flex;
        justify-content: flex-end;
    }

    .dropdown .btn-secondary {
        padding: 0.5rem 1rem;
        line-height: 2;

    }

    .dropdown .btn-secondary i {
        vertical-align: middle;
    }
</style>


<body>
    <div class="container">
        <div class="jumbotron bg-primary text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><?php echo $welcome_message; ?></h2>
                </div>
            </div>
        </div>
    </div>
    </div>


    <div class="container">
        <div class="row buttons-container">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="create-template.php" class="btn btn-success btn-new-template">New Template</a>
                        <a href="employee-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                    <button class="btn <?= $viewHidden ? 'closed-eye' : 'open-eye' ?>" id="viewHiddenBtn" title="<?= $viewHidden ? 'Hide Hidden' : 'View Hidden' ?>">
                        <div class="eye-icon-box">
                            <i class="fas <?= $viewHidden ? 'fa-eye-slash' : 'fa-eye' ?> eye-icon bigger-eye"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col">
                <div class="search-bar mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search templates...">
                </div>
                <div class="accordion" id="templateAccordion" data-bs-parent="#templateAccordion">
                    <?php if ($templates_result->num_rows > 0) : ?>
                        <?php
                        $categories = []; // Initialize array to store categories
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

                        foreach ($categories as $category => $data) :
                            $visibleClass = $data['visible'] ? 'show' : 'hidden-item';
                        ?>
                            <div class="card">
                                <div class="card-header" id="heading<?= htmlspecialchars(str_replace(' ', '_', $category)); ?>">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link text-left <?= $visibleClass; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= htmlspecialchars(str_replace(' ', '_', $category)); ?>" aria-expanded="false" aria-controls="collapse<?= htmlspecialchars(str_replace(' ', '_', $category)); ?>">
                                            <?= htmlspecialchars($category); ?>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse<?= htmlspecialchars(str_replace(' ', '_', $category)); ?>" class="collapse <?= $visibleClass; ?>" aria-labelledby="heading<?= htmlspecialchars(str_replace(' ', '_', $category)); ?>" data-parent="#templateAccordion">
                                    <div class="card-body">
                                        <?php foreach ($data['templates'] as $template) : ?>
                                            <div class="template-item mb-3 <?= $template['visible'] ? '' : 'hidden-item'; ?>">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="card-title text-dark"><?= htmlspecialchars($template['title']); ?></h5>

                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $template['deliverable_id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?= $template['deliverable_id']; ?>">
                                                            <li><a class="dropdown-item" href="#" onclick="editTemplate('<?= $template['deliverable_id']; ?>', '<?= addslashes($template['title']); ?>', '<?= addslashes($template['description']); ?>', '<?= $template['price']; ?>', '<?= addslashes($template['category']); ?>'); return false;">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="deleteTemplate('<?= $template['deliverable_id']; ?>'); return false;">Delete</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="toggleTemplateVisibility('<?= $template['deliverable_id']; ?>', <?= $template['visible'] ? 'true' : 'false'; ?>); return false;"><?= $template['visible'] ? 'Hide' : 'Unhide'; ?></a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="addToFavorites('<?= $template['deliverable_id']; ?>'); return false;">Add to Favorites</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No templates found.</p>
                    <?php endif; ?>
                </div> <!-- Close accordion -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize visibility status
            var showHidden = false;

            // Initial fetch of templates with visible = 1
            fetchTemplates();

            // Search functionality
            $('#search').keyup(function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.template-item').each(function() {
                    var item = $(this);
                    var text = item.text().toLowerCase();
                    var match = text.indexOf(searchTerm) > -1;
                    item.closest('.card').toggle(match);
                });
            });

            $('#viewHiddenBtn').click(function() {
                // Toggle visibility status
                showHidden = !showHidden;

                // Toggle eye icon and update tooltip
                $(this).toggleClass('closed-eye open-eye');
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
                $(this).attr('title', showHidden ? 'Hide Hidden' : 'View Hidden');

                // Toggle visibility of hidden templates in the DOM
                fetchTemplates(showHidden);
            });
        });

        function fetchTemplates(showHidden = false) {
            $.ajax({
                type: "GET",
                url: "fetch-templates.php",
                data: {
                    view_hidden: showHidden ? 'true' : 'false'
                },
                success: function(response) {
                    // Update accordion content
                    $('#templateAccordion').html(response);

                    // Explicitly collapse all accordion items if hidden view is collapsed
                    if (!showHidden) {
                        $('.collapse').removeClass('show').addClass('hidden-item');
                    }
                },

            });
        }


        function editTemplate(deliverableId, title, description, price, category) {
            // Encode parameters to ensure special characters are handled correctly
            var encodedTitle = encodeURIComponent(title);
            var encodedDescription = encodeURIComponent(description);
            var encodedPrice = encodeURIComponent(price);
            var encodedCategory = encodeURIComponent(category);

            var url = `update-template.php?deliverable_id=${deliverableId}&title=${encodedTitle}&description=${encodedDescription}&price=${encodedPrice}&category=${encodedCategory}`;
            window.location.href = url;
        }

        function deleteTemplate(deliverableId) {
            if (confirm('Are you sure you want to delete this template?')) {
                $.ajax({
                    type: "POST",
                    url: "delete-template.php",
                    data: {
                        deliverable_id: deliverableId
                    },
                    success: function(response) {
                        alert("Template deleted successfully.");
                        location.reload();
                    },
                    error: function() {
                        alert("An error occurred while deleting the template.");
                    }
                });
            }
        }

        function toggleTemplateVisibility(deliverableId, currentVisibility) {
            var newVisibility = currentVisibility ? 0 : 1; // Toggle visibility

            $.ajax({
                type: "POST",
                url: "toggle-visibility.php",
                data: {
                    deliverable_id: deliverableId,
                    visible: newVisibility
                },
                success: function(response) {
                    // Update visibility of template in the DOM
                    var templateItem = $('.template-item[data-deliverable-id="' + deliverableId + '"]');
                    templateItem.toggleClass('hidden-item', newVisibility === 0);
                    templateItem.attr('data-visible', newVisibility);

                    // Reload the page if "View Hidden" is clicked and a hidden template is toggled
                    var viewHiddenBtn = $('#viewHiddenBtn');
                    if (viewHiddenBtn.text().includes('Hide Hidden') && newVisibility === 1) {
                        location.reload();
                    } else {
                        alert("Template visibility updated.");
                    }
                },
                error: function() {
                    alert("An error occurred while updating template visibility.");
                }
            });
        }

        function addToFavorites(deliverableId) {
            $.ajax({
                type: "POST",
                url: "add_to_favorites.php",
                data: {
                    deliverable_id: deliverableId
                },
                success: function(response) {
                    alert("Template added to favorites.");
                },
                error: function() {
                    alert("An error occurred while adding the template to favorites.");
                }
            });
        }
    </script>
</body>

</html>