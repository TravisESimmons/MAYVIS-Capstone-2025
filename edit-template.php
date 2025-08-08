<?php
$title = "Edit Template";
include 'includes/header-new.php';

// Check if template data is passed via URL parameters
if (isset($_GET['deliverable_id']) && isset($_GET['title']) && isset($_GET['description']) && isset($_GET['price']) && isset($_GET['category'])) {
    // Get template data from URL parameters
    $deliverable_id = $_GET['deliverable_id'];
    $title = $_GET['title'];
    $description = $_GET['description'];
    $price = $_GET['price'];
    $category = $_GET['category'];
} else {
    // Handle case where data is not provided
    $deliverable_id = "";
    $title = "";
    $description = "";
    $price = "";
    $category = "";
}
?>

<body class='bg-dark'>
    <div class="container mt-5 text-light">
        <h2>Edit Template</h2>
        <form method="POST" action="update_template.php">
            <!-- Hidden field to pass deliverable_id to update_template.php -->
            <input type="hidden" name="deliverable_id" value="<?php echo $deliverable_id; ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $price; ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>