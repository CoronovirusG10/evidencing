<?php
$page_title = 'Home';
$page_description = 'Welcome to Horizon Bank - Your trusted banking partner offering comprehensive wholesale, SME, and personal banking solutions.';
include('includes/functions.php');
include('includes/header.php');

$config = getConfig();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Welcome to <?php echo $config['site_name']; ?></h1>
            <p><?php echo $config['site_tagline']; ?></p>
            <div class="hero-buttons">
                <a href="forms/account-opening.php" class="btn btn-primary">Open an Account</a>
                <a href="pages/personal/loans.php" class="btn btn-outline" style="background: white; color: var(--primary-color);">Apply for Loan</a>
            </div>
            <div class="hero-features">
                <span><i class="fas fa-check-circle"></i> No Hidden Fees</span>
                <span><i class="fas fa-check-circle"></i> 24/7 Banking</span>
                <span><i class="fas fa-check-circle"></i> Secure & Fast</span>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="quick-links">
    <div class="container">
        <div class="quick-links-grid">
            <a href="#online-banking" class="quick-link-item">
                <i class="fas fa-laptop"></i>
                <span>Online Banking</span>
            </a>
            <a href="forms/account-opening.php" class="quick-link-item">
                <i class="fas fa-user-plus"></i>
                <span>Open Account</span>
            </a>
            <a href="pages/personal/loans.php" class="quick-link-item">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Apply for Loan</span>
            </a>
            <a href="pages/about/locations.php" class="quick-link-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Find Branch/ATM</span>
            </a>
            <a href="forms/contact.php" class="quick-link-item">
                <i class="fas fa-headset"></i>
                <span>Contact Support</span>
            </a>
        </div>
    </div>
</section>

<!-- Main Services Section -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Banking Services</h2>
            <p>Comprehensive financial solutions tailored to your needs</p>
        </div>

        <div class="services-grid">
            <?php
            echo getServiceCard(
                'Wholesale Banking',
                'Complete banking solutions for large corporations including transaction banking, trade finance, and treasury services.',
                'fas fa-building',
                'pages/wholesale/',
                'Explore Services'
            );

            echo getServiceCard(
                'SME Banking',
                'Tailored financial services for small and medium enterprises to help grow your business.',
                'fas fa-store',
                'pages/sme/',
                'Explore Services'
            );

            echo getServiceCard(
                'Personal Banking',
                'Complete range of personal banking services from savings accounts to loans and credit cards.',
                'fas fa-user',
                'pages/personal/',
                'Explore Services'
            );
            ?>
        </div>
    </div>
</section>

<!-- Product Highlights Section -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Featured Products</h2>
            <p>Discover our most popular banking products</p>
        </div>

        <div class="highlights-grid">
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Labor Guarantee</h4>
                    <p>Fee-free labor guarantee service with quick processing and minimal documentation.</p>
                    <a href="pages/sme/labor-guarantee.php">Learn More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Salary WPS</h4>
                    <p>Automated salary processing system ensuring timely payments to your employees.</p>
                    <a href="pages/sme/salary-wps.php">Learn More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="highlight-content">
                    <h4>Asset Financing</h4>
                    <p>Flexible financing solutions linked to your business cash flows and assets.</p>
                    <a href="pages/wholesale/asset-financing.php">Learn More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="highlight-content">
                    <h4>Home Loans</h4>
                    <p>Competitive rates and flexible repayment options for your dream home.</p>
                    <a href="pages/personal/home-loans.php">Learn More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="highlight-content">
                    <h4>Credit Cards</h4>
                    <p>Premium credit cards with exclusive rewards and cashback offers.</p>
                    <a href="pages/personal/credit-cards.php">Learn More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <div class="highlight-content">
                    <h4>Savings Accounts</h4>
                    <p>High-yield savings accounts with no minimum balance requirements.</p>
                    <a href="pages/personal/savings-accounts.php">Learn More →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="services-section" style="background-color: white;">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose <?php echo $config['site_name']; ?>?</h2>
            <p>Experience banking excellence with our unique advantages</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Award-Winning Service</h3>
                <p>Recognized for excellence in customer service and innovative banking solutions.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Bank-Level Security</h3>
                <p>Advanced encryption and security protocols to protect your financial data.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>24/7 Banking</h3>
                <p>Access your accounts anytime, anywhere with our digital banking platforms.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3>Global Network</h3>
                <p>Worldwide banking network for seamless international transactions.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Expert Team</h3>
                <p>Dedicated relationship managers and financial advisors at your service.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Banking</h3>
                <p>Full-featured mobile app for banking on the go.</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="product-highlights" style="background-color: var(--light-color);">
    <div class="container">
        <div class="section-header">
            <h2>Banking with Impact</h2>
            <p>Numbers that speak for our commitment to excellence</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center; margin-top: 50px;">
            <div>
                <h3 style="font-size: 3rem; color: var(--accent-color); margin-bottom: 10px;" class="counter" data-target="1000000">0</h3>
                <p style="font-size: 1.125rem; font-weight: 500;">Happy Customers</p>
            </div>
            <div>
                <h3 style="font-size: 3rem; color: var(--accent-color); margin-bottom: 10px;" class="counter" data-target="50">0</h3>
                <p style="font-size: 1.125rem; font-weight: 500;">Years of Excellence</p>
            </div>
            <div>
                <h3 style="font-size: 3rem; color: var(--accent-color); margin-bottom: 10px;" class="counter" data-target="200">0</h3>
                <p style="font-size: 1.125rem; font-weight: 500;">Branches & ATMs</p>
            </div>
            <div>
                <h3 style="font-size: 3rem; color: var(--accent-color); margin-bottom: 10px;" class="counter" data-target="24">0</h3>
                <p style="font-size: 1.125rem; font-weight: 500;">Countries Served</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Start Banking with Us?</h2>
        <p>Join thousands of satisfied customers and experience banking excellence</p>
        <div class="cta-buttons">
            <a href="forms/account-opening.php" class="btn btn-primary" style="background: white; color: var(--accent-color);">Open an Account</a>
            <a href="pages/about/contact.php" class="btn btn-outline" style="border-color: white; color: white;">Contact Us</a>
        </div>
    </div>
</section>

<!-- Mobile App Section -->
<?php if($config['features']['mobile_app']): ?>
<section class="services-section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <h2>Bank on the Go</h2>
                <p style="font-size: 1.125rem; margin-bottom: 30px;">Download our mobile app and enjoy seamless banking experience anytime, anywhere.</p>

                <div style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="color: var(--success-color); font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>Check balances and transaction history</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="color: var(--success-color); font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>Transfer funds instantly</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="color: var(--success-color); font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>Pay bills and recharge services</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="color: var(--success-color); font-size: 1.5rem; margin-right: 15px;"></i>
                        <span>Locate nearest branch or ATM</span>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <a href="<?php echo $config['mobile_apps']['ios']; ?>" target="_blank">
                        <img src="assets/images/app-store.png" alt="Download on App Store" style="height: 50px;">
                    </a>
                    <a href="<?php echo $config['mobile_apps']['android']; ?>" target="_blank">
                        <img src="assets/images/google-play.png" alt="Get it on Google Play" style="height: 50px;">
                    </a>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="assets/images/mobile-app-mockup.png" alt="Mobile App" style="max-width: 400px; width: 100%;">
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest News Section -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Latest Updates</h2>
            <p>Stay informed with our latest news and announcements</p>
        </div>

        <div class="highlights-grid">
            <div class="highlight-card">
                <div class="highlight-content">
                    <span style="color: var(--text-light); font-size: 0.875rem;">December 15, 2023</span>
                    <h4>New Digital Banking Features Launched</h4>
                    <p>Enhanced mobile app with biometric authentication and instant payments.</p>
                    <a href="#">Read More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-content">
                    <span style="color: var(--text-light); font-size: 0.875rem;">December 10, 2023</span>
                    <h4>Special Home Loan Offer</h4>
                    <p>Reduced interest rates and processing fees for limited time.</p>
                    <a href="#">Read More →</a>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-content">
                    <span style="color: var(--text-light); font-size: 0.875rem;">December 5, 2023</span>
                    <h4>New Branch Opening</h4>
                    <p>Expanding our presence with a new branch in the financial district.</p>
                    <a href="#">Read More →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>