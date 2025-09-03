<?php
$title = "Privacy Policy";
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
        max-width: 900px;
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
        margin-bottom: 0.5rem;
    }

    .last-updated {
        font-size: 0.95rem;
        opacity: 0.8;
        font-style: italic;
    }

    /* Content Section */
    .content-section {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 3rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .subsection-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 2rem 0 1rem 0;
    }

    .policy-content {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 1rem;
    }

    .policy-content p {
        margin-bottom: 1.5rem;
    }

    .policy-content ul {
        margin: 1rem 0 1.5rem 2rem;
    }

    .policy-content li {
        margin-bottom: 0.5rem;
    }

    .policy-content strong {
        color: var(--text-dark);
    }

    .highlight-box {
        background: var(--bg-secondary);
        border-left: 4px solid var(--primary-color);
        padding: 1.5rem;
        margin: 2rem 0;
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
    }

    .highlight-box h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .contact-info {
        background: var(--bg-gradient);
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-top: 2rem;
        text-align: center;
    }

    .contact-info h4 {
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .contact-info a {
        color: white;
        text-decoration: underline;
    }

    .contact-info a:hover {
        color: white;
        opacity: 0.8;
    }

    /* Table of Contents */
    .toc {
        background: var(--bg-secondary);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .toc h3 {
        color: var(--text-dark);
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .toc ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .toc li {
        margin-bottom: 0.5rem;
    }

    .toc a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .toc a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .content-section {
            padding: 2rem;
        }
        
        .toc {
            padding: 1.5rem;
        }
    }
</style>

<div class="main-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Privacy Policy</h1>
            <p class="hero-subtitle">Your privacy and data security are our top priorities</p>
            <p class="last-updated">Last updated: <?php echo date('F j, Y'); ?></p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <!-- Table of Contents -->
        <div class="toc">
            <h3>Table of Contents</h3>
            <ul>
                <li><a href="#information-we-collect">1. Information We Collect</a></li>
                <li><a href="#how-we-use-information">2. How We Use Your Information</a></li>
                <li><a href="#information-sharing">3. Information Sharing and Disclosure</a></li>
                <li><a href="#data-security">4. Data Security</a></li>
                <li><a href="#data-retention">5. Data Retention</a></li>
                <li><a href="#your-rights">6. Your Rights and Choices</a></li>
                <li><a href="#cookies">7. Cookies and Tracking Technologies</a></li>
                <li><a href="#changes">8. Changes to This Policy</a></li>
                <li><a href="#contact">9. Contact Us</a></li>
            </ul>
        </div>

        <div class="policy-content">
            <p>
                At MAYVIS (operated by Keen Creative), we respect your privacy and are committed to protecting your personal information. 
                This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our proposal management platform.
            </p>

            <div class="highlight-box">
                <h4><i class="fas fa-shield-alt"></i> Our Commitment</h4>
                <p>We will never sell, rent, or share your personal information with third parties for their marketing purposes without your explicit consent.</p>
            </div>

            <h2 class="section-title" id="information-we-collect">1. Information We Collect</h2>
            
            <h3 class="subsection-title">Information You Provide</h3>
            <p>We collect information you directly provide to us, including:</p>
            <ul>
                <li><strong>Account Information:</strong> Name, email address, phone number, company details</li>
                <li><strong>Profile Information:</strong> Profile pictures, job titles, biographical information</li>
                <li><strong>Business Content:</strong> Proposals, templates, client information, project details</li>
                <li><strong>Communication Data:</strong> Messages, feedback, support requests</li>
                <li><strong>Payment Information:</strong> Billing address, payment method details (processed securely by third-party providers)</li>
            </ul>

            <h3 class="subsection-title">Information We Collect Automatically</h3>
            <p>When you use MAYVIS, we automatically collect certain information:</p>
            <ul>
                <li><strong>Usage Data:</strong> How you interact with our platform, features used, time spent</li>
                <li><strong>Device Information:</strong> IP address, browser type, operating system, device identifiers</li>
                <li><strong>Log Data:</strong> Access times, pages viewed, errors encountered</li>
                <li><strong>Location Data:</strong> General geographic location based on IP address</li>
            </ul>

            <h2 class="section-title" id="how-we-use-information">2. How We Use Your Information</h2>
            
            <p>We use your information for the following purposes:</p>
            <ul>
                <li><strong>Service Delivery:</strong> Providing, maintaining, and improving MAYVIS platform features</li>
                <li><strong>Account Management:</strong> Creating and managing your account, authentication</li>
                <li><strong>Communication:</strong> Sending important updates, responding to inquiries, providing support</li>
                <li><strong>Personalization:</strong> Customizing your experience and recommending relevant features</li>
                <li><strong>Analytics:</strong> Understanding usage patterns to improve our services</li>
                <li><strong>Security:</strong> Protecting against fraud, abuse, and security threats</li>
                <li><strong>Legal Compliance:</strong> Meeting legal obligations and protecting our rights</li>
            </ul>

            <h2 class="section-title" id="information-sharing">3. Information Sharing and Disclosure</h2>
            
            <p>We may share your information in the following limited circumstances:</p>
            
            <h3 class="subsection-title">With Your Consent</h3>
            <p>We may share information when you have given us explicit permission to do so.</p>

            <h3 class="subsection-title">Service Providers</h3>
            <p>We work with trusted third-party service providers who help us operate our platform:</p>
            <ul>
                <li>Cloud hosting providers (secure data storage)</li>
                <li>Payment processors (billing and transactions)</li>
                <li>Email service providers (communications)</li>
                <li>Analytics providers (usage insights)</li>
            </ul>

            <h3 class="subsection-title">Legal Requirements</h3>
            <p>We may disclose information if required by law, court order, or to protect our rights and safety.</p>

            <h2 class="section-title" id="data-security">4. Data Security</h2>
            
            <p>We implement robust security measures to protect your information:</p>
            <ul>
                <li><strong>Encryption:</strong> All data transmission uses SSL/TLS encryption</li>
                <li><strong>Access Controls:</strong> Limited access on a need-to-know basis</li>
                <li><strong>Regular Security Audits:</strong> Ongoing monitoring and vulnerability assessments</li>
                <li><strong>Secure Infrastructure:</strong> Industry-standard cloud hosting with security certifications</li>
                <li><strong>Employee Training:</strong> Regular security awareness training for our team</li>
            </ul>

            <div class="highlight-box">
                <h4><i class="fas fa-lock"></i> Your Data is Safe</h4>
                <p>We use the same level of security employed by major financial institutions to protect your sensitive information.</p>
            </div>

            <h2 class="section-title" id="data-retention">5. Data Retention</h2>
            
            <p>We retain your information for as long as necessary to provide our services and comply with legal obligations:</p>
            <ul>
                <li><strong>Account Data:</strong> Retained while your account is active</li>
                <li><strong>Business Content:</strong> Retained according to your preferences and legal requirements</li>
                <li><strong>Log Data:</strong> Typically retained for 12 months for security and analytics purposes</li>
                <li><strong>Deleted Accounts:</strong> Data purged within 30 days of account deletion (except as required by law)</li>
            </ul>

            <h2 class="section-title" id="your-rights">6. Your Rights and Choices</h2>
            
            <p>You have several rights regarding your personal information:</p>
            <ul>
                <li><strong>Access:</strong> Request a copy of your personal information</li>
                <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                <li><strong>Portability:</strong> Export your data in a commonly used format</li>
                <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                <li><strong>Restriction:</strong> Limit how we process your information</li>
            </ul>

            <p>To exercise these rights, please contact us at <strong>privacy@keencreative.com</strong>.</p>

            <h2 class="section-title" id="cookies">7. Cookies and Tracking Technologies</h2>
            
            <p>We use cookies and similar technologies to enhance your experience:</p>
            <ul>
                <li><strong>Essential Cookies:</strong> Required for basic platform functionality</li>
                <li><strong>Preference Cookies:</strong> Remember your settings and customizations</li>
                <li><strong>Analytics Cookies:</strong> Help us understand how you use our platform</li>
                <li><strong>Security Cookies:</strong> Protect against fraud and unauthorized access</li>
            </ul>

            <p>You can control cookie settings through your browser preferences.</p>

            <h2 class="section-title" id="changes">8. Changes to This Policy</h2>
            
            <p>
                We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. 
                We will notify you of significant changes by email or through our platform. Your continued use of MAYVIS 
                after any changes constitutes acceptance of the updated policy.
            </p>

            <h2 class="section-title" id="contact">9. Contact Us</h2>
            
            <p>
                If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, 
                please don't hesitate to contact us:
            </p>

            <div class="contact-info">
                <h4>Contact Information</h4>
                <p>
                    <strong>Email:</strong> <a href="mailto:privacy@keencreative.com">privacy@keencreative.com</a><br>
                    <strong>Phone:</strong> (555) 123-4567<br>
                    <strong>Address:</strong> Keen Creative, Edmonton, AB, Canada<br>
                    <strong>Response Time:</strong> We typically respond within 48 hours
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for table of contents links
    document.querySelectorAll('.toc a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

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

    // Highlight current section in table of contents
    const observerOptions = {
        rootMargin: '-20% 0px -75% 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                // Remove active class from all TOC links
                document.querySelectorAll('.toc a').forEach(link => {
                    link.style.fontWeight = '500';
                    link.style.color = 'var(--primary-color)';
                });
                // Add active style to current section
                const activeLink = document.querySelector(`.toc a[href="#${id}"]`);
                if (activeLink) {
                    activeLink.style.fontWeight = '700';
                    activeLink.style.color = 'var(--primary-dark)';
                }
            }
        });
    }, observerOptions);

    // Observe all section titles
    document.querySelectorAll('[id]').forEach(section => {
        observer.observe(section);
    });
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
