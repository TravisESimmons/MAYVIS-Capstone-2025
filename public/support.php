<?php
$title = "Support";
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
        margin-bottom: 0;
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

    /* Support Grid */
    .support-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .support-card {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        text-align: center;
        transition: var(--transition);
        border: 1px solid #e5e7eb;
        height: fit-content;
    }

    .support-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .support-icon {
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

    .support-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .support-description {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .support-action {
        background: var(--primary-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .support-action:hover {
        background: var(--primary-dark);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* FAQ Section */
    .faq-item {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .faq-question {
        padding: 1.5rem;
        cursor: pointer;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
        background: white;
    }

    .faq-question:hover {
        background: var(--bg-secondary);
        color: var(--primary-color);
    }

    .faq-answer {
        padding: 0 1.5rem 1.5rem;
        color: var(--text-light);
        line-height: 1.6;
        display: none;
        background: var(--bg-secondary);
    }

    .faq-answer.active {
        display: block;
    }

    .faq-icon {
        transition: var(--transition);
    }

    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }

    /* Contact Form */
    .contact-form {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 2rem;
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
        
        .support-grid {
            grid-template-columns: 1fr;
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
            <h1 class="hero-title">Support Center</h1>
            <p class="hero-subtitle">
                Get the help you need with MAYVIS. We're here to support your success.
            </p>
        </div>
    </div>

    <!-- Support Options -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-life-ring"></i>
            How Can We Help?
        </h2>
        <div class="support-grid">
            <div class="support-card">
                <div class="support-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="support-title">Email Support</h3>
                <p class="support-description">
                    Get personalized help via email. We typically respond within 24 hours during business days.
                </p>
                <a href="mailto:support@keencreative.com" class="support-action">
                    <i class="fas fa-paper-plane"></i>
                    Send Email
                </a>
            </div>
            
            <div class="support-card">
                <div class="support-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="support-title">User Guide</h3>
                <p class="support-description">
                    Access our comprehensive user manual with step-by-step instructions and tutorials.
                </p>
                <a href="/mayvis/Mayvis User Manual ver.1.0 1.docx" class="support-action">
                    <i class="fas fa-download"></i>
                    Download Guide
                </a>
            </div>
            
            <div class="support-card">
                <div class="support-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <h3 class="support-title">Interactive Tutorial</h3>
                <p class="support-description">
                    Take a guided tour of MAYVIS features with our interactive tutorial system.
                </p>
                <a href="/mayvis/client-dashboard.php#tutorial" class="support-action">
                    <i class="fas fa-magic"></i>
                    Start Tutorial
                </a>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-question-circle"></i>
            Frequently Asked Questions
        </h2>
        
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How do I create my first proposal?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>Creating a proposal is easy! Navigate to the "Proposals" section from your dashboard, click "Create New Proposal", and follow the step-by-step wizard. You can select from pre-built templates or create a custom proposal from scratch.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>How do clients approve proposals?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>Clients receive an email notification with a secure link to review their proposal. They can view all details, leave comments, and either approve or request changes directly through the client portal - no account creation required.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Can I customize proposal templates?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>Absolutely! You can create custom templates, modify existing ones, and set up your own deliverable categories. All templates are fully customizable to match your brand and service offerings.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Is my data secure with MAYVIS?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>Yes! We use industry-standard encryption, secure hosting, and regular backups to protect your data. All client interactions are secured with SSL encryption, and we follow best practices for data privacy and security.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>Can I track proposal performance?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>Yes! MAYVIS provides detailed analytics on proposal views, response times, approval rates, and more. You can track which templates perform best and optimize your proposal strategy accordingly.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question" onclick="toggleFAQ(this)">
                <span>What happens if I forget my password?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>No problem! Use the "Forgot Password" link on the login page. You'll receive an email with instructions to reset your password securely. The reset link expires after 24 hours for security.</p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-comment-dots"></i>
            Contact Support
        </h2>
        <p class="section-content mb-4">
            Can't find what you're looking for? Send us a message and we'll get back to you as soon as possible.
        </p>
        
        <div class="contact-form">
            <form action="#" method="POST">
                <div class="form-group">
                    <label class="form-label" for="support_name">Your Name</label>
                    <input type="text" class="form-control" id="support_name" name="support_name" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="support_email">Email Address</label>
                    <input type="email" class="form-control" id="support_email" name="support_email" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="support_subject">Subject</label>
                    <select class="form-control" id="support_subject" name="support_subject" required>
                        <option value="">Select a topic</option>
                        <option value="technical">Technical Issue</option>
                        <option value="billing">Billing Question</option>
                        <option value="feature">Feature Request</option>
                        <option value="general">General Inquiry</option>
                        <option value="bug">Bug Report</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="support_message">Message</label>
                    <textarea class="form-control" id="support_message" name="support_message" 
                              placeholder="Please describe your issue or question in detail..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Additional Resources -->
    <div class="content-section">
        <h2 class="section-title">
            <i class="fas fa-external-link-alt"></i>
            Additional Resources
        </h2>
        <div class="section-content">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h4 class="text-dark mb-2">
                        <i class="fas fa-video text-primary me-2"></i>
                        Video Tutorials
                    </h4>
                    <p>Watch our collection of video tutorials covering all major features and workflows.</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h4 class="text-dark mb-2">
                        <i class="fas fa-users text-primary me-2"></i>
                        Community Forum
                    </h4>
                    <p>Connect with other MAYVIS users, share tips, and get advice from the community.</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h4 class="text-dark mb-2">
                        <i class="fas fa-bullhorn text-primary me-2"></i>
                        What's New
                    </h4>
                    <p>Stay updated with the latest features, improvements, and announcements.</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h4 class="text-dark mb-2">
                        <i class="fas fa-phone text-primary me-2"></i>
                        Contact Information
                    </h4>
                    <p>
                        <strong>Email:</strong> support@keencreative.com<br>
                        <strong>Phone:</strong> (555) 123-4567<br>
                        <strong>Hours:</strong> Mon-Fri, 9 AM - 5 PM MST
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const answer = element.nextElementSibling;
    const isActive = faqItem.classList.contains('active');
    
    // Close all other FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
        item.querySelector('.faq-answer').classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        faqItem.classList.add('active');
        answer.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations on load
    const sections = document.querySelectorAll('.content-section, .hero-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        setTimeout(() => {
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Form submission handling
    const form = document.querySelector('.contact-form form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Thank you for your message! We\'ll get back to you within 24 hours.');
        form.reset();
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
