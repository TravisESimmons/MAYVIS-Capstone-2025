<?php
$title = "Create Template";
include 'includes/header-new.php';
include 'connect.php';

// Define a variable to track validation errors
$errors = [];
$success_message = '';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price'])) {
        // Retrieve the submitted data from the form
        $template_title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);

        // Validate category
        if (isset($_POST['category']) && $_POST['category'] != "") {
            $category = trim($_POST['category']);
        } elseif (isset($_POST['newCategory']) && $_POST['newCategory'] != "") {
            $category = trim($_POST['newCategory']);
        } else {
            $errors[] = "Category is required.";
        }

        // Validate inputs
        if (empty($template_title)) {
            $errors[] = "Title is required.";
        }
        if (empty($description)) {
            $errors[] = "Description is required.";
        }
        if ($price <= 0) {
            $errors[] = "Price must be greater than 0.";
        }

        // If there are no validation errors
        if (empty($errors)) {
            // Use prepared statement for security
            $sql = "INSERT INTO deliverables (title, description, price, category) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssds", $template_title, $description, $price, $category);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Template created successfully!";
                header("Location: templates.php");
                exit;
            } else {
                $errors[] = "Error creating template: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        $errors[] = "All required fields must be filled.";
    }
}
?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
        max-width: 800px;
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

    /* Form Container */
    .form-container {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid #e5e7eb;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: white;
        color: var(--text-dark);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-control:hover {
        border-color: var(--primary-color);
    }

    /* Select Styling */
    select.form-control {
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="%236b7280" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>');
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
        padding-right: 2.5rem;
        appearance: none;
    }

    /* Toggle Button */
    .toggle-btn {
        background: var(--bg-secondary);
        color: var(--text-dark);
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .toggle-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .toggle-btn.active {
        background: var(--bg-gradient);
        color: white;
        border-color: var(--primary-color);
        box-shadow: var(--shadow-md);
    }

    .toggle-btn i {
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .toggle-btn.active i {
        transform: rotate(45deg);
    }

    /* Collapsible Content */
    .collapsible {
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease-out;
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        opacity: 0;
    }

    .collapsible.show {
        max-height: 250px;
        padding: 1.5rem;
        border: 2px solid var(--primary-color);
        opacity: 1;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Quill Editor Styling */
    .editor-wrapper {
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        background: white;
        min-height: 180px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .editor-wrapper:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .editor-wrapper.focused {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .ql-toolbar {
        background: var(--bg-secondary);
        border: none;
        border-bottom: 1px solid #e5e7eb;
        padding: 0.75rem;
    }

    .ql-container {
        border: none;
        font-size: 1rem;
        min-height: 120px;
        font-family: inherit;
    }

    .ql-editor {
        min-height: 120px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        line-height: 1.6;
        color: var(--text-dark);
    }

    .ql-editor.ql-blank::before {
        color: var(--text-muted);
        font-style: italic;
        left: 1.25rem;
        right: 1.25rem;
    }

    .ql-toolbar .ql-picker-label,
    .ql-toolbar button {
        color: var(--text-dark);
        padding: 0.375rem;
        border-radius: 4px;
        transition: var(--transition);
    }

    .ql-toolbar button:hover,
    .ql-toolbar .ql-picker-label:hover {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary-color);
    }

    .ql-snow .ql-stroke {
        stroke: var(--text-dark);
    }

    .ql-snow .ql-fill {
        fill: var(--text-dark);
    }

    .ql-snow .ql-tooltip {
        background: white;
        border: 2px solid var(--primary-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
    }

    /* Submit Button */
    .submit-btn {
        background: var(--bg-gradient);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        justify-content: center;
        width: 100%;
        margin-top: 1rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    /* Alert Messages */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success-color);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--error-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .form-container {
            padding: 1.5rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="content">
            <h1 class="page-title">
                <i class="fas fa-plus-circle"></i>
                Create New Template
            </h1>
            <p class="page-subtitle">Add a new deliverable template to your collection</p>
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

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="form-container">
        <h2 class="form-title">
            <i class="fas fa-file-plus"></i>
            Template Details
        </h2>

        <form method="POST" action="create-template.php" id="templateForm">
            <!-- Category Selection -->
            <div class="form-group">
                <label class="form-label" for="category">
                    <i class="fas fa-tag"></i>
                    Category
                </label>
                <select class="form-control" id="category" name="category">
                    <option value="" selected disabled>Select Category</option>
                    <?php
                    $sql = "SELECT DISTINCT category FROM deliverables ORDER BY category ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['category']) . "'>" . htmlspecialchars($row['category']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- New Category Toggle -->
            <button type="button" class="toggle-btn" id="newCategoryToggle">
                <i class="fas fa-plus"></i>
                Create New Category
            </button>

            <!-- New Category Input -->
            <div class="collapsible" id="newCategoryInput">
                <div class="form-group">
                    <label class="form-label" for="newCategory">
                        <i class="fas fa-plus-circle"></i>
                        New Category Name
                    </label>
                    <input type="text" class="form-control" id="newCategory" name="newCategory" placeholder="Enter new category name">
                </div>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label class="form-label" for="title">
                    <i class="fas fa-heading"></i>
                    Title
                </label>
                <input type="text" class="form-control" id="title" name="title" required placeholder="Enter template title">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label" for="description">
                    <i class="fas fa-align-left"></i>
                    Description
                </label>
                <div class="editor-wrapper" id="editorWrapper">
                    <div id="editor-container"></div>
                </div>
                <textarea name="description" id="description" style="display:none;"></textarea>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label class="form-label" for="price">
                    <i class="fas fa-dollar-sign"></i>
                    Price (CAD)
                </label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" required placeholder="0.00">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                Create Template
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Enter template description...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                ['link'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    // Handle editor focus states
    const editorWrapper = document.getElementById('editorWrapper');
    quill.on('selection-change', function(range) {
        if (range) {
            editorWrapper.classList.add('focused');
        } else {
            editorWrapper.classList.remove('focused');
        }
    });

    // Handle form submission
    var form = document.getElementById('templateForm');
    form.onsubmit = function() {
        var description = document.querySelector('textarea[name="description"]');
        description.value = quill.root.innerHTML;
        
        // Simple validation
        if (quill.getText().trim().length === 0) {
            alert('Please enter a description for the template.');
            return false;
        }
    };

    // Handle new category toggle functionality
    const toggleBtn = document.getElementById('newCategoryToggle');
    const collapsible = document.getElementById('newCategoryInput');
    const categorySelect = document.getElementById('category');
    const newCategoryInput = document.getElementById('newCategory');

    toggleBtn.addEventListener('click', function() {
        const isVisible = collapsible.classList.contains('show');
        
        if (isVisible) {
            collapsible.classList.remove('show');
            toggleBtn.classList.remove('active');
            toggleBtn.innerHTML = '<i class="fas fa-plus"></i> Create New Category';
            categorySelect.disabled = false;
            newCategoryInput.value = '';
        } else {
            collapsible.classList.add('show');
            toggleBtn.classList.add('active');
            toggleBtn.innerHTML = '<i class="fas fa-minus"></i> Use Existing Category';
            categorySelect.disabled = true;
            categorySelect.value = '';
        }
    });

    // Add smooth animations on load
    const containers = document.querySelectorAll('.form-container, .page-header');
    containers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        setTimeout(() => {
            container.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add loading state to submit button
    const submitBtn = document.querySelector('.submit-btn');
    form.addEventListener('submit', function() {
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Template...';
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>