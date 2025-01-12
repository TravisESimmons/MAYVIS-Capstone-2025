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
<!DOCTYPE html>
<html lang="en">

<style>
    .btn-btn-danger {
        outline: 1px solid #0044cc;
        /* A different color of your choice */
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .recent-activity-scroll {
            max-height: 300px;
            overflow-y: auto;
            background-color: #343a40;
            border-radius: 0.25rem;
            padding: 15px;
        }

        .card-body.text-light {
            color: #ccc;
        }

        .card-header.bg-primary {
            background-color: #0062cc;
        }

        .card.bg-transparent {
            background-color: transparent;
            border: 1px solid #ffffff50;
        }

        .btn-primary,
        .btn-danger {
            border-color: #007bff;
        }

        .card-text,
        .card-title,
        .card-subtitle {
            color: #ddd;
        }

        @media (max-width: 767px) {
            .card {
                margin-bottom: 20px;
            }

            .btn-group {
                width: 100%;
                margin-bottom: 20px;
            }

            .btn {
                margin-bottom: 10px;
            }
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <!-- Welcome message banner -->
        <div class="jumbotron bg-primary text-white" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Welcome back, <?php echo htmlspecialchars($user_name); ?></h2>
                </div>
            </div>
        </div>

        <!-- Buttons below the welcome message -->
        <div class="row">
            <div class="col-md-8">
                <div class="btn-group" role="group" aria-label="Dashboard buttons">
                    <a href="proposal-creation.php" class="btn btn-light">Create Proposal</a>
                    <a href="create-template.php" class="btn btn-light">Create Template</a>
                    <a href="your-proposals.php" class="btn btn-light">Client Responses</a>
                    <a href="employee-usercontrol.php" class="btn btn-light">User Control</a>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="templates.php" class="btn btn-light">Templates</a>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Recent Activity Section -->
            <div class="col-md-6">
                <div class="card bg-transparent border-light mb-3 shadow-lg">
                    <div class="card-header bg-primary text-white font-weight-bold">Recent Activity</div>
                    <div class="card-body text-light">
                        <?php if ($recentActivityResult->num_rows > 0) : ?>
                            <?php while ($row = $recentActivityResult->fetch_assoc()) : ?>
                                <div class="mb-3">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text">Created On: <?php echo htmlspecialchars($row['creation_date']); ?></p>
                                    <p class="card-text">Value: $<?php echo htmlspecialchars($row['value']); ?></p>
                                    <a href="proposal-details.php?proposal_id=<?php echo $row['proposal_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                </div>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <p class="card-text">No recent activity found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Favorite Templates Section -->
            <div class="col-md-6">
                <h2 class="text-primary">Favorite Templates</h2>
                <div id="favorite-templates">
                    <?php if ($favoritesResult->num_rows > 0) : ?>
                        <?php while ($row = $favoritesResult->fetch_assoc()) : ?>
                            <div class="card bg-transparent text-light mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="update-template.php?deliverable_id=<?php echo $row['deliverable_id']; ?>">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </a>
                                    </h5>
                                    <p class="card-subtitle mb-2"><?php echo htmlspecialchars($row['category']); ?></p>
                                    <p class="card-text"><?php echo strip_tags(shortenText($row['description'])); ?></p>

                                    <p class="card-text">$<?php echo htmlspecialchars($row['price']); ?></p>
                                    <form method="POST" action="delete-fav-template.php" onsubmit="return confirm('Are you sure you want to delete this template?');">
                                        <input type="hidden" name="deliverable_id" value="<?php echo $row['deliverable_id']; ?>">
                                        <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No favorite templates found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Wait for the document to be fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Get all elements with the class 'edit-template-link'
            const editLinks = document.querySelectorAll('.edit-template-link');

            // Add event listener to each edit link
            editLinks.forEach(function(link) {
                link.addEventListener('mouseover', function(event) {
                    // Prevent the default link behavior
                    event.preventDefault();

                    // Get the deliverable_id from the data attribute
                    const deliverableId = this.getAttribute('data-deliverable-id');

                    // Navigate to the update-template.php page with the deliverable_id as a query parameter
                    window.location.href = `update-template.php?deliverable_id=${deliverableId}`;
                });
            });
        });


        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>