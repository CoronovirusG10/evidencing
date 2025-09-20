<?php
$page_title = 'Personal Banking';
$page_description = 'Complete personal banking services for all your financial needs';
include('../../includes/functions.php');
include('../../includes/header.php');

$config = getConfig();
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ol>
            <li><a href="../../index.php">Home</a></li>
            <li class="active">Personal Banking</li>
        </ol>
    </div>
</div>

<!-- Hero Section -->
<section class="hero-section" style="padding: 60px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="hero-content">
            <h1 style="font-size: 2.5rem;">Personal Banking Made Simple</h1>
            <p style="font-size: 1.25rem; opacity: 0.95;">Experience banking that adapts to your lifestyle with our comprehensive personal banking services</p>
            <div class="hero-buttons" style="margin-top: 30px;">
                <a href="forms/account-opening.php" class="btn btn-primary">Open an Account</a>
                <a href="pages/personal/loans.php" class="btn btn-outline" style="background: white; color: var(--primary-color);">Explore Loans</a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Services -->
<section class="quick-links" style="background-color: white;">
    <div class="container">
        <div class="quick-links-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
            <a href="pages/personal/savings-accounts.php" class="quick-link-item">
                <i class="fas fa-piggy-bank"></i>
                <span>Savings</span>
            </a>
            <a href="pages/personal/current-accounts.php" class="quick-link-item">
                <i class="fas fa-wallet"></i>
                <span>Current</span>
            </a>
            <a href="pages/personal/credit-cards.php" class="quick-link-item">
                <i class="fas fa-credit-card"></i>
                <span>Cards</span>
            </a>
            <a href="pages/personal/personal-loans.php" class="quick-link-item">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Loans</span>
            </a>
            <a href="pages/personal/fixed-deposits.php" class="quick-link-item">
                <i class="fas fa-lock"></i>
                <span>Deposits</span>
            </a>
            <a href="pages/personal/digital-banking.php" class="quick-link-item">
                <i class="fas fa-mobile-alt"></i>
                <span>Digital</span>
            </a>
        </div>
    </div>
</section>

<!-- Banking Products -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Banking Products</h2>
            <p>Choose from our wide range of personal banking products</p>
        </div>

        <!-- Accounts Section -->
        <h3 style="margin-bottom: 30px; color: var(--primary-color);">
            <i class="fas fa-university" style="margin-right: 10px;"></i> Accounts
        </h3>
        <div class="services-grid" style="margin-bottom: 60px;">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <h3>Savings Accounts</h3>
                <p>High-yield savings accounts with no minimum balance and free debit card.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Up to 4% interest rate</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> No minimum balance</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Free debit card</li>
                </ul>
                <a href="pages/personal/savings-accounts.php" class="service-link">Open Account <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>Current Accounts</h3>
                <p>Feature-rich current accounts for your daily banking needs.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Unlimited transactions</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Free checkbook</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Overdraft facility</li>
                </ul>
                <a href="pages/personal/current-accounts.php" class="service-link">Open Account <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Fixed Deposits</h3>
                <p>Secure your funds with attractive interest rates on fixed deposits.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Up to 7% interest</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Flexible tenure</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Loan against FD</li>
                </ul>
                <a href="pages/personal/fixed-deposits.php" class="service-link">Start FD <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Loans Section -->
        <h3 style="margin-bottom: 30px; color: var(--primary-color);">
            <i class="fas fa-hand-holding-usd" style="margin-right: 10px;"></i> Loans
        </h3>
        <div class="services-grid" style="margin-bottom: 60px;">
            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Personal Loans</h3>
                <p>Quick personal loans for all your financial needs with minimal documentation.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Up to $500,000</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> 48-hour approval</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> No collateral</li>
                </ul>
                <a href="pages/personal/personal-loans.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Home Loans</h3>
                <p>Make your dream home a reality with our competitive home loan offers.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> From 6.5% interest</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Up to 30 years</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> 90% financing</li>
                </ul>
                <a href="pages/personal/home-loans.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Auto Loans</h3>
                <p>Drive your dream car home with our hassle-free auto financing.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> 100% financing</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Quick approval</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Flexible EMI</li>
                </ul>
                <a href="pages/personal/auto-loans.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Cards Section -->
        <h3 style="margin-bottom: 30px; color: var(--primary-color);">
            <i class="fas fa-credit-card" style="margin-right: 10px;"></i> Cards & Digital
        </h3>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>Credit Cards</h3>
                <p>Premium credit cards with exclusive rewards and cashback offers.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Up to 5% cashback</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Travel rewards</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Zero annual fee*</li>
                </ul>
                <a href="pages/personal/credit-cards.php" class="service-link">Apply Now <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #f77062 0%, #fe5196 100%);">
                    <i class="fas fa-id-card"></i>
                </div>
                <h3>Debit Cards</h3>
                <p>Secure debit cards with worldwide acceptance and zero liability.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Global acceptance</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Contactless payments</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> ATM access</li>
                </ul>
                <a href="pages/personal/debit-cards.php" class="service-link">Get Card <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Digital Banking</h3>
                <p>Complete banking services at your fingertips with our digital platforms.</p>
                <ul style="list-style: none; padding: 0; margin: 20px 0;">
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Mobile banking</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Online banking</li>
                    <li><i class="fas fa-check" style="color: var(--success-color); margin-right: 8px;"></i> Digital wallet</li>
                </ul>
                <a href="pages/personal/digital-banking.php" class="service-link">Get Started <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Loan Calculator -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Loan Calculator</h2>
            <p>Calculate your EMI instantly</p>
        </div>

        <div id="loan-calculator" style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
            <div class="form-group">
                <label>Loan Amount ($)</label>
                <input type="number" id="loan-amount" class="form-control" placeholder="Enter loan amount" value="100000">
            </div>
            <div class="form-group">
                <label>Interest Rate (%)</label>
                <input type="number" id="interest-rate" class="form-control" placeholder="Enter interest rate" value="8.5" step="0.1">
            </div>
            <div class="form-group">
                <label>Loan Tenure (Months)</label>
                <input type="number" id="loan-tenure" class="form-control" placeholder="Enter tenure in months" value="60">
            </div>
            <button id="calculate-loan" class="btn btn-primary" style="width: 100%;">Calculate EMI</button>

            <div id="calculation-results" style="display: none; margin-top: 30px; padding: 20px; background-color: var(--light-color); border-radius: var(--border-radius);">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; text-align: center;">
                    <div>
                        <p style="color: var(--text-light); margin-bottom: 10px;">Monthly EMI</p>
                        <h3 id="monthly-emi" style="color: var(--primary-color);">$0</h3>
                    </div>
                    <div>
                        <p style="color: var(--text-light); margin-bottom: 10px;">Total Interest</p>
                        <h3 id="total-interest" style="color: var(--accent-color);">$0</h3>
                    </div>
                    <div>
                        <p style="color: var(--text-light); margin-bottom: 10px;">Total Amount</p>
                        <h3 id="total-amount" style="color: var(--success-color);">$0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers -->
<section class="cta-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h2>Special Offers Just for You</h2>
        <p style="font-size: 1.25rem; margin-bottom: 40px;">Limited time offers on our banking products</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; max-width: 800px; margin: 0 auto;">
            <div style="background: white; padding: 25px; border-radius: var(--border-radius); text-align: center;">
                <i class="fas fa-percentage" style="font-size: 2.5rem; color: var(--accent-color); margin-bottom: 15px;"></i>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Zero Processing Fee</h4>
                <p style="color: var(--text-color); margin-bottom: 15px;">On all personal loans this month</p>
                <a href="pages/personal/personal-loans.php" style="color: var(--secondary-color);">Apply Now →</a>
            </div>

            <div style="background: white; padding: 25px; border-radius: var(--border-radius); text-align: center;">
                <i class="fas fa-gift" style="font-size: 2.5rem; color: var(--accent-color); margin-bottom: 15px;"></i>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Welcome Bonus</h4>
                <p style="color: var(--text-color); margin-bottom: 15px;">$100 bonus on new savings account</p>
                <a href="pages/personal/savings-accounts.php" style="color: var(--secondary-color);">Open Account →</a>
            </div>

            <div style="background: white; padding: 25px; border-radius: var(--border-radius); text-align: center;">
                <i class="fas fa-plane" style="font-size: 2.5rem; color: var(--accent-color); margin-bottom: 15px;"></i>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Travel Miles</h4>
                <p style="color: var(--text-color); margin-bottom: 15px;">5X miles on credit card spends</p>
                <a href="pages/personal/credit-cards.php" style="color: var(--secondary-color);">Get Card →</a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Banking Benefits</h2>
            <p>Experience the advantage of banking with us</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
            <div>
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-ban" style="color: white; font-size: 2rem;"></i>
                </div>
                <h4>No Hidden Charges</h4>
                <p style="color: var(--text-light);">Transparent pricing with no surprises</p>
            </div>

            <div>
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock" style="color: white; font-size: 2rem;"></i>
                </div>
                <h4>24/7 Banking</h4>
                <p style="color: var(--text-light);">Bank anytime, anywhere</p>
            </div>

            <div>
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shield-alt" style="color: white; font-size: 2rem;"></i>
                </div>
                <h4>Secure Banking</h4>
                <p style="color: var(--text-light);">Bank-level security for your peace of mind</p>
            </div>

            <div>
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-headset" style="color: white; font-size: 2rem;"></i>
                </div>
                <h4>Expert Support</h4>
                <p style="color: var(--text-light);">Dedicated support team at your service</p>
            </div>
        </div>
    </div>
</section>

<?php include('../../includes/footer.php'); ?>