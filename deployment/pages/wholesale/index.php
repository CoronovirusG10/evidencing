<?php
$page_title = 'Wholesale Banking';
$page_description = 'Comprehensive wholesale banking solutions for large corporations and institutions';
include('../../includes/functions.php');
include('../../includes/header.php');

$config = getConfig();
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ol>
            <li><a href="../../index.php">Home</a></li>
            <li class="active">Wholesale Banking</li>
        </ol>
    </div>
</div>

<!-- Hero Section -->
<section class="hero-section" style="padding: 60px 0; background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);">
    <div class="container">
        <div class="hero-content">
            <h1 style="font-size: 2.5rem;">Wholesale Banking Solutions</h1>
            <p style="font-size: 1.25rem; opacity: 0.95;">Empowering large corporations with comprehensive financial services and strategic banking partnerships</p>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Wholesale Banking Services</h2>
            <p>Tailored solutions for your corporate banking needs</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Transaction Banking</h3>
                <p>Comprehensive cash management and payment solutions for efficient liquidity management.</p>
                <a href="pages/wholesale/transaction-banking.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-ship"></i>
                </div>
                <h3>Trade Finance Services</h3>
                <p>Complete trade finance solutions including LCs, guarantees, and documentary collections.</p>
                <a href="pages/wholesale/trade-finance.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3>Corporate Finance</h3>
                <p>Strategic financing solutions including syndicated loans, project finance, and structured finance.</p>
                <a href="pages/wholesale/corporate-finance.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <h3>Foreign Exchange & Treasury</h3>
                <p>FX solutions, hedging strategies, and treasury management services.</p>
                <a href="pages/wholesale/forex-treasury.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h3>Institutional Banking</h3>
                <p>Specialized banking services for financial institutions and government entities.</p>
                <a href="pages/wholesale/institutional-banking.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3>Asset Financing</h3>
                <p>Flexible financing solutions linked to your assets and cash flows.</p>
                <a href="pages/wholesale/asset-financing.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Key Features -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose Our Wholesale Banking?</h2>
            <p>Experience the advantages of partnering with us</p>
        </div>

        <div class="highlights-grid">
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-globe-asia"></i>
                </div>
                <div class="highlight-content">
                    <h4>Global Network</h4>
                    <p>Access to international markets through our extensive correspondent banking network.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="highlight-content">
                    <h4>Dedicated Team</h4>
                    <p>Expert relationship managers providing personalized service and strategic advice.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="highlight-content">
                    <h4>Innovation</h4>
                    <p>Cutting-edge digital platforms for seamless transaction processing and reporting.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Risk Management</h4>
                    <p>Comprehensive risk assessment and mitigation strategies for your business.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="highlight-content">
                    <h4>Strategic Partnerships</h4>
                    <p>Long-term partnerships focused on your business growth and success.</p>
                </div>
            </div>

            <div class="highlight-card">
                <div class="highlight-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div class="highlight-content">
                    <h4>Quick Processing</h4>
                    <p>Fast turnaround times for all your corporate banking requirements.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Industry Solutions -->
<section class="services-section" style="background-color: white;">
    <div class="container">
        <div class="section-header">
            <h2>Industry-Specific Solutions</h2>
            <p>Specialized banking services tailored to your industry</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <?php
            $industries = [
                ['name' => 'Manufacturing', 'icon' => 'fas fa-industry'],
                ['name' => 'Real Estate', 'icon' => 'fas fa-building'],
                ['name' => 'Healthcare', 'icon' => 'fas fa-hospital'],
                ['name' => 'Technology', 'icon' => 'fas fa-microchip'],
                ['name' => 'Energy & Utilities', 'icon' => 'fas fa-bolt'],
                ['name' => 'Retail & Commerce', 'icon' => 'fas fa-shopping-cart'],
                ['name' => 'Transportation', 'icon' => 'fas fa-truck'],
                ['name' => 'Telecommunications', 'icon' => 'fas fa-satellite-dish']
            ];

            foreach($industries as $industry):
            ?>
            <div style="text-align: center; padding: 30px; background-color: var(--light-color); border-radius: var(--border-radius); transition: all var(--transition-speed); cursor: pointer;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--box-shadow)';"
                 onmouseout="this.style.transform=''; this.style.boxShadow='';">
                <i class="<?php echo $industry['icon']; ?>" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 15px;"></i>
                <h4 style="margin-bottom: 0;"><?php echo $industry['name']; ?></h4>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
    <div class="container">
        <h2>Ready to Transform Your Corporate Banking?</h2>
        <p>Connect with our wholesale banking experts today</p>
        <div class="cta-buttons">
            <a href="forms/contact.php" class="btn btn-primary" style="background: white; color: var(--primary-color);">Contact Our Team</a>
            <a href="#" class="btn btn-outline" style="border-color: white; color: white;">Download Brochure</a>
        </div>
    </div>
</section>

<?php include('../../includes/footer.php'); ?>