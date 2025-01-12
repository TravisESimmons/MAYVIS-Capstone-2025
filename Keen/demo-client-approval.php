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
$status_badge = '<span class="badge badge-info">&#10070;</span>';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="public/introjs.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css" rel="stylesheet">
    <style>
        .introjs-tooltip {
            max-width: 400px;
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
    </style>

</head>


<body>
    <div class="container mt-5">
        <h2 data-step="1" data-intro="This is the title of the proposal.">Detailed View of <?= $proposal_title ?></h2>
        <p data-step="2" data-intro="Here's the personal letter from the proposer."><strong>Personal Letter:</strong> <?= $proposal_letter ?></p>
        <p data-step="5" data-intro="The total value of the proposal."><strong>Proposal Value:</strong> $<?= $value ?></p>
        <p data-step="6" data-intro="Information about the client."><strong>Client:</strong> <?= $client_name ?></p>
        <p data-step="7" data-intro="Information about who created this proposal."><strong>Created by:</strong> <?= $employee_name ?></p>
        <p data-step="3" data-intro="This is the creation date of the proposal."><strong>Date Created:</strong> <?= $creation_date ?></p>
        <p data-step="4" data-intro="Current status of the proposal."><?= $status_message ?> <?= $status_badge ?></p>
        <!-- Response Form -->
        <form action="client-submit-approval-demo.php" method="POST" class="needs-validation">
            <div class="form-group" data-step="8" data-intro="Please sign here to proceed.">
                <label for="signature">Signature:</label>
                <input type="text" id="signature" name="signature" class="form-control" required><br><br>
                <label for="second_sig">This will require another signature:</label><br>
                <input type="checkbox" id="second_sig" name="second_sig" value="yes">
            </div>

            <div class="form-group" data-step="9" data-intro="Add your response to the proposal.">
                <label for="response">Response:</label>
                <textarea id="response" name="response" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group" data-step="10" data-intro="Make your decision on the proposal here.">
                <label for="decision">Decision:</label>
                <select id="decision" name="decision" class="form-control" required>
                    <option value="2">Approve</option>
                    <option value="0">Deny</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Terms and Conditions Link -->
        <div class="mt-3" data-step="11" data-intro="Read the terms and conditions here.">
            <a href="terms-conditions.php" class="btn btn-link">View Terms and Conditions</a>
        </div>

        <!-- Back to Dashboard Link -->
        <div class="mt-3" data-step="12" data-intro="Go back to the dashboard.">
            <a href="client-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="public/intro.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function startTutorial() {
                introJs().setOptions({
                    steps: [{
                            element: 'h2',
                            intro: 'This is the title of the proposal.'
                        },
                        {
                            element: '#signature',
                            intro: 'Please sign here to proceed.'
                        },
                        {
                            element: '#second_sig',
                            intro: 'If an additional signature is needed, click the checkbox to reveal the window and add the signature.'
                        },
                        {
                            element: '#response',
                            intro: 'Add your response to the proposal.'
                        },
                        {
                            element: '#decision',
                            intro: 'Make your decision on the proposal here.'
                        },
                        {
                            element: 'a.btn-link',
                            intro: 'Read the terms and conditions here.'
                        },
                        {
                            element: 'a.btn-secondary',
                            intro: 'Go back to the dashboard.'
                        },
                    ],
                    exitOnOverlayClick: false,
                    showButtons: true,
                    nextLabel: 'Next',
                    prevLabel: 'Back',
                    skipLabel: 'Skip',
                    doneLabel: 'Finish Tutorial'
                }).start();
            }

            // Check if the tutorial should start
            var queryParams = new URLSearchParams(window.location.search);
            if (queryParams.get('start_tutorial') === 'true') {
                startTutorial();
            }
        });
    </script>

</body>

</html>