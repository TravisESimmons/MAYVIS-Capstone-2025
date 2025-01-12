<?php


include 'connect.php';
$title = "Proposal Creation";

$currentStep = isset($_GET['step']) ? intval($_GET['step']) : 1;

?>
<?php

include 'includes/header-new.php';
?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>


<body class="bg-dark text-light">

    <div class="container">
        <?php
        if (!isset($_POST['step'])) {
            $step = 1;
        } else {
            $step = $_POST['step'];
        }



        switch ($step) {
            case 1:
                include 'proposal-creation/step1.php';
                break;
            case 2:
                include 'proposal-creation/step2.php';
                break;
            case 3:
                include 'proposal-creation/step3.php';
                break;
            case 4:
                include 'proposal-creation/step4.php';
                break;
            case 5:
                include 'proposal-creation/step5.php';
                break;
            default:
                echo "Invalid step.";
        }
        ?>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>


</html>