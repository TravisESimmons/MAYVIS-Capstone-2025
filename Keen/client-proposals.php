<?php
$title = "Client-Proposals";
include 'includes/header-new.php';
include 'connect.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

function getClientID($user_id, $conn)
{
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT client_id FROM contacts WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['client_id'];
    } else {
        return null;
    }
}

function getProposals($client_id, $conn)
{
    $client_id = mysqli_real_escape_string($conn, $client_id);
    $sql = "SELECT p.*, CONCAT(e.employee_first_name, ' ', e.employee_last_name) AS employee_creator
            FROM proposals p
            JOIN employees e ON p.employee_id = e.employee_id
            WHERE p.client_id = '$client_id'";
    $result = mysqli_query($conn, $sql);
    $proposals = array();
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $proposals[] = $row;
        }
    }
    return $proposals;
}

if ($user_id !== null) {
    $client_id = getClientID($user_id, $conn);
    $proposals = $client_id !== null ? getProposals($client_id, $conn) : array();
} else {
    echo "<script>alert('You are not logged in.'); window.location.href = 'login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Proposals</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<style>
    .clickable-card {
        transition: transform 0.3s ease;

    }

    .clickable-card:hover {
        cursor: pointer;
        transform: scale(1.03);
    }

    html,
    body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    body>.container {
        flex-grow: 1;
    }

    .footer {
        width: 100%;
        background-color: #343a40;
        color: white;
        text-align: center;
        padding: 10px 0;
        margin-top: auto;
    }
</style>



<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-3 text-primary">My Proposals</h2>
        <div class="row">
            <?php if (!empty($proposals)) : ?>
                <?php foreach ($proposals as $proposal) : ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm clickable-card" onclick="location.href='client-approval.php?proposal_id=<?= $proposal['proposal_id']; ?>'">
                            <div class="card-body">
                                <h5 class="card-title text-dark font-weight-bold"><?= htmlspecialchars($proposal['proposal_title']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($proposal['employee_creator']); ?></h6>
                                <p class="card-text small text-dark"><?= htmlspecialchars(strip_tags(substr($proposal['proposal_letter'], 0, 100))); ?>...</p>
                            </div>
                            <div class="card-footer bg-white">
                                <small class="text-muted">Date Created: <?= htmlspecialchars($proposal['creation_date']); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <p>No proposals found.</p>
                </div>
            <?php endif; ?>
        </div>
        <a href="client-dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>