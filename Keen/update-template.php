<?php
$title = "Edit Template";
include 'includes/header-new.php';
include 'connect.php';



$deliverable_id = $title = $description = $price = $category = "";
$update_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deliverable_id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['category'])) {
        $deliverable_id = $_POST['deliverable_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // Prepare an update statement
        $sql = "UPDATE deliverables SET title = ?, description = ?, price = ?, category = ? WHERE deliverable_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $title, $description, $price, $category, $deliverable_id);

        // Execute the update query
        if ($stmt->execute()) {
            $update_message = "Template updated successfully!";
        } else {
            echo "Error updating template: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
} else {
    // If the form has not been submitted, retrieve the current data
    if (isset($_GET['deliverable_id'])) {
        $deliverable_id = $_GET['deliverable_id'];
        $query = "SELECT title, description, price, category FROM deliverables WHERE deliverable_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $deliverable_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $category = $row['category'];
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!-- HTML form to display the data to edit -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    /* Custom CSS to change toolbar icon and text colors in Quill editor */
    .ql-toolbar .ql-picker-label,
    .ql-toolbar button {
        color: white;
        /* Change the color of the text and icons */
    }

    .ql-toolbar button {
        background-color: transparent;
        /* Optional: Adjust the background if necessary */
    }

    .ql-snow .ql-stroke {
        stroke: white;
        /* Changes color for icons that are SVG strokes */
    }

    .ql-snow .ql-fill,
    .ql-snow .ql-stroke.ql-fill {
        /* Changes the fill for applicable icons */
        fill: white;
    }
</style>


<body class='bg-dark'>
    <div class="container mt-5 text-light">
        <h2>Edit Template</h2>
        <?php if (!empty($update_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $update_message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="update-template.php">
            <input type="hidden" name="deliverable_id" value="<?php echo $deliverable_id; ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <div id="editor-container" style="height: 200px;"></div>
                <textarea name="description" id="description" class="form-control d-none"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" name="category" value="<?php echo htmlspecialchars($category); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="employee-dashboard.php" class="btn btn-secondary">Back to Employee Dashboard</a>
            <a href="templates.php" class="btn btn-secondary">Back to Templates</a>
        </form>
    </div>
</body>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: true
            }
        });

        // Set the Quill editor's content
        var description = document.querySelector('textarea[name="description"]');
        quill.root.innerHTML = <?php echo json_encode($description); ?>;

        var form = document.querySelector('form');
        form.onsubmit = function() {
            // Sync the Quill editor's content with the textarea before submitting
            description.value = quill.root.innerHTML;
        };
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>