<?php
// [Modernization!] The original landing page was honeslty ugly, this is what I always wanted it to be! Updated home page!! (Feb 23 2025)
$title = "Home";
include 'includes/header-new.php';
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mayvis</title>

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* Custom CSS */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        #carouselExampleControls {
            margin-top: 30px;
        }

        #welcome-section {
            background-color: #343a40;
            color: #ffffff;
            padding: 100px 0;
        }

        .welcome-message {
            padding: 20px;
            border-radius: 10px;
            background-color: #212529;
            margin-top: -50px;
        }

        #key-aspects {
            padding: 50px 0;
            background: linear-gradient(to right, #004080, #001f40);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .aspect-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .aspect {
            flex: 0 0 calc(50% - 20px);
            max-width: calc(50% - 20px);
            margin-bottom: 20px;
            margin-right: 20px;
            background-color: #007bff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .aspect h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .aspect p {
            color: #ffffff;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .welcome-message {
                padding: 20px;
            }

            .welcome-message p {
                margin-bottom: 10px;
            }

            .welcome-message .btn {
                margin-top: 10px;
            }

            .aspect h3 {
                font-size: 17px;
                overflow-wrap: break-word;
            }

            .aspect-container {

                align-items: center;
            }

            .welcome-message {
                width: 100%;
            }

            .aspect {
                width: 90%;
                margin-bottom: 20px;
                margin-right: 10px;
            }
        }
    </style>

</head>

<body>

    <!-- Bootstrap Banner -->
    <div class="container-fluid bg-primary text-white py-3">
        <div class="text-center">
            <h1>Welcome to MAYVIS</h1>
        </div>
    </div>

    <!-- Welcome Message Section -->
    <section id="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="welcome-message">
                        <h2 class="mb-4">Looking to view your proposals?</h2>
                        <p class="mb-0">Login or Sign Up to get started.</p>
                        <a href="login/index.php" class="btn btn-primary mt-3">Sign In / Sign Up</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Carousel -->
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="./resources/Sample1.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="./resources/Sample2.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="./resources/Sample3.jpg" alt="Third slide">
                            </div>
                        </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Aspects -->
    <section id="key-aspects">
        <div class="container">
            <h2 class="text-center mb-4">What we can do for you.</h2>
            <div class="aspect-container">
                <div class="aspect" id="aspect1">
                    <h3>Personalized Proposals</h3>
                    <p>Explore custom-tailored proposals meticulously crafted to suit your unique needs and preferences.</p>
                </div>
                <div class="aspect" id="aspect2">
                    <h3>Interactive Estimates</h3>
                    <p>Experience engaging interactive estimates that present various pricing options and packages to choose from.</p>
                </div>
                <div class="aspect" id="aspect3">
                    <h3>Seamless Collaboration</h3>
                    <p>Collaborate effortlessly with our team, providing real-time feedback and making revisions to ensure your vision is perfectly captured.</p>
                </div>
                <div class="aspect" id="aspect4">
                    <h3>Enhanced Security</h3>
                    <p>Rest assured with our robust security measures, offering secure access controls and encrypted communication channels to safeguard your data.</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<?php include 'includes/footer.php'; ?>

</html>