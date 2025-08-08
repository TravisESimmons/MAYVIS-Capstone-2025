<?php
$title = "Add Template";
include 'includes/header-new.php';

include 'connect.php';


// Define a variable to track validation errors
$errors = [];

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price'])) {
        // Retrieve the submitted data from the form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Validate category
        if (isset($_POST['category']) && $_POST['category'] != "") {
            $category = $_POST['category'];
        } elseif (isset($_POST['newCategory']) && $_POST['newCategory'] != "") {
            $category = $_POST['newCategory'];
        } else {
            $errors[] = "Category is required.";
        }

        // If there are no validation errors
        if (empty($errors)) {
            // Insert the template into the database
            $sql = "INSERT INTO deliverables (title, description, price, category) VALUES ('$title', '$description', '$price', '$category')";

            // Execute the insert query
            if ($conn->query($sql) === TRUE) {
                // If insert is successful, redirect the user to the templates directory
                header("Location: templates.php");
                exit; // Stop further execution
            } else {
                // If an error occurs during insert
                echo "Error creating template: " . $conn->error;
            }
        } else {
            // If there are validation errors
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    } else {
        // If required fields are not set
        echo "Error: All fields are required.";
    }
}
?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


<style>
    .ql-toolbar .ql-picker-label,

    .ql-toolbar button {
        color: white;
    }

    .ql-toolbar button {
        background-color: transparent;
    }

    .ql-snow .ql-stroke {
        stroke: white;
    }

    .ql-snow .ql-fill,
    .ql-snow .ql-stroke.ql-fill {
        fill: white;
    }
</style>

<body class='bg-dark'>
    <div class="container mt-5 text-light">
        <h2>Submit Form</h2>
        <form method="POST" action="create-template.php">
            <!-- Category selection -->
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="" selected disabled>Select Category</option>
                    <?php

                    $sql = "SELECT DISTINCT category FROM deliverables ORDER BY category ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
                        }
                    }
                    ?>

                </select>
            </div>

            <button type="button" class="btn btn-primary mb-3" data-toggle="collapse" data-target="#newCategoryInput">Create New Category</button>

            <div class="form-group collapse" id="newCategoryInput">
                <label for="newCategory">New Category</label>
                <input type="text" class="form-control" id="newCategory" name="newCategory">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <div id="editor-container"></div> <!-- Quill editor will be initialized here -->
                <textarea name="description" id="description" style="display:none;"></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill('#editor-container', {
                theme: 'snow'
            });

            var form = document.querySelector('form');
            form.onsubmit = function() {
                var description = document.querySelector('textarea[name="description"]');
                description.value = quill.root.innerHTML;
            };
        });
    </script>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>