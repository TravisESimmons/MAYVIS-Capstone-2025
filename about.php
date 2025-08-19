<?php
$title = "About Us";
include 'includes/header-new.php';
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Hero Section */
    .hero-section {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 4rem 2rem;
        margin-bottom: 3rem;
        box-shadow: var(--shadow-xl);
        color: white;
        text-align: center;
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
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Content Sections */
    .content-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 3rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-title i {
        color: var(--primary-color);
        font-size: 2.5rem;
    }

    .section-content {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 1.1rem;
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .feature-card {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        transition: var(--transition);
        border: 1px solid #e5e7eb;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: var(--bg-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .feature-description {
        color: var(--text-light);
        line-height: 1.6;
    }

    /* Team Section */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .team-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .team-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .team-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        background: var(--bg-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }

    .team-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .team-role {
        color: var(--primary-color);
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .team-description {
        color: var(--text-light);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .stat-card {
        text-align: center;
        padding: 1.5rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-light);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.9rem;
    }

    /* CTA Section */
    .cta-section {
        background: var(--bg-gradient);
        border-radius: var(--border-radius-lg);
        padding: 3rem;
        text-align: center;
        color: white;
        margin-top: 3rem;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-cta {
        background: white;
        color: var(--primary-color);
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        font-size: 1.1rem;
    }

    .btn-cta:hover {
        color: var(--primary-color);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .content-section {
            padding: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">About MAYVIS</h1>
            <p class="hero-subtitle">
                Revolutionizing proposal management for creative agencies and businesses worldwide
            </p>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-bullseye"></i>
            Our Mission
        </h2>
        <div class="section-content">
            <p class="mb-4">
                At MAYVIS, we believe that creating professional proposals shouldn't be a time-consuming, repetitive task. 
                Our mission is to empower creative agencies, freelancers, and businesses with intelligent tools that 
                streamline the proposal process from creation to approval.
            </p>
            <p>
                We're dedicated to helping you focus on what matters most – delivering exceptional creative work – 
                while we handle the administrative complexity of proposal management.
            </p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-star"></i>
            What Makes Us Different
        </h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-magic"></i>
                </div>
                <h3 class="feature-title">Smart Templates</h3>
                <p class="feature-description">
                    Pre-built, customizable templates that adapt to your brand and project requirements.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Client Collaboration</h3>
                <p class="feature-description">
                    Seamless client approval workflows with real-time notifications and feedback loops.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Analytics & Insights</h3>
                <p class="feature-description">
                    Track proposal performance, approval rates, and optimize your business processes.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Enterprise Security</h3>
                <p class="feature-description">
                    Bank-level security with encrypted data storage and secure client access controls.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-trophy"></i>
            By The Numbers
        </h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Proposals Created</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">95%</div>
                <div class="stat-label">Approval Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50%</div>
                <div class="stat-label">Time Saved</div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-heart"></i>
            Meet the Team
        </h2>
        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3 class="team-name">Keen Creative Team</h3>
                <p class="team-role">Founders & Developers</p>
                <p class="team-description">
                    A passionate team of designers and developers from Edmonton, dedicated to creating 
                    innovative solutions for the creative industry.
                </p>
            </div>
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="team-name">Innovation Lab</h3>
                <p class="team-role">Product Development</p>
                <p class="team-description">
                    Our research and development team continuously works on new features and 
                    improvements based on user feedback and industry trends.
                </p>
            </div>
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="team-name">Support Heroes</h3>
                <p class="team-role">Customer Success</p>
                <p class="team-description">
                    Dedicated support specialists ensuring every user has a seamless experience 
                    with our platform and achieves their goals.
                </p>
            </div>
        </div>
    </div>

    <!-- Vision Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-rocket"></i>
            Our Vision
        </h2>
        <div class="section-content">
            <p class="mb-4">
                We envision a future where proposal creation is effortless, where creative professionals 
                can focus entirely on their craft, and where client relationships are strengthened through 
                transparent, efficient communication.
            </p>
            <p>
                MAYVIS is more than just software – it's a platform that transforms how creative businesses 
                operate, helping them grow, scale, and succeed in an increasingly competitive market.
            </p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <h2 class="cta-title">Ready to Transform Your Workflow?</h2>
        <p class="cta-description">
            Join hundreds of creative professionals who have already revolutionized their proposal process with MAYVIS.
        </p>
        <a href="mailto:info@mayvis.ca" class="btn-cta">
            <i class="fas fa-envelope"></i>
            Contact Our Team
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const sections = document.querySelectorAll('.content-section, .hero-section, .cta-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        setTimeout(() => {
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Add hover effects to feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animate stats on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const finalValue = parseInt(stat.textContent);
                    let currentValue = 0;
                    const increment = finalValue / 50;
                    
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            stat.textContent = stat.textContent; // Keep original formatting
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(currentValue) + (stat.textContent.includes('%') ? '%' : stat.textContent.includes('+') ? '+' : '');
                        }
                    }, 30);
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsSection = document.querySelector('.stats-grid');
    if (statsSection) {
        statsObserver.observe(statsSection.parentElement);
    }
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
