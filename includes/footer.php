<footer class="modern-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="footer-brand">
                    <img src="/mayvis/resources/KeenLogo.jpg" alt="Keen Creative Logo" class="footer-logo">
                    <div class="footer-brand-text">
                        <h6 class="footer-brand-name">MAYVIS</h6>
                        <span class="footer-tagline">Powered by Keen Creative</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-links">
                    <h6 class="footer-heading">Quick Links</h6>
                    <ul class="footer-nav">
                        <li><a href="./about.php" class="footer-link">About</a></li>
                        <li><a href="./terms-conditions.php" class="footer-link">Terms & Conditions</a></li>
                        <li><a href="./privacy-policy.php" class="footer-link">Privacy Policy</a></li>
                        <li><a href="./support.php" class="footer-link">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-social-section">
                    <h6 class="footer-heading">Connect With Us</h6>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/theKEENcreatives/" target="_blank" class="social-link" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/KEENCreatives" target="_blank" class="social-link" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/keencreative/" target="_blank" class="social-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="social-link" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="row">
            <div class="col-12">
                <div class="footer-bottom">
                    <span class="footer-copyright">&copy; 2025 Keen Creative. All rights reserved.</span>
                    <span class="footer-version">MAYVIS v2.0 - Modern Proposal Management</span>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .modern-footer {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%239C92AC" fill-opacity="0.05"><circle cx="30" cy="30" r="4"/></g></svg>');
            opacity: 0.3;
        }

        .modern-footer > .container {
            position: relative;
            z-index: 2;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 1rem;
        }

        .footer-logo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .footer-brand-text {
            display: flex;
            flex-direction: column;
        }

        .footer-brand-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0;
            color: white;
        }

        .footer-tagline {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }

        .footer-heading {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-links {
            margin-bottom: 1rem;
        }

        .footer-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-nav li {
            margin-bottom: 0.5rem;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-link:hover {
            color: #6366f1;
            transform: translateX(5px);
        }

        .footer-social-section {
            margin-bottom: 1rem;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-size: 1.1rem;
        }

        .social-link:hover {
            background: rgba(99, 102, 241, 0.8);
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .footer-divider {
            border: none;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 2rem 0 1rem;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-version {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .footer-brand,
            .footer-links,
            .footer-social-section {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .footer-social {
                justify-content: center;
            }
        }
    </style>
</footer>