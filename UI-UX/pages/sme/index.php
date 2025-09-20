<?php
$page_title = 'SME Banking';
$page_description = 'Tailored banking solutions for small and medium enterprises';
include('../../includes/functions.php');
include('../../includes/header.php');

$config = getConfig();
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ol>
            <li><a href="../../index.php">Home</a></li>
            <li class="active">SME Banking</li>
        </ol>
    </div>
</div>

<!-- Hero Section -->
<section class="hero-section" style="padding: 60px 0; background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);">
    <div class="container">
        <div class="hero-content">
            <h1 style="font-size: 2.5rem;">SME Banking Solutions</h1>
            <p style="font-size: 1.25rem; opacity: 0.95;">Empowering small and medium enterprises with flexible financial solutions to grow your business</p>
            <div class="hero-buttons" style="margin-top: 30px;">
                <a href="forms/business-account.php" class="btn btn-primary">Open Business Account</a>
                <a href="pages/sme/financing.php" class="btn btn-outline" style="background: white; color: var(--primary-color);">Apply for Financing</a>
            </div>
        </div>
    </div>
</section>

<!-- Key Benefits -->
<section class="quick-links" style="background-color: white;">
    <div class="container">
        <div class="quick-links-grid">
            <div class="quick-link-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="fas fa-ban" style="color: white;"></i>
                <span>Zero Hidden Charges</span>
            </div>
            <div class="quick-link-item" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="fas fa-bolt" style="color: white;"></i>
                <span>Quick Approvals</span>
            </div>
            <div class="quick-link-item" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="fas fa-percentage" style="color: white;"></i>
                <span>Competitive Rates</span>
            </div>
            <div class="quick-link-item" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                <i class="fas fa-headset" style="color: white;"></i>
                <span>Dedicated Support</span>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Complete SME Banking Services</h2>
            <p>Everything your business needs to thrive</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Business Accounts</h3>
                <p>Feature-rich current accounts designed for your business operations with no minimum balance.</p>
                <a href="pages/sme/business-accounts.php" class="service-link">Open Account <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Business Financing</h3>
                <p>Flexible working capital loans and term loans to fuel your business growth.</p>
                <a href="pages/sme/financing.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #FF6B35, #F7931E);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Labor Guarantee</h3>
                <p><strong>Fee-Free Service!</strong> Get labor guarantees without any charges or hidden fees.</p>
                <a href="pages/sme/labor-guarantee.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <h3>Salary WPS</h3>
                <p>Automated salary processing system ensuring timely payments to your employees.</p>
                <a href="pages/sme/salary-wps.php" class="service-link">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>Business Credit Cards</h3>
                <p>Corporate cards with expense management features and attractive rewards.</p>
                <a href="pages/sme/business-credit-cards.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h3>Merchant Services</h3>
                <p>POS solutions and payment gateway for seamless customer transactions.</p>
                <a href="pages/sme/merchant-services.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Special Offer Banner -->
<section class="cta-section" style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Special Offer: Fee-Free Labor Guarantee</h2>
        <p style="font-size: 1.25rem; margin-bottom: 30px;">Get your labor guarantee processed with absolutely no fees!</p>
        <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; margin-bottom: 30px;">
            <div style="text-align: center;">
                <i class="fas fa-ban" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p style="font-weight: bold;">Zero Processing Fees</p>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-clock" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p style="font-weight: bold;">24-Hour Processing</p>
            </div>
            <div style="text-align: center;">
                <i class="fas fa-file-alt" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p style="font-weight: bold;">Minimal Documents</p>
            </div>
        </div>
        <a href="pages/sme/labor-guarantee.php" class="btn btn-primary" style="background: white; color: var(--accent-color); font-size: 1.125rem; padding: 15px 40px;">Apply for Labor Guarantee</a>
    </div>
</section>

<!-- Business Growth Tools -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Tools to Grow Your Business</h2>
            <p>Digital solutions designed for modern businesses</p>
        </div>

        <div class="highlights-grid">
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Business Mobile App</h4>
                    <p>Manage your business accounts on the go with our dedicated business banking app.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="highlight-content">
                    <h4>Financial Analytics</h4>
                    <p>Real-time insights into your business finances with detailed reports and analytics.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="highlight-content">
                    <h4>Invoice Financing</h4>
                    <p>Convert your unpaid invoices into immediate working capital.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="highlight-content">
                    <h4>Multi-User Access</h4>
                    <p>Grant controlled access to your team members with role-based permissions.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-sync"></i>
                </div>
                <div class="highlight-content">
                    <h4>Automated Payments</h4>
                    <p>Schedule recurring payments and automate your business transactions.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Business Insurance</h4>
                    <p>Protect your business with comprehensive insurance solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories -->
<section class="services-section" style="background-color: white;">
    <div class="container">
        <div class="section-header">
            <h2>Success Stories</h2>
            <p>How we've helped businesses grow</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div style="padding: 30px; background-color: var(--light-color); border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-store" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">Retail Business</h4>
                        <p style="color: var(--text-light); margin: 0;">Fashion Retailer</p>
                    </div>
                </div>
                <p style="font-style: italic; margin-bottom: 15px;">"The working capital loan helped us expand to three new locations within a year."</p>
                <div style="display: flex; gap: 20px; color: var(--text-light); font-size: 0.875rem;">
                    <span><i class="fas fa-arrow-up" style="color: var(--success-color);"></i> 150% Growth</span>
                    <span><i class="fas fa-users"></i> 50+ Employees</span>
                </div>
            </div>

            <div style="padding: 30px; background-color: var(--light-color); border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-utensils" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">Restaurant Chain</h4>
                        <p style="color: var(--text-light); margin: 0;">Food & Beverage</p>
                    </div>
                </div>
                <p style="font-style: italic; margin-bottom: 15px;">"The POS integration and merchant services transformed our payment processing."</p>
                <div style="display: flex; gap: 20px; color: var(--text-light); font-size: 0.875rem;">
                    <span><i class="fas fa-arrow-up" style="color: var(--success-color);"></i> 200% Revenue</span>
                    <span><i class="fas fa-store-alt"></i> 8 Outlets</span>
                </div>
            </div>

            <div style="padding: 30px; background-color: var(--light-color); border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fas fa-cogs" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 5px;">Manufacturing</h4>
                        <p style="color: var(--text-light); margin: 0;">Industrial Equipment</p>
                    </div>
                </div>
                <p style="font-style: italic; margin-bottom: 15px;">"Asset financing helped us upgrade our machinery without straining cash flow."</p>
                <div style="display: flex; gap: 20px; color: var(--text-light); font-size: 0.875rem;">
                    <span><i class="fas fa-arrow-up" style="color: var(--success-color);"></i> 80% Efficiency</span>
                    <span><i class="fas fa-industry"></i> 2 Factories</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="services-section">
    <div class="container" style="text-align: center;">
        <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Ready to Take Your Business to the Next Level?</h2>
        <p style="font-size: 1.25rem; color: var(--text-light); margin-bottom: 40px;">Join thousands of successful SMEs banking with us</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; max-width: 800px; margin: 0 auto;">
            <a href="forms/business-account.php" class="btn btn-primary" style="padding: 15px 30px;">
                <i class="fas fa-briefcase" style="margin-right: 10px;"></i>
                Open Business Account
            </a>
            <a href="pages/sme/financing.php" class="btn btn-secondary" style="padding: 15px 30px;">
                <i class="fas fa-hand-holding-usd" style="margin-right: 10px;"></i>
                Apply for Financing
            </a>
            <a href="forms/contact.php" class="btn btn-outline" style="padding: 15px 30px;">
                <i class="fas fa-phone" style="margin-right: 10px;"></i>
                Talk to an Expert
            </a>
        </div>
    </div>
</section>

<?php include('../../includes/footer.php'); ?>