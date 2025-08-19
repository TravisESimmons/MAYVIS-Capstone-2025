<?php
$title = "Contact Us";
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
        padding: 3rem 2rem;
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
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
    }

    /* Contact Content */
    .contact-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .contact-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: var(--primary-color);
        font-size: 1.75rem;
    }

    /* Contact Info */
    .contact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .contact-details h4 {
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 0.25rem 0;
    }

    .contact-details p {
        color: var(--text-light);
        margin: 0;
    }

    /* Contact Form */
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
        min-height: 120px;
        resize: vertical;
    }

    .submit-btn {
        background: var(--bg-gradient);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        justify-content: center;
        width: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Office Hours */
    .hours-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        margin-bottom: 3rem;
    }

    .hours-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .hours-item {
        text-align: center;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .hours-item:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .hours-item h4 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hours-item p {
        color: var(--text-light);
        margin: 0;
    }

    /* Map Section */
    .map-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
        text-align: center;
    }

    .map-placeholder {
        background: var(--bg-secondary);
        border: 2px dashed #d1d5db;
        border-radius: var(--border-radius);
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
        color: var(--text-light);
    }

    .map-placeholder i {
        font-size: 3rem;
        color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .contact-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .contact-card {
            padding: 2rem;
        }
        
        .hours-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Contact Keen Creative</h1>
            <p class="hero-subtitle">We'd love to hear from you. Get in touch with our team!</p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="contact-content">
        <!-- Contact Information -->
        <div class="contact-card">
            <h2 class="card-title">
                <i class="fas fa-address-book"></i>
                Contact Information
            </h2>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-details">
                    <h4>Address</h4>
                    <p>Edmonton, AB, Canada<br>T6G 2R3</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-details">
                    <h4>Phone</h4>
                    <p>(555) 123-4567</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-details">
                    <h4>Email</h4>
                    <p>hello@keencreative.com</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="contact-details">
                    <h4>Website</h4>
                    <p>www.keencreative.com</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-card">
            <h2 class="card-title">
                <i class="fas fa-paper-plane"></i>
                Send us a Message
            </h2>
            
            <form id="contactForm" action="#" method="POST">
                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Your full name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="company">
                        <i class="fas fa-building"></i>
                        Company (Optional)
                    </label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Your company name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="subject">
                        <i class="fas fa-tag"></i>
                        Subject
                    </label>
                    <input type="text" class="form-control" id="subject" name="subject" required placeholder="What's this about?">
                </div>

                <div class="form-group">
                    <label class="form-label" for="message">
                        <i class="fas fa-comment"></i>
                        Message
                    </label>
                    <textarea class="form-control" id="message" name="message" required placeholder="Tell us more about your project or inquiry..."></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Office Hours -->
    <div class="hours-section">
        <h2 class="card-title" style="text-align: center; margin-bottom: 2rem;">
            <i class="fas fa-clock"></i>
            Office Hours
        </h2>
        
        <div class="hours-grid">
            <div class="hours-item">
                <h4>Monday - Friday</h4>
                <p>9:00 AM - 6:00 PM</p>
            </div>
            <div class="hours-item">
                <h4>Saturday</h4>
                <p>10:00 AM - 4:00 PM</p>
            </div>
            <div class="hours-item">
                <h4>Sunday</h4>
                <p>Closed</p>
            </div>
            <div class="hours-item">
                <h4>Emergency Support</h4>
                <p>Available 24/7</p>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <h2 class="card-title" style="text-align: center; margin-bottom: 2rem;">
            <i class="fas fa-map"></i>
            Find Us
        </h2>
        
        <div class="map-placeholder">
            <i class="fas fa-map-marked-alt"></i>
            <h3>Interactive Map Coming Soon</h3>
            <p>Located in the heart of Edmonton, Alberta</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form handling
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple form validation
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();
        
        if (!name || !email || !subject || !message) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Simulate form submission
        const submitBtn = document.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            alert('Thank you for your message! We\'ll get back to you soon.');
            form.reset();
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

    // Add smooth animations on load
    const sections = document.querySelectorAll('.hero-section, .contact-card, .hours-section, .map-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        setTimeout(() => {
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
