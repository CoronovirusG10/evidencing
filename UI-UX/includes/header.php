<?php
$config = include(__DIR__ . '/../config/site.config.php');
$current_page = basename($_SERVER['PHP_SELF']);

// Auto-detect directory depth for correct asset paths
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];
$depth = substr_count(dirname($script_name), '/') - 1; // Subtract 1 for root level
$base_path = str_repeat('../', max(0, $depth));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : $config['seo']['default_description']; ?>">
    <meta name="keywords" content="<?php echo isset($page_keywords) ? $page_keywords : $config['seo']['default_keywords']; ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' - ' . $config['site_name'] : $config['seo']['default_title']; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : $config['seo']['default_description']; ?>">
    <meta property="og:image" content="<?php echo $config['seo']['og_image']; ?>">
    <meta property="og:url" content="<?php echo $config['site_url']; ?>">

    <title><?php echo isset($page_title) ? $page_title . ' - ' . $config['site_name'] : $config['seo']['default_title']; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $config['logo']['favicon']; ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/responsive.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <span><i class="fas fa-phone"></i> <?php echo $config['contact']['phone']; ?></span>
                <span><i class="fas fa-envelope"></i> <?php echo $config['contact']['email']; ?></span>
            </div>
            <div class="top-bar-right">
                <div class="language-selector">
                    <select id="language-switch">
                        <?php foreach($config['languages']['available'] as $code => $name): ?>
                            <option value="<?php echo $code; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if($config['features']['online_banking']): ?>
                <a href="#" class="btn-online-banking">
                    <i class="fas fa-lock"></i> Online Banking
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-wrapper">
                <!-- Logo -->
                <div class="logo">
                    <a href="<?php echo $base_path; ?>index.php">
                        <img src="<?php echo $config['logo']['main']; ?>" alt="<?php echo $config['site_name']; ?>">
                    </a>
                </div>

                <!-- Main Navigation -->
                <nav class="main-nav">
                    <ul class="nav-menu">
                        <li class="nav-item has-dropdown">
                            <a href="<?php echo $base_path; ?>pages/wholesale/">Wholesale</a>
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">
                                    <div class="menu-column">
                                        <h3>Banking Services</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/transaction-banking.php">Transaction Banking</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/cash-management.php">Cash Management</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/liquidity-solutions.php">Liquidity Solutions</a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-column">
                                        <h3>Trade & Finance</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/trade-finance.php">Trade Finance Services</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/corporate-finance.php">Corporate Finance</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/project-finance.php">Project Finance</a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-column">
                                        <h3>Investment Services</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/forex-treasury.php">Foreign Exchange & Treasury</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/institutional-banking.php">Institutional Banking</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/wholesale/capital-markets.php">Capital Markets</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item has-dropdown">
                            <a href="<?php echo $base_path; ?>pages/sme/">SME</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/business-accounts.php">Business Accounts</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/financing.php">Business Financing</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/labor-guarantee.php">Labor Guarantee</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/salary-wps.php">Salary WPS</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/merchant-services.php">Merchant Services</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/sme/business-credit-cards.php">Business Credit Cards</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item has-dropdown">
                            <a href="<?php echo $base_path; ?>pages/personal/">Personal</a>
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">
                                    <div class="menu-column">
                                        <h3>Accounts</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/savings-accounts.php">Savings Accounts</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/current-accounts.php">Current Accounts</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/fixed-deposits.php">Fixed Deposits</a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-column">
                                        <h3>Loans</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/personal-loans.php">Personal Loans</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/auto-loans.php">Auto Loans</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/home-loans.php">Home Loans</a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-column">
                                        <h3>Cards & Payments</h3>
                                        <ul>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/credit-cards.php">Credit Cards</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/debit-cards.php">Debit Cards</a></li>
                                            <li><a href="<?php echo $base_path; ?>pages/personal/digital-banking.php">Digital Banking</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item has-dropdown">
                            <a href="<?php echo $base_path; ?>pages/about/">About Us</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="<?php echo $base_path; ?>pages/about/">About <?php echo $config['site_name']; ?></a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/about/leadership.php">Leadership</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/about/careers.php">Careers</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/about/press.php">Press Room</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/about/contact.php">Contact Us</a></li>
                                    <li><a href="<?php echo $base_path; ?>pages/about/locations.php">Branch & ATM Locator</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Search -->
                <div class="header-search">
                    <button class="search-toggle">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <div class="mobile-nav-content">
            <button class="mobile-nav-close">
                <i class="fas fa-times"></i>
            </button>
            <ul class="mobile-menu">
                <!-- Mobile menu items will be populated by JavaScript -->
            </ul>
        </div>
    </nav>

    <!-- Search Overlay -->
    <div class="search-overlay">
        <div class="search-overlay-content">
            <button class="search-close">
                <i class="fas fa-times"></i>
            </button>
            <form action="<?php echo $base_path; ?>search.php" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Search..." required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <main class="main-content">