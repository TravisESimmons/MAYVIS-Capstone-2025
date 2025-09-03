<?php
$title = "Client Proposal View";
include 'includes/header-new.php';
include 'connect.php';

$proposal_id = $_GET['proposal_id'] ?? null;

if (!$proposal_id || !is_numeric($proposal_id)) {
    header("Location: index.php");
    exit();
}

// Check if the proposal has been viewed and update the 'seen' flag
$stmt_update_seen = $conn->prepare("UPDATE proposals SET seen = 1 WHERE proposal_id = ?");
$stmt_update_seen->bind_param("i", $proposal_id);
$stmt_update_seen->execute();

$proposal_title = $proposal_letter = $creation_date = $status_message = $value = $client_name = $employee_Fname = $employee_Lname = "";
$status_badge = $status = "";

// Fetching the proposal details
$sql = "SELECT p.*, e.employee_first_name, e.employee_last_name, c.client_name
        FROM proposals p
        JOIN employees e ON p.employee_id = e.employee_id
        JOIN clients c ON p.client_id = c.client_id
        WHERE p.proposal_id = '$proposal_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $proposal_title = $row['proposal_title'];
    $proposal_letter = $row['proposal_letter'];
    $creation_date = $row['creation_date'];
    $status = $row['status'];
    $value = $row['value'];
    $client_name = $row['client_name'];
    $employee_Fname = $row['employee_first_name'];
    $employee_Lname = $row['employee_last_name'];

    if ($status == "1") {
        $status_message = "Waiting for approval";
        $status_badge = '<span class="status-badge pending"><i class="fas fa-clock"></i> Pending</span>';
    } elseif ($status == "0") {
        $status_message = "Proposal Denied";
        $status_badge = '<span class="status-badge denied"><i class="fas fa-times-circle"></i> Denied</span>';
    } elseif ($status == "2") {
        $status_message = "Proposal Approved";
        $status_badge = '<span class="status-badge approved"><i class="fas fa-check-circle"></i> Approved</span>';
    }
}

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
}
?>

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-gray: #f8fafc;
    --border-color: #e5e7eb;
    --text-muted: #64748b;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: 'Inter', sans-serif;
    color: var(--dark-color);
}

.proposal-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.proposal-header {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.proposal-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.proposal-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    color: var(--text-muted);
}

.meta-item i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.meta-value {
    font-weight: 600;
    color: var(--dark-color);
    margin-left: 0.25rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid var(--warning-color);
}

.status-badge.approved {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid var(--success-color);
}

.status-badge.denied {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid var(--danger-color);
}

.status-badge i {
    margin-right: 0.5rem;
}

.proposal-content {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
}

.proposal-letter {
    line-height: 1.8;
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.proposal-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--success-color);
    margin: 1rem 0;
}

.deliverables-section {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.deliverable-card {
    background: var(--light-gray);
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.deliverable-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.deliverable-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.deliverable-description {
    color: var(--text-muted);
    margin-bottom: 1rem;
    line-height: 1.6;
}

.deliverable-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
}

.deliverable-price {
    color: var(--success-color);
    font-size: 1.1rem;
}

.deliverable-quantity {
    color: var(--primary-color);
}

.approval-form {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

select.form-control {
    cursor: pointer;
}

.checkbox-group {
    display: flex;
    align-items: center;
    margin-top: 1rem;
}

.checkbox-group input[type="checkbox"] {
    margin-right: 0.5rem;
    transform: scale(1.2);
}

.btn-submit {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-secondary {
    background: var(--light-gray);
    color: var(--dark-color);
    border: 2px solid var(--border-color);
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
}

.btn-secondary:hover {
    background: var(--border-color);
    text-decoration: none;
    color: var(--dark-color);
}

.btn-link {
    color: var(--primary-color);
    text-decoration: none;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
}

.btn-link:hover {
    background: rgba(99, 102, 241, 0.1);
    text-decoration: none;
}

.btn-link i, .btn-secondary i {
    margin-right: 0.5rem;
}

.d-none {
    display: none !important;
}

@media (max-width: 768px) {
    .proposal-container {
        padding: 1rem;
    }
    
    .proposal-meta {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .deliverable-details {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<div class="proposal-container">
    <!-- Proposal Header -->
    <div class="proposal-header">
        <h1 class="proposal-title"><?php echo htmlspecialchars($proposal_title); ?></h1>
        
        <div class="proposal-meta">
            <div class="meta-item">
                <i class="fas fa-user"></i>
                Client: <span class="meta-value"><?php echo htmlspecialchars($client_name); ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-user-tie"></i>
                Created by: <span class="meta-value"><?php echo htmlspecialchars($employee_Fname . ' ' . $employee_Lname); ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-calendar"></i>
                Date: <span class="meta-value"><?php echo htmlspecialchars($creation_date); ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-dollar-sign"></i>
                Value: <span class="meta-value proposal-value">$<?php echo htmlspecialchars(number_format($value, 2)); ?></span>
            </div>
        </div>
        
        <div style="margin-top: 1rem;">
            <?php echo $status_badge; ?>
        </div>
    </div>

    <!-- Proposal Content -->
    <div class="proposal-content">
        <h2 class="section-title">Proposal Letter</h2>
        <div class="proposal-letter">
            <?php echo $proposal_letter; ?>
        </div>
        
        <?php if (!empty($row['client_response'])): ?>
            <h3 class="section-title">Client Response</h3>
            <div class="proposal-letter">
                <?php echo $row['client_response']; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($row['signature'])): ?>
            <h3 class="section-title">Digital Signature</h3>
            <div class="proposal-letter">
                Signed by: <strong><?php echo htmlspecialchars($row['signature']); ?></strong>
            </div>
        <?php endif; ?>
    </div>

    <!-- Deliverables Section -->
    <div class="deliverables-section">
        <h2 class="section-title">Ordered Deliverables</h2>
        
        <?php
        $get_deliverables = "
            SELECT DISTINCT od.deliverable_id, od.quantity, d.price, d.title, d.description
            FROM ordered_deliverables od
            JOIN deliverables d ON od.deliverable_id = d.deliverable_id
            WHERE od.proposal_id = $proposal_id
        ";
        $result = $conn->query($get_deliverables);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $quantity = $row['quantity'];
                $price = $row['price'];
                $title = $row['title'];
                $description = $row['description'];
                ?>
                <div class="deliverable-card">
                    <div class="deliverable-title"><?php echo htmlspecialchars($title); ?></div>
                    <div class="deliverable-description"><?php echo htmlspecialchars($description); ?></div>
                    <div class="deliverable-details">
                        <span class="deliverable-price">$<?php echo number_format($price, 2); ?></span>
                        <span class="deliverable-quantity">Quantity: <?php echo $quantity; ?></span>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No deliverables found for this proposal.</p>";
        }
        ?>
    </div>

    <!-- Approval Forms -->
    <?php
    // Get fresh proposal data for forms
    $sql = "SELECT * FROM proposals WHERE proposal_id = '$proposal_id'";
    $result = mysqli_query($conn, $sql);
    $proposal_data = mysqli_fetch_assoc($result);
    
    $client_response = $proposal_data['client_response'];
    $second_sig = $proposal_data['second_sig'];
    $signature = $proposal_data['signature'];
    $status = $proposal_data['status'];
    
    $hideform = ($status === "0" || $status === "2") ? "d-none" : "";
    ?>

    <?php if ($second_sig === "1"): ?>
        <!-- Second Approval Form -->
        <div class="approval-form">
            <h2 class="section-title">Second Approval Required</h2>
            <form action='second-approval-submit.php?proposal_id=<?php echo $proposal_id; ?>' method='POST' class='needs-validation' novalidate>
                <div class="form-group">
                    <label for="signature" class="form-label">
                        <i class="fas fa-signature"></i> Second Signature
                    </label>
                    <input type="text" id="signature" name="signature" class="form-control" required placeholder="Enter your digital signature">
                    <div class="invalid-feedback">
                        Please provide a digital signature
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="response" class="form-label">
                        <i class="fas fa-comment"></i> Second Response
                    </label>
                    <textarea id="response" name="response" class="form-control" required placeholder="Enter your response..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="decision" class="form-label">
                        <i class="fas fa-gavel"></i> Decision
                    </label>
                    <select id="decision" name="decision" class="form-control" required>
                        <option value="">Select Decision</option>
                        <option value="2">Approve</option>
                        <option value="0">Deny</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check"></i> Submit Second Approval
                </button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Primary Approval Form -->
    <div class="approval-form <?php echo $hideform; ?>">
        <h2 class="section-title">Proposal Response</h2>
        <form action="client-submit-approval.php?proposal_id=<?= $proposal_id ?>" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="step" value="2">

            <div class="form-group">
                <label for="signature" class="form-label">
                    <i class="fas fa-signature"></i> Digital Signature
                </label>
                <input type="text" id="signature" name="signature" class="form-control" required placeholder="Enter your digital signature">
                <div class="invalid-feedback">
                    Please provide a digital signature
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="second_sig" name="second_sig" value="yes">
                    <label for="second_sig">This proposal requires a second signature</label>
                </div>
            </div>

            <div class="form-group">
                <label for="response" class="form-label">
                    <i class="fas fa-comment"></i> Your Response
                </label>
                <textarea id="response" name="response" class="form-control" required placeholder="Enter your response to this proposal..."></textarea>
            </div>

            <div class="form-group">
                <label for="decision" class="form-label">
                    <i class="fas fa-gavel"></i> Decision
                </label>
                <select id="decision" name="decision" class="form-control" required>
                    <option value="">Select Your Decision</option>
                    <option value="2">Approve Proposal</option>
                    <option value="0">Deny Proposal</option>
                </select>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Submit Response
            </button>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="terms-conditions.php" class="btn-link">
            <i class="fas fa-file-contract"></i> View Terms and Conditions
        </a>
        <a href="client-dashboard.php" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

</body>
</html>