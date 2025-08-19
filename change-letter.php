<?php
$title = "Edit Proposal Letter";
$proposal_id = $_GET['proposal_id'];

include 'includes/header-new.php';
include 'connect.php';

$sql = "SELECT * FROM proposals WHERE proposal_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $proposal_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $proposal_letter = $row['proposal_letter'];
    $proposal_title = $row['proposal_title'];
} else {
    $proposal_letter = "";
    $proposal_title = "Proposal";
}
?>

<style>
    :root {
        --primary-color: #6366f1;
        --secondary-color: #8b5cf6;
        --bg-gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        --bg-secondary: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-radius: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: var(--bg-secondary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text-dark);
    }

    .main-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .page-header {
        background: var(--bg-gradient);
        color: white;
        padding: 3rem 2rem;
        border-radius: var(--border-radius);
        text-align: center;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-subtitle {
        font-size: 1.1rem;
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    .current-letter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 2px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .current-letter-content {
        background: var(--bg-secondary);
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: var(--text-dark);
        max-height: 300px;
        overflow-y: auto;
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 2px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .editor-wrapper {
        border: 2px solid #e5e7eb;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        background: white;
        min-height: 250px;
        box-shadow: var(--shadow-sm);
    }

    .editor-wrapper:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-md);
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
        min-height: 200px;
        font-family: inherit;
    }

    .ql-editor {
        min-height: 200px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: var(--text-dark);
    }

    .ql-editor.ql-blank::before {
        color: var(--text-muted);
        font-style: italic;
        left: 1.5rem;
        right: 1.5rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }

    .action-btn-primary {
        background: var(--bg-gradient);
        color: white;
        border: 2px solid transparent;
    }

    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    .action-btn-secondary {
        background: transparent;
        color: var(--text-muted);
        border: 2px solid #e5e7eb;
    }

    .action-btn-secondary:hover {
        background: var(--bg-secondary);
        color: var(--text-dark);
        border-color: var(--primary-color);
        transform: translateY(-1px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
            margin: 1rem auto;
        }

        .page-header {
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .current-letter-section,
        .form-container {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .action-btn {
            justify-content: center;
        }
    }
</style>

<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-edit"></i>
            Edit Proposal Letter
        </h1>
        <p class="page-subtitle">Modify the proposal letter content for: <?= htmlspecialchars($proposal_title) ?></p>
    </div>

    <!-- Current Letter Display -->
    <div class="current-letter-section">
        <h2 class="section-title">
            <i class="fas fa-file-alt"></i>
            Current Letter Content
        </h2>
        <div class="current-letter-content">
            <?= !empty($proposal_letter) ? nl2br(htmlspecialchars($proposal_letter)) : '<em>No letter content available</em>' ?>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="form-container">
        <form action="change-letter-submit.php?proposal_id=<?= $proposal_id ?>" method="POST" id="letterForm">
            <div class="form-group">
                <label class="form-label" for="personalLetter">
                    <i class="fas fa-pen-fancy"></i>
                    New Letter Content
                </label>
                <div class="editor-wrapper" id="editorWrapper">
                    <div id="editor-container"></div>
                </div>
                <textarea id="personalLetter" name="personalLetter" style="display: none;"><?= htmlspecialchars($proposal_letter) ?></textarea>
            </div>

            <div class="button-group">
                <a href="proposal-details.php?proposal_id=<?= $proposal_id ?>" class="action-btn action-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Proposal
                </a>
                <button type="submit" class="action-btn action-btn-primary">
                    <i class="fas fa-save"></i>
                    Update Letter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quill Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Write your proposal letter content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // Set initial content
    const currentContent = document.getElementById('personalLetter').value;
    if (currentContent) {
        quill.root.innerHTML = currentContent;
    }

    // Add focus styling
    const editorWrapper = document.getElementById('editorWrapper');
    quill.on('selection-change', function(range) {
        if (range) {
            editorWrapper.classList.add('focused');
        } else {
            editorWrapper.classList.remove('focused');
        }
    });

    // Update hidden textarea on form submission
    const form = document.getElementById('letterForm');
    form.addEventListener('submit', function() {
        const content = quill.root.innerHTML;
        document.getElementById('personalLetter').value = content;
        
        // Basic validation
        if (quill.getText().trim().length === 0) {
            alert('Please enter some content for the proposal letter.');
            return false;
        }
    });

    // Add smooth animations
    const containers = document.querySelectorAll('.current-letter-section, .form-container');
    containers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            container.style.transition = 'all 0.6s ease-out';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>

<?php include 'includes/footer.php'; ?>