<?php
$title = "Home";
include 'includes/header-new.php';
include('connect.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mayvis - Modern Proposal Management</title>

    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-secondary);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero-section {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%239C92AC" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.25rem);
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .cta-button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 16px 32px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-transform: none;
        }

        .cta-button:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .hero-carousel {
            position: relative;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
        }

        .carousel-item img {
            height: 400px;
            object-fit: cover;
            width: 100%;
        }

        /* Features Section */
        .features-section {
            padding: 120px 0;
            background: var(--bg-primary);
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2rem, 4vw, 2.5rem);
            font-weight: 700;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--bg-gradient);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: var(--bg-gradient);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 1.5rem;
        }

        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            background: var(--bg-gradient);
            padding: 80px 0;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        /* How It Works Section */
        .how-it-works-section {
            padding: 100px 0;
            background: var(--bg-secondary);
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .process-step {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius-lg);
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .process-step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--bg-gradient);
        }

        .process-step:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .step-number {
            position: absolute;
            top: -15px;
            right: 20px;
            background: var(--bg-gradient);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: var(--shadow-md);
        }

        .step-icon {
            background: rgba(99, 102, 241, 0.1);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--primary-color);
            font-size: 2rem;
            transition: var(--transition);
        }

        .process-step:hover .step-icon {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .step-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .step-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .step-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            border: 2px solid var(--primary-color);
        }

        .step-cta:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .cta-section {
            text-align: center;
            background: white;
            padding: 3rem;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            margin-top: 3rem;
        }

        .cta-section h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .cta-section p {
            color: var(--text-light);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .cta-button.secondary {
            background: var(--bg-secondary);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .cta-button.secondary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                min-height: auto;
                padding: 80px 0;
            }
            
            .features-section {
                padding: 80px 0;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Business Model Notification */
        .business-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-xl);
            max-width: 600px;
            display: none;
            animation: slideDown 0.5s ease-out;
        }

        .business-notification.show {
            display: block;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .notification-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .notification-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .notification-body {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .notification-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .notification-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notification-btn-primary {
            background: white;
            color: var(--primary-color);
        }

        .notification-btn-primary:hover {
            background: #f8fafc;
            color: var(--primary-dark);
            text-decoration: none;
        }

        .notification-btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .notification-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Business Model Notification -->
    <?php if (isset($_GET['info']) && $_GET['info'] === 'account-creation-info'): ?>
    <div class="business-notification show" id="businessNotification">
        <div class="notification-header">
            <h4 class="notification-title">
                <i class="fas fa-info-circle me-2"></i>
                How MAYVIS Account Creation Works
            </h4>
            <button class="notification-close" onclick="closeNotification()">×</button>
        </div>
        <div class="notification-body">
            <p><strong>MAYVIS operates on a professional service model:</strong></p>
            <p>📧 <strong>Step 1:</strong> Contact our team to discuss your project needs<br>
            👤 <strong>Step 2:</strong> We create a secure account for you<br>
            📋 <strong>Step 3:</strong> Access your personalized proposals and dashboard</p>
            <p>This ensures quality service, security, and proper account management for all our clients.</p>
        </div>
        <div class="notification-actions">
            <a href="mailto:info@mayvis.ca" class="notification-btn notification-btn-primary">
                <i class="fas fa-envelope"></i>
                Contact Our Team
            </a>
            <a href="/mayvis/login/index.php" class="notification-btn notification-btn-secondary">
                <i class="fas fa-sign-in-alt"></i>
                Already Have Account?
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Transform Your Business with Smart Proposals</h1>
                        <p class="hero-subtitle">Create stunning, interactive proposals that convert prospects into clients. Streamline your workflow with our modern proposal management platform.</p>
                        <a href="login/index.php" class="cta-button">
                            <i class="fas fa-rocket"></i>
                            Get Started Today
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-carousel">
                        <div id="modernCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#modernCarousel" data-bs-slide-to="2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="./resources/Sample1.jpg" class="d-block w-100" alt="Modern Proposals">
                                </div>
                                <div class="carousel-item">
                                    <img src="./resources/Sample2.jpg" class="d-block w-100" alt="Interactive Features">
                                </div>
                                <div class="carousel-item">
                                    <img src="./resources/Sample3.jpg" class="d-block w-100" alt="Team Collaboration">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#modernCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modernCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Proposals Created</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Everything You Need to Win More Business</h2>
            <p class="section-subtitle">Powerful features designed to streamline your proposal process and help you close deals faster.</p>
            
            <div class="feature-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <h3 class="feature-title">Smart Personalization</h3>
                    <p class="feature-description">Create custom-tailored proposals that speak directly to your client's needs with our intelligent personalization engine.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Interactive Estimates</h3>
                    <p class="feature-description">Engage clients with dynamic pricing options and interactive elements that make your proposals stand out from the competition.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Seamless Collaboration</h3>
                    <p class="feature-description">Work together effortlessly with real-time collaboration tools, feedback systems, and version control for perfect teamwork.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Enterprise Security</h3>
                    <p class="feature-description">Protect your sensitive data with bank-level security, encrypted communications, and advanced access controls.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="feature-title">Lightning Fast</h3>
                    <p class="feature-description">Create professional proposals in minutes, not hours. Our streamlined workflow gets you from concept to client-ready in record time.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mobile Optimized</h3>
                    <p class="feature-description">Access and manage your proposals anywhere, anytime. Our responsive design works perfectly on all devices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">How Mayvis Works</h2>
            <p class="section-subtitle">Our streamlined process makes it easy to get professional proposals</p>
            
            <div class="process-steps">
                <div class="process-step animate-on-scroll">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="step-title">Contact Us</h3>
                    <p class="step-description">Reach out to discuss your project needs. Our team will understand your requirements and goals.</p>
                    <a href="mailto:info@mayvis.ca" class="step-cta">Get In Touch</a>
                </div>
                
                <div class="process-step animate-on-scroll">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="step-title">We Create Your Account</h3>
                    <p class="step-description">Our experts create a secure account for you and develop a customized proposal based on your needs.</p>
                </div>
                
                <div class="process-step animate-on-scroll">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3 class="step-title">Review & Approve</h3>
                    <p class="step-description">Sign in to your account to review your personalized proposal and provide feedback or approval.</p>
                </div>
                
                <div class="process-step animate-on-scroll">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="step-title">Let's Get Started</h3>
                    <p class="step-description">Once approved, we begin working together to bring your project to life with ongoing support.</p>
                </div>
            </div>
            
            <div class="cta-section">
                <h3>Already have an account?</h3>
                <p>Sign in to access your proposals and project dashboard</p>
                <a href="/mayvis/login/index.php" class="cta-button secondary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In to Your Account
                </a>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scrolling and animation effects
        document.addEventListener('DOMContentLoaded', function() {
            // Page loading animation
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s ease';
                document.body.style.opacity = '1';
            }, 100);

            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-on-scroll');
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Prepare elements for animation
            document.querySelectorAll('.feature-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = `all 0.6s ease ${index * 0.1}s`;
                observer.observe(card);
            });

            // Animate stats on scroll
            document.querySelectorAll('.stat-number').forEach((stat, index) => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(20px)';
                stat.style.transition = `all 0.5s ease ${index * 0.1}s`;
                observer.observe(stat);
            });

            // Animate process steps
            document.querySelectorAll('.process-step').forEach((step, index) => {
                step.style.opacity = '0';
                step.style.transform = 'translateY(30px)';
                step.style.transition = `all 0.6s ease ${index * 0.15}s`;
                observer.observe(step);
            });

            // Add parallax effect to hero section (subtle)
            let ticking = false;
            function updateParallax() {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('.hero-section');
                if (hero && scrolled < window.innerHeight) {
                    hero.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);

            // Add smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add hover effects to feature cards
            document.querySelectorAll('.feature-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-12px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(-8px) scale(1)';
                });
            });

            // Counter animation for stats
            function animateCounter(element, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const current = Math.floor(progress * (end - start) + start);
                    element.textContent = current + (element.dataset.suffix || '');
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Trigger counter animation when stats come into view
            const statsObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const statNumber = entry.target;
                        const finalValue = parseInt(statNumber.textContent.replace(/\D/g, ''));
                        const suffix = statNumber.textContent.replace(/\d/g, '');
                        statNumber.dataset.suffix = suffix;
                        animateCounter(statNumber, 0, finalValue, 2000);
                        statsObserver.unobserve(statNumber);
                    }
                });
            });

            document.querySelectorAll('.stat-number').forEach(stat => {
                statsObserver.observe(stat);
            });
        });

        // Add performance optimization for scrolling
        let scrollTimer = null;
        window.addEventListener('scroll', function() {
            if (scrollTimer !== null) {
                clearTimeout(scrollTimer);
            }
            scrollTimer = setTimeout(function() {
                // Scroll ended
            }, 150);
        }, { passive: true });

        // Business notification functionality
        function closeNotification() {
            const notification = document.getElementById('businessNotification');
            notification.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => {
                notification.style.display = 'none';
                // Clean up URL
                const url = new URL(window.location);
                url.searchParams.delete('info');
                window.history.replaceState({}, '', url.toString());
            }, 300);
        }

        // Auto-close notification after 10 seconds
        setTimeout(() => {
            const notification = document.getElementById('businessNotification');
            if (notification && notification.style.display !== 'none') {
                closeNotification();
            }
        }, 10000);

        // Add slideUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                from {
                    opacity: 1;
                    transform: translateX(-50%) translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

<?php include 'includes/footer.php'; ?>

</html>