<?php
$title = "Client Proposal Demo";
include('includes/header-new.php');

// Simulated proposal data
$proposal_title = "Website Redesign Proposal";
$proposal_letter = "This is a detailed proposal for redesigning your corporate website to improve user experience and conversion rates.";
$creation_date = "2024-01-01";
$status = "1";
$value = "4500";
$client_name = "Acme Corp";
$employee_name = "John Doe";

$status_message = "Approval status: Waiting for approval";
$status_badge = '<span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>';
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
        max-width: 900px;
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

    /* Content Container */
    .content-container {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    /* Proposal Details */
    .proposal-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-item {
        display: flex;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-dark);
        min-width: 140px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        color: var(--text-light);
        flex: 1;
    }

    .proposal-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    /* Form Styling */
    .form-section {
        background: #f8fafc;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-top: 2rem;
        border: 1px solid #e5e7eb;
    }

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

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Checkbox Styling */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }

    .checkbox-label {
        font-weight: 500;
        color: var(--text-dark);
        cursor: pointer;
        text-transform: none;
        letter-spacing: normal;
    }

    /* Button Styling */
    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        border: 2px solid transparent;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-primary {
        background: var(--bg-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        border-color: #6b7280;
    }

    .btn-secondary:hover {
        background: #4b5563;
        border-color: #4b5563;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    /* Tutorial Styling - Enhanced */
    .introjs-overlay {
        background-color: rgba(0, 0, 0, 0.8) !important;
        z-index: 999999 !important;
    }

    .introjs-tooltip {
        max-width: 400px !important;
        min-width: 300px !important;
        width: 85% !important;
        text-align: left !important;
        border-radius: var(--border-radius) !important;
        box-shadow: var(--shadow-xl) !important;
        background: white !important;
        border: 2px solid var(--primary-color) !important;
        padding: 1.5rem !important;
        z-index: 9999999 !important;
        font-family: 'Inter', sans-serif !important;
    }

    .introjs-tooltip-title {
        color: var(--primary-color) !important;
        font-weight: 700 !important;
        font-size: 1.2rem !important;
        margin-bottom: 0.75rem !important;
        padding-bottom: 0.5rem !important;
        border-bottom: 2px solid #e5e7eb !important;
        line-height: 1.4 !important;
    }

    .introjs-tooltip-text {
        color: var(--text-dark) !important;
        font-size: 1rem !important;
        line-height: 1.6 !important;
        margin-bottom: 1.5rem !important;
        padding: 0.5rem 0 !important;
    }

    .introjs-tooltipbuttons {
        text-align: right !important;
        padding-top: 1rem !important;
        border-top: 1px solid #e5e7eb !important;
        margin-top: 1rem !important;
    }

    .introjs-button {
        background: var(--bg-gradient) !important;
        color: white !important;
        border: none !important;
        border-radius: var(--border-radius) !important;
        padding: 0.75rem 1.5rem !important;
        font-weight: 600 !important;
        margin-left: 0.5rem !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        font-size: 0.9rem !important;
        font-family: 'Inter', sans-serif !important;
    }

    .introjs-button:hover {
        transform: translateY(-1px) !important;
        box-shadow: var(--shadow-md) !important;
        opacity: 0.9 !important;
    }

    .introjs-button:active {
        transform: translateY(0) !important;
    }

    .introjs-skipbutton {
        background: transparent !important;
        color: var(--text-light) !important;
        border: 1px solid #e5e7eb !important;
        border-radius: var(--border-radius) !important;
        padding: 0.75rem 1.5rem !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
        font-size: 0.9rem !important;
        font-family: 'Inter', sans-serif !important;
    }

    .introjs-skipbutton:hover {
        background: var(--bg-secondary) !important;
        color: var(--text-dark) !important;
        border-color: var(--primary-color) !important;
    }

    .introjs-helperNumberLayer {
        background: var(--bg-gradient) !important;
        color: white !important;
        border: 3px solid white !important;
        font-weight: 700 !important;
        font-size: 1.1rem !important;
        width: 35px !important;
        height: 35px !important;
        line-height: 29px !important;
        text-align: center !important;
        box-shadow: var(--shadow-lg) !important;
        z-index: 9999999 !important;
        border-radius: 50% !important;
        font-family: 'Inter', sans-serif !important;
    }

    .introjs-helperLayer {
        border-radius: var(--border-radius) !important;
        border: 3px solid var(--primary-color) !important;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.8) !important;
        z-index: 999998 !important;
    }

    .introjs-arrow {
        border-color: var(--primary-color) !important;
    }

    .introjs-arrow.top {
        border-bottom-color: var(--primary-color) !important;
    }

    .introjs-arrow.bottom {
        border-top-color: var(--primary-color) !important;
    }

    .introjs-arrow.left {
        border-right-color: var(--primary-color) !important;
    }

    .introjs-arrow.right {
        border-left-color: var(--primary-color) !important;
    }

    /* Progress bar styling */
    .introjs-progress {
        background: #e5e7eb !important;
        border-radius: 10px !important;
        height: 8px !important;
        margin-bottom: 1rem !important;
        overflow: hidden !important;
    }

    .introjs-progressbar {
        background: var(--bg-gradient) !important;
        height: 100% !important;
        border-radius: 10px !important;
        transition: width 0.3s ease !important;
    }

    /* Ensure tooltips are always visible */
    .introjs-tooltip-header {
        padding-bottom: 1rem !important;
    }

    .introjs-tooltip-body {
        padding: 0.5rem 0 1rem 0 !important;
    }

    /* Fix for button alignment */
    .introjs-tooltipbuttons .introjs-button {
        display: inline-block !important;
        vertical-align: middle !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .content-container {
            padding: 1.5rem;
        }
        
        .detail-item {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .detail-label {
            min-width: auto;
        }
        
        .action-buttons {
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
            <h1 class="page-title" data-step="1" data-intro="This is the title of the proposal.">
                <i class="fas fa-file-contract"></i>
                <?= htmlspecialchars($proposal_title) ?>
            </h1>
            <p class="page-subtitle">Demo Client Approval Interface</p>
        </div>
    </div>

    <!-- Proposal Details -->
    <div class="content-container">
        <div class="proposal-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Proposal Details
            </h2>
            
            <div class="detail-item" data-step="2" data-intro="Here's the personal letter from the proposer.">
                <div class="detail-label">
                    <i class="fas fa-envelope"></i>
                    Personal Letter:
                </div>
                <div class="detail-value"><?= htmlspecialchars($proposal_letter) ?></div>
            </div>

            <div class="detail-item" data-step="5" data-intro="The total value of the proposal.">
                <div class="detail-label">
                    <i class="fas fa-dollar-sign"></i>
                    Proposal Value:
                </div>
                <div class="detail-value proposal-value">$<?= number_format(floatval($value), 2) ?></div>
            </div>

            <div class="detail-item" data-step="6" data-intro="Information about the client.">
                <div class="detail-label">
                    <i class="fas fa-building"></i>
                    Client:
                </div>
                <div class="detail-value"><?= htmlspecialchars($client_name) ?></div>
            </div>

            <div class="detail-item" data-step="7" data-intro="Information about who created this proposal.">
                <div class="detail-label">
                    <i class="fas fa-user"></i>
                    Created by:
                </div>
                <div class="detail-value"><?= htmlspecialchars($employee_name) ?></div>
            </div>

            <div class="detail-item" data-step="3" data-intro="This is the creation date of the proposal.">
                <div class="detail-label">
                    <i class="fas fa-calendar"></i>
                    Date Created:
                </div>
                <div class="detail-value"><?= date('F j, Y', strtotime($creation_date)) ?></div>
            </div>

            <div class="detail-item" data-step="4" data-intro="Current status of the proposal.">
                <div class="detail-label">
                    <i class="fas fa-flag"></i>
                    Status:
                </div>
                <div class="detail-value"><?= $status_badge ?></div>
            </div>
        </div>

        <!-- Response Form -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-pen"></i>
                Your Response
            </h2>
            
            <form action="client-submit-approval-demo.php" method="POST" class="needs-validation">
                <div class="form-group" data-step="8" data-intro="Please sign here to proceed.">
                    <label for="signature" class="form-label">
                        <i class="fas fa-signature"></i>
                        Digital Signature
                    </label>
                    <input type="text" id="signature" name="signature" class="form-control" 
                           placeholder="Enter your full name as digital signature" required>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="second_sig" name="second_sig" value="yes" class="checkbox-input">
                        <label for="second_sig" class="checkbox-label">This will require another signature</label>
                    </div>
                </div>

                <div class="form-group" data-step="9" data-intro="Add your response to the proposal.">
                    <label for="response" class="form-label">
                        <i class="fas fa-comment"></i>
                        Response
                    </label>
                    <textarea id="response" name="response" class="form-control" rows="4" 
                              placeholder="Add your comments or feedback here..." required></textarea>
                </div>

                <div class="form-group" data-step="10" data-intro="Make your decision on the proposal here.">
                    <label for="decision" class="form-label">
                        <i class="fas fa-gavel"></i>
                        Decision
                    </label>
                    <select id="decision" name="decision" class="form-control" required>
                        <option value="">Select your decision...</option>
                        <option value="2">Approve</option>
                        <option value="0">Deny</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Submit Response
                </button>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="terms-conditions.php" class="btn btn-outline" data-step="11" data-intro="Read the terms and conditions here.">
                <i class="fas fa-file-contract"></i>
                View Terms and Conditions
            </a>
            <a href="client-dashboard.php" class="btn btn-secondary" data-step="12" data-intro="Go back to the dashboard.">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Modern CDN Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/introjs.min.css" rel="stylesheet">

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

    // Enhanced Tutorial functionality
    function startTutorial() {
        introJs().setOptions({
            steps: [
                {
                    element: '[data-step="1"]',
                    intro: "This is the title of the proposal. It provides a clear overview of what's being proposed.",
                    position: 'bottom'
                },
                {
                    element: '[data-step="2"]',
                    intro: "Here's the personal letter from the proposer. This section contains detailed information about the proposal.",
                    position: 'bottom'
                },
                {
                    element: '[data-step="3"]',
                    intro: "This shows when the proposal was created. Important for tracking timelines.",
                    position: 'left'
                },
                {
                    element: '[data-step="4"]',
                    intro: "Current status of the proposal. You can see if it's pending, approved, or needs action.",
                    position: 'left'
                },
                {
                    element: '[data-step="5"]',
                    intro: "The total value of the proposal. This shows the financial commitment involved.",
                    position: 'left'
                },
                {
                    element: '[data-step="6"]',
                    intro: "Information about the client. Shows who the proposal is for.",
                    position: 'left'
                },
                {
                    element: '[data-step="7"]',
                    intro: "Information about who created this proposal. Your point of contact for questions.",
                    position: 'left'
                },
                {
                    element: '[data-step="8"]',
                    intro: "Please sign here to proceed with the proposal. Your digital signature confirms agreement.",
                    position: 'top'
                },
                {
                    element: '[data-step="9"]',
                    intro: "Add your response to the proposal. Share any feedback or questions you might have.",
                    position: 'top'
                },
                {
                    element: '[data-step="10"]',
                    intro: "Make your final decision on the proposal here. You can approve, reject, or request changes.",
                    position: 'top'
                }
            ],
            exitOnOverlayClick: false,
            showButtons: true,
            showBullets: true,
            showProgress: true,
            scrollToElement: true,
            scrollPadding: 30,
            overlayOpacity: 0.8,
            nextLabel: '<i class="fas fa-arrow-right"></i> Next',
            prevLabel: '<i class="fas fa-arrow-left"></i> Back',
            skipLabel: '<i class="fas fa-times"></i> Skip Tour',
            doneLabel: '<i class="fas fa-check"></i> Finish Tutorial',
            hidePrev: false,
            hideNext: false,
            tooltipClass: 'customTooltip',
            highlightClass: 'customHighlight'
        }).onchange(function(targetElement) {
            // Scroll to element with better positioning
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest'
                });
            }
        }).onexit(function() {
            console.log('Tutorial exited');
        }).oncomplete(function() {
            console.log('Tutorial completed');
            // Optional: redirect or show completion message
        }).start();
    }

    // Auto-start tutorial or add button to start
    const queryParams = new URLSearchParams(window.location.search);
    if (queryParams.get('start_tutorial') === 'true') {
        // Small delay to ensure page is fully loaded
        setTimeout(startTutorial, 500);
    }

    // Add tutorial start button if needed
    const tutorialBtn = document.createElement('button');
    tutorialBtn.innerHTML = '<i class="fas fa-question-circle"></i> Start Tutorial';
    tutorialBtn.className = 'btn btn-info tutorial-start-btn';
    tutorialBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        border-radius: 50px;
        padding: 1rem 1.5rem;
        background: var(--bg-gradient);
        border: none;
        color: white;
        font-weight: 600;
        box-shadow: var(--shadow-lg);
        cursor: pointer;
        transition: var(--transition);
    `;
    tutorialBtn.addEventListener('click', startTutorial);
    
    // Only show tutorial button if not auto-starting
    if (queryParams.get('start_tutorial') !== 'true') {
        document.body.appendChild(tutorialBtn);
    }

    // Form validation feedback
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.style.borderColor = 'var(--success-color)';
            } else {
                this.style.borderColor = 'var(--error-color)';
            }
        });

        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--primary-color)';
        });
    });
});
</script>

</body>
</html>