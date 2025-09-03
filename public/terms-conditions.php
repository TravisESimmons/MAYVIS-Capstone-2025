<?php
$title = "Terms and Conditions";
include 'includes/header-new.php';
?>

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-gray: #f8fafc;
    --border-color: #e5e7eb;
    --text-muted: #64748b;
    --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-family: 'Inter', sans-serif;
    color: var(--dark-color);
    line-height: 1.7;
}

.terms-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem;
}

.terms-header {
    background: white;
    border-radius: var(--border-radius);
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
    text-align: center;
}

.terms-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.terms-subtitle {
    color: var(--text-muted);
    font-size: 1.2rem;
    margin: 0;
}

.terms-content {
    background: white;
    border-radius: var(--border-radius);
    padding: 3rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.terms-intro {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.1));
    border-left: 4px solid var(--primary-color);
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    font-size: 1.1rem;
    color: var(--dark-color);
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-top: 3rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
    position: relative;
}

.section-title:first-of-type {
    margin-top: 2rem;
}

.section-title::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
}

.section-content p {
    margin-bottom: 1rem;
    color: var(--text-muted);
    font-size: 1rem;
}

.subsection {
    margin-bottom: 1.5rem;
    padding-left: 1rem;
    border-left: 2px solid var(--border-color);
}

.subsection-title {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.important-notice {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
    border: 1px solid var(--danger-color);
    border-radius: 8px;
    padding: 1.5rem;
    margin: 2rem 0;
}

.important-notice .notice-title {
    color: var(--danger-color);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.important-notice .notice-title i {
    margin-right: 0.5rem;
}

.highlight-box {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    border: 1px solid var(--success-color);
    border-radius: 8px;
    padding: 1.5rem;
    margin: 1.5rem 0;
}

.back-button {
    text-align: center;
    margin-top: 2rem;
}

.btn-back {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    color: white;
    text-decoration: none;
}

.btn-back i {
    margin-right: 0.5rem;
}

.last-updated {
    text-align: center;
    color: var(--text-muted);
    font-style: italic;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

@media (max-width: 768px) {
    .terms-container {
        padding: 1rem;
    }
    
    .terms-header {
        padding: 2rem 1.5rem;
    }
    
    .terms-content {
        padding: 2rem 1.5rem;
    }
    
    .terms-title {
        font-size: 2.5rem;
    }
}
</style>

<div class="terms-container">
    <!-- Terms Header -->
    <div class="terms-header">
        <h1 class="terms-title">Terms & Conditions</h1>
        <p class="terms-subtitle">Service Agreement and Legal Terms</p>
    </div>

    <!-- Terms Content -->
    <div class="terms-content">
        <div class="terms-intro">
            <i class="fas fa-info-circle" style="color: var(--primary-color); margin-right: 0.5rem;"></i>
            These terms and conditions govern the contractual relationship between <strong>MAYVIS Creative Solutions</strong> ("the Company") and the client ("the Client") engaging the Company's services for marketing, logo and brand development, digital marketing, and website design and development. By engaging our services, the Client agrees to abide by these terms and conditions.
        </div>

        <div class="section-content">
            <h2 class="section-title">1. Scope of Services</h2>
            <div class="subsection">
                <div class="subsection-title">1.1 Service Provision</div>
                <p>The Company agrees to provide the Client with the agreed-upon services, including but not limited to marketing strategy development, logo and brand design, digital marketing campaigns, and website design and development.</p>
            </div>
            <div class="subsection">
                <div class="subsection-title">1.2 Project Specifications</div>
                <p>The specific details of the services to be provided, including timelines, deliverables, and costs, will be outlined in a separate agreement or proposal agreed upon by both parties.</p>
            </div>

            <h2 class="section-title">2. Client Responsibilities</h2>
            <div class="subsection">
                <div class="subsection-title">2.1 Information Provision</div>
                <p>The Client agrees to provide all necessary information, materials, and feedback required for the provision of services by the Company in a timely manner.</p>
            </div>
            <div class="subsection">
                <div class="subsection-title">2.2 Accuracy and Rights</div>
                <p>The Client is responsible for ensuring that all information provided to the Company is accurate, complete, and does not infringe upon any third-party rights.</p>
            </div>

            <h2 class="section-title">3. Fees and Payment</h2>
            <div class="highlight-box">
                <div class="subsection">
                    <div class="subsection-title">3.1 Payment Agreement</div>
                    <p>The Client agrees to pay the Company the agreed-upon fees for the services provided, as outlined in the separate agreement or proposal.</p>
                </div>
                <div class="subsection">
                    <div class="subsection-title">3.2 Payment Terms</div>
                    <p>Payment terms will be specified in the separate agreement or proposal. Unless otherwise agreed, payment is due upon receipt of invoice.</p>
                </div>
                <div class="subsection">
                    <div class="subsection-title">3.3 Non-Payment Consequences</div>
                    <p>Failure to make payment in accordance with the agreed terms may result in the suspension or termination of services by the Company.</p>
                </div>
            </div>

            <h2 class="section-title">4. Intellectual Property</h2>
            <div class="important-notice">
                <div class="notice-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Important Intellectual Property Notice
                </div>
                <div class="subsection">
                    <div class="subsection-title">4.1 Ownership Before Payment</div>
                    <p>Any intellectual property created by the Company in the course of providing services to the Client, including but not limited to logos, branding materials, marketing campaigns, and website designs, shall remain the property of the Company until full payment has been received from the Client.</p>
                </div>
                <div class="subsection">
                    <div class="subsection-title">4.2 Transfer of Ownership</div>
                    <p>Upon full payment, ownership of any intellectual property created by the Company shall transfer to the Client, unless otherwise agreed in writing.</p>
                </div>
            </div>

            <h2 class="section-title">5. Confidentiality</h2>
            <div class="subsection">
                <div class="subsection-title">5.1 Mutual Confidentiality</div>
                <p>Both parties agree to maintain the confidentiality of any proprietary or confidential information disclosed during the course of the engagement.</p>
            </div>
            <div class="subsection">
                <div class="subsection-title">5.2 Survival of Terms</div>
                <p>This obligation of confidentiality shall survive the termination of services.</p>
            </div>

            <h2 class="section-title">6. Limitation of Liability</h2>
            <div class="subsection">
                <div class="subsection-title">6.1 Damages Limitation</div>
                <p>The Company shall not be liable for any indirect, incidental, special, or consequential damages arising out of or in connection with the provision of services, even if the Company has been advised of the possibility of such damages.</p>
            </div>

            <h2 class="section-title">7. Termination</h2>
            <div class="subsection">
                <div class="subsection-title">7.1 Termination for Breach</div>
                <p>Either party may terminate the engagement upon written notice to the other party if there is a material breach of these terms and conditions that is not remedied within thirty (30) days of written notice.</p>
            </div>
            <div class="subsection">
                <div class="subsection-title">7.2 Payment Upon Termination</div>
                <p>Upon termination, the Client shall pay any outstanding fees owed to the Company for services provided up to the date of termination.</p>
            </div>

            <h2 class="section-title">8. Governing Law</h2>
            <div class="subsection">
                <div class="subsection-title">8.1 Jurisdiction</div>
                <p>These terms and conditions shall be governed by and construed in accordance with the laws of Alberta, Canada.</p>
            </div>

            <h2 class="section-title">9. Entire Agreement</h2>
            <div class="subsection">
                <div class="subsection-title">9.1 Complete Agreement</div>
                <p>These terms and conditions, together with any separate agreement or proposal entered into by the parties, constitute the entire agreement between the parties with respect to the subject matter hereof, and supersede all prior and contemporaneous agreements and understandings, whether written or oral.</p>
            </div>

            <h2 class="section-title">10. Amendments</h2>
            <div class="subsection">
                <div class="subsection-title">10.1 Modification Requirements</div>
                <p>These terms and conditions may be amended or modified only in writing and signed by both parties.</p>
            </div>

            <div class="highlight-box" style="margin-top: 2rem;">
                <p style="margin: 0; font-weight: 600; text-align: center;">
                    By engaging the services of MAYVIS Creative Solutions, the Client acknowledges that they have read, understood, and agreed to these terms and conditions.
                </p>
            </div>
        </div>

        <div class="last-updated">
            Last updated: <?php echo date('F j, Y'); ?>
        </div>
    </div>

    <!-- Back Button -->
    <div class="back-button">
        <a href="javascript:history.back()" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Return to Previous Page
        </a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>