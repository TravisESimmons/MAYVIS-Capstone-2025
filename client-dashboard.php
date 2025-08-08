<?php
$title = "Client-Dashboard";
include 'includes/header-new.php';
include 'connect.php';

$hasUnopenedProposals = false;
$userName = "";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the client details associated with the user from the users table
    $sql = "SELECT u.first_name, u.last_name FROM users u WHERE u.user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and if the user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['first_name'] . " " . $row['last_name'];

        // Fetch the client_id associated with the user from the contacts table
        $sql_contact = "SELECT c.client_id FROM contacts c WHERE c.user_id = $user_id";
        $result_contact = mysqli_query($conn, $sql_contact);

        // Check if the query was successful and if the contact exists
        if ($result_contact && mysqli_num_rows($result_contact) > 0) {
            $row_contact = mysqli_fetch_assoc($result_contact);
            $client_id = $row_contact['client_id'];

            // Fetch proposals for the client
            $sql_proposals = "SELECT p.*, CONCAT(e.employee_first_name, ' ', e.employee_last_name) AS creator_name
                              FROM proposals p
                              JOIN employees e ON p.employee_id = e.employee_id
                              WHERE p.client_id = $client_id
                              ORDER BY p.creation_date DESC LIMIT 5";
            $result_proposals = mysqli_query($conn, $sql_proposals);

            // Check if there are any proposals
            if ($result_proposals && mysqli_num_rows($result_proposals) > 0) {
                while ($row_proposal = mysqli_fetch_assoc($result_proposals)) {
                    $recent_proposals[] = $row_proposal;
                    if ($row_proposal['seen'] == 0) {
                        $hasUnopenedProposals = true;
                    }
                }
            }
        }
    }
}

// Set default values if user is not logged in or no proposals found
if (empty($recent_proposals)) {
    $userName = "Guest";
    $recent_proposals = array();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="public/introjs.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css" rel="stylesheet">
</head>

<style>
    .jumbotron {
        background-color: #007bff;
        color: white;
        padding: 2.5rem 14rem;
        margin: 0 auto 3rem;
        max-width: 1400px;
        border-radius: 0.3rem;
    }

    .shadow {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }


    .card.bg-dark.shadow {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        margin-top: 0;
        /* Ensure the title stays at the top */
        padding: 15px 20px 10px;
        /* Add padding around the title */
        position: sticky;
        top: 0;
        z-index: 1;
        background-color: #343a40;
        /* Adjust the background color as needed */
    }




    .btn {
        padding: 10px 20px;
    }

    .fa-question-circle {
        font-size: 1.2rem;
        margin-right: 5px;
    }

    .introjs-tooltip {
        max-width: 900px;
        width: 80%;
        text-align: center;
    }

    body,
    .introjs-skipbutton,
    .introjs-tooltip-title,
    .introjs-button,
    .introjs-helperNumberLayer,
    .introjs-tooltip-body,
    .introjs-helperLayer,
    .introjs-tooltipbuttons {
        color: #000000;
    }

    .introjs-skipbutton {
        position: absolute;
        bottom: 20px;
        right: 40px;
        padding: 10px 20px;
        color: #000000;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        z-index: 9999;
        display: inline-block;
    }


    .introjs-tooltip-body {
        color: #000000;
    }

    .introjs-tooltip {
        color: #000000;
        max-width: 500px;
        /* Set a fixed width for the tooltip */
        width: 80%;
    }


    .introjs-button {
        color: #000000;
        background-color: #ffffff;
        border: 1px solid #000000;
    }

    .introjs-helperNumberLayer {
        color: #000000;
        background-color: #ffffff;
        border: 2px solid #000000;
    }

    .introjs-tooltip-body {
        color: #000000;
    }

    .introjs-helperLayer {
        border-radius: 10px;
    }

    .introjs-tooltipbuttons {
        margin-top: 10px;
    }

    .alert-info {
        background-color: #17a2b8;
        color: #fff;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    body>.content {
        flex: 1 0 auto;
    }


    .col-md-6.pr-md-1 .card {
        height: auto;
    }

    .col-md-6.pr-md-1 .card-body {
        overflow-y: auto;
        max-height: 350px;
    }

    .col-md-6.pr-md-1 .card-body img {
        max-width: 100%;
        height: auto;
        max-height: 200px;
    }

    .card.bg-dark .card-body {
        overflow: hidden;
    }

    .card.bg-dark {
        height: auto;
    }


    .list-group-item.bg-dark {
        border: none;
    }

    .list-group-item.bg-dark.text-light {
        color: #ffffff;
    }

    @media (max-width: 767px) {
        .row {
            flex-direction: column-reverse;
        }

        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    @media (min-width: 768px) {
        .col-md-6.pr-md-1 .card {
            height: 100%;
        }

        .col-md-6.pr-md-1 .card-body {
            overflow-y: auto;
            max-height: 400px;
        }

        .col-md-6.pr-md-1 .card-body img {
            max-width: 100%;
        }

        #proposalHistory {
            order: -1;
            margin-top: 50px;
        }
    }
</style>

<body>
    <div class="jumbotron jumbotron-fluid bg-primary text-white mb-3 shadow">
        <div class="container">
            <h1 class="display-4" data-step="1" data-intro="Welcome to your client dashboard, <?php echo $userName; ?>! Here's a quick tour.">Welcome, <?php echo $userName; ?>!</h1>
        </div>
    </div>


    <div class="container mt-5">
        <?php if ($hasUnopenedProposals) : ?>
            <div class="row justify-content-center mb-3">
                <div class="col-md-12 text-center">
                    <div class="alert alert-info" data-step="2" data-intro="You have a new proposal! Check it out in the My Proposals section.">
                        You have a new proposal!
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- My Proposals and Go to Tutorial buttons row -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-6 pl-md-1">
                <div class="row">
                    <!-- My Proposals Button -->
                    <div class="col-md-6">
                        <a href="client-proposals.php" class="btn btn-primary btn-lg btn-block" data-step="3" data-intro="This is where you can view all your proposals.">My Proposals</a>
                    </div>
                    <!-- Go to Tutorial Button -->
                    <div class="col-md-6">
                        <div class="text-center">
                            <button id="startTutorialBtn" class="btn btn-light btn-lg">
                                <i class="fas fa-question-circle mr-1"></i>
                                Tutorial
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <!-- How Our Service Works Section -->
                <div class="col-md-4 pr-md-1">
                    <div class="card">
                        <div class="card-body text-dark">
                            <h3 class="card-title bg-primary text-white text-center p-3 mb-0">How Our Service Works</h3>
                            <div class="text-center mt-3">
                                <img src="./resources/HIW.jpg" alt="How Our Service Works" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="text-center mt-3">
                                <p>1. Now that you're registered and signed in, you can view and review your proposals through this portal. </p>
                                <p>2. Click the proposal title in Proposal History to view it's details.</p>
                                <p>4. Leave your signature, response, decision - then Submit!</p>
                                <p>4. Check out the What's new section for any updates or changes to the site.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proposal History Section -->
                <div class="col-md-8 pl-md-1" data-step="6" data-intro="Here's your proposal history, where you can track all your past proposals and their statuses." data-position="left">
                    <div class="card bg-dark shadow">
                        <div class="card-body" style=" max-height: 600px;">
                            <h3 class="card-title text-light mb-4" style="padding: 15px 20px 10px;">Proposal History</h3>
                            <ul class="list-group list-group-flush">
                                <?php if (!empty($recent_proposals)) : ?>
                                    <?php foreach ($recent_proposals as $proposal) : ?>
                                        <li class="list-group-item bg-dark text-light">
                                            <div class="proposal-details">
                                                <strong>Proposal:</strong> <a href="client-approval.php?proposal_id=<?php echo $proposal['proposal_id']; ?>"><?php echo htmlspecialchars($proposal['proposal_title']); ?></a><br>
                                                <strong>Cost:</strong> <?php echo htmlspecialchars($proposal['value']); ?><br>
                                                <strong>Creator:</strong> <?php echo htmlspecialchars($proposal['creator_name']); ?><br>
                                                <?php if (isset($proposal['status'])) : ?>
                                                    <span class="badge badge-<?php echo $proposal['status'] == 1 ? 'warning' : ($proposal['status'] == 0 ? 'danger' : 'success'); ?>" title="<?php echo $proposal['status'] == 1 ? 'Pending' : ($proposal['status'] == 0 ? 'Denied' : 'Approved'); ?>">
                                                        <?php echo $proposal['status'] == 1 ? '&#9203;' : ($proposal['status'] == 0 ? '&#10008;' : '&#10004;'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li class="list-group-item bg-dark text-light">No recent proposals found.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <!-- What's New Section -->
                        <div class="col-md-6" data-step="5" data-intro="Check out what's new to stay updated with the latest features and updates." data-position="right">
                            <h3 class="text-center mb-4">What's New</h3>
                            <div class="Whats-new">
                                <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#changeLogModal">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Changes in proposal submission process</h5>
                                        <small>1 week ago</small>
                                    </div>
                                    <p class="mb-1">We’ve changed how users can submit their changes and comments for proposals.</p>
                                </a>
                            </div>
                        </div>


                        <!-- Change Log Modal -->
                        <div class="modal fade" id="changeLogModal" tabindex="-1" role="dialog" aria-labelledby="changeLogModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark text-light">
                                        <h5 class="modal-title" id="changeLogModalLabel">Change Log - Version 1.0</h5>
                                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <p><strong>Version 1.0 (March 2024)</strong></p>
                                        <ul>
                                            <li>Implemented new proposal submission process: Streamlined the process of submitting proposals to improve efficiency.</li>
                                            <li>Added notification for new proposals: Users now receive notifications when new proposals are available for review.</li>
                                            <li>Improved user interface for better user experience: Made enhancements to the user interface to enhance usability and navigation.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- jQuery and Intro.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="public/intro.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var intro = introJs();
        intro.setOptions({
            steps: [{
                    element: '.jumbotron',
                    intro: 'Welcome to MAYVIS! This is your personalized dashboard where you can find your activities and alerts.',
                    position: 'right'
                },
                <?php if ($hasUnopenedProposals) : ?> {
                        element: '.alert-info',
                        intro: 'You have a new proposal! Check it out in the My Proposals section.',
                        position: 'top'
                    },
                <?php endif; ?> {
                    element: '.btn-primary',
                    intro: 'Here you can quickly access all your proposals.',
                    position: 'right'
                },
                {
                    element: '.col-md-4',
                    intro: 'Understand how our service works to fully utilize all features.',
                    position: 'right'
                },
                {
                    element: '.card.bg-dark',
                    intro: 'Review your recent proposal activities here.',
                    position: 'top'
                },
                {
                    element: '.Whats-new',
                    intro: 'Stay updated with the latest features and changes.',
                    position: 'left'
                },

            ],
            exitOnOverlayClick: false,
            showProgress: true,
            showButtons: true,
            nextLabel: 'Next',
            prevLabel: 'Back',
            skipLabel: 'Skip',
            doneLabel: 'Next Page',
            tooltipClass: 'custom-tooltip',
            tooltipPosition: 'auto',
            overlayOpacity: 0.5,
            hidePrev: true,
            hideNext: false,
            hideSkip: false,
            scrollToElement: true
        });

        // Set the function to execute when the intro is completed
        intro.oncomplete(function() {
            window.location.href = 'demo-client-approval.php?start_tutorial=true';
        });

        intro.onexit(function() {
            console.log('Tutorial exited before completion.');
        });

        document.getElementById('startTutorialBtn').addEventListener('click', function() {
            intro.start(); // Start the tutorial when the button is clicked
        });
    });
</script>
<?php include 'includes/footer.php'; ?>

</html>