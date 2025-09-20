<?php
$page_title = 'About Us';
$page_description = 'Learn about our banking heritage and commitment to excellence';
include('../../includes/functions.php');
include('../../includes/header.php');

$config = getConfig();
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ol>
            <li><a href="../../index.php">Home</a></li>
            <li class="active">About Us</li>
        </ol>
    </div>
</div>

<!-- Hero Section -->
<section class="hero-section" style="padding: 60px 0; background: linear-gradient(135deg, #2c5282 0%, #1a365d 100%);">
    <div class="container">
        <div class="hero-content">
            <h1 style="font-size: 2.5rem;">About <?php echo $config['site_name']; ?></h1>
            <p style="font-size: 1.25rem; opacity: 0.95;">Building financial partnerships for over <?php echo $config['company']['established']; ?> years</p>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="services-section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <h2 style="margin-bottom: 30px;">Our Story</h2>
                <p style="font-size: 1.125rem; margin-bottom: 25px;">
                    Since <?php echo $config['company']['established']; ?>, <?php echo $config['site_name']; ?> has been at the forefront of banking innovation,
                    providing exceptional financial services to individuals, businesses, and institutions.
                </p>
                <p style="margin-bottom: 25px;">
                    We started as a local bank with a simple mission: to provide honest, reliable banking services that help our customers achieve their financial goals.
                    Today, we've grown into a leading financial institution serving millions of customers across multiple countries.
                </p>
                <p style="margin-bottom: 25px;">
                    Our commitment to excellence, innovation, and customer satisfaction has earned us numerous awards and recognition in the banking industry.
                    We continue to evolve, embracing new technologies while maintaining the personal touch that our customers value.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                    <div style="text-align: center; padding: 20px; background: var(--light-color); border-radius: var(--border-radius);">
                        <h3 style="color: var(--accent-color); font-size: 2rem; margin-bottom: 10px;">50+</h3>
                        <p style="margin: 0; font-weight: 500;">Years of Excellence</p>
                    </div>
                    <div style="text-align: center; padding: 20px; background: var(--light-color); border-radius: var(--border-radius);">
                        <h3 style="color: var(--accent-color); font-size: 2rem; margin-bottom: 10px;">1M+</h3>
                        <p style="margin: 0; font-weight: 500;">Happy Customers</p>
                    </div>
                </div>
            </div>
            <div style="text-align: center;">
                <img src="assets/images/about-us-hero.jpg" alt="About Horizon Bank" style="width: 100%; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
            </div>
        </div>
    </div>
</section>

<!-- Our Mission & Vision -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Our Mission & Vision</h2>
            <p>Driving financial growth and prosperity</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <div style="background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-bullseye" style="color: white; font-size: 2rem;"></i>
                </div>
                <h3 style="margin-bottom: 20px; color: var(--primary-color);">Our Mission</h3>
                <p style="font-size: 1.1rem; line-height: 1.6;">
                    To provide innovative, reliable, and customer-centric banking solutions that empower individuals and businesses
                    to achieve their financial aspirations while contributing to economic growth and prosperity.
                </p>
            </div>

            <div style="background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); text-align: center;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--accent-color), #FF8A65); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-eye" style="color: white; font-size: 2rem;"></i>
                </div>
                <h3 style="margin-bottom: 20px; color: var(--primary-color);">Our Vision</h3>
                <p style="font-size: 1.1rem; line-height: 1.6;">
                    To be the leading bank of choice, recognized for excellence in customer service, innovation in financial products,
                    and our commitment to sustainable banking practices that benefit our communities and the environment.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="services-section" style="background-color: white;">
    <div class="container">
        <div class="section-header">
            <h2>Our Core Values</h2>
            <p>The principles that guide everything we do</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Integrity</h3>
                <p>We conduct business with the highest ethical standards, building trust through transparency and honesty in all our interactions.</p>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Customer First</h3>
                <p>Our customers are at the center of everything we do. We strive to exceed expectations and deliver exceptional service experiences.</p>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Innovation</h3>
                <p>We embrace technology and innovation to create better banking solutions that simplify and enhance our customers' financial lives.</p>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Security</h3>
                <p>We prioritize the security and privacy of our customers' information with state-of-the-art protection measures.</p>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Community</h3>
                <p>We are committed to supporting the communities we serve through responsible banking and social initiatives.</p>
            </div>

            <div class="service-card">
                <div class="service-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Sustainability</h3>
                <p>We promote sustainable practices and support environmentally responsible projects that benefit future generations.</p>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Leadership Team</h2>
            <p>Meet the experienced professionals leading our organization</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <?php
            $leaders = [
                [
                    'name' => 'John Anderson',
                    'position' => 'Chief Executive Officer',
                    'bio' => '25+ years of banking experience, former VP at major international bank',
                    'image' => 'assets/images/team/ceo.jpg'
                ],
                [
                    'name' => 'Sarah Mitchell',
                    'position' => 'Chief Financial Officer',
                    'bio' => 'CPA with extensive experience in financial planning and risk management',
                    'image' => 'assets/images/team/cfo.jpg'
                ],
                [
                    'name' => 'Michael Chen',
                    'position' => 'Chief Technology Officer',
                    'bio' => 'Technology leader specializing in digital banking innovations',
                    'image' => 'assets/images/team/cto.jpg'
                ],
                [
                    'name' => 'Lisa Rodriguez',
                    'position' => 'Chief Risk Officer',
                    'bio' => 'Expert in risk assessment and regulatory compliance',
                    'image' => 'assets/images/team/cro.jpg'
                ]
            ];

            foreach($leaders as $leader):
            ?>
            <div style="background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow); overflow: hidden; text-align: center;">
                <div style="height: 200px; background: linear-gradient(135deg, var(--light-color), var(--border-color)); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="font-size: 4rem; color: var(--text-light);"></i>
                </div>
                <div style="padding: 25px;">
                    <h4 style="margin-bottom: 5px; color: var(--primary-color);"><?php echo $leader['name']; ?></h4>
                    <p style="color: var(--accent-color); font-weight: 500; margin-bottom: 15px;"><?php echo $leader['position']; ?></p>
                    <p style="color: var(--text-light); font-size: 0.9rem;"><?php echo $leader['bio']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Awards & Recognition -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Awards & Recognition</h2>
            <p>Celebrating our achievements and industry recognition</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
            <div style="padding: 30px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <i class="fas fa-trophy" style="font-size: 3rem; color: #FFD700; margin-bottom: 20px;"></i>
                <h4 style="margin-bottom: 10px;">Bank of the Year</h4>
                <p style="color: var(--text-light); font-size: 0.9rem;">Global Banking Awards 2023</p>
            </div>

            <div style="padding: 30px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <i class="fas fa-medal" style="font-size: 3rem; color: #C0C0C0; margin-bottom: 20px;"></i>
                <h4 style="margin-bottom: 10px;">Excellence in Customer Service</h4>
                <p style="color: var(--text-light); font-size: 0.9rem;">Customer Choice Awards 2023</p>
            </div>

            <div style="padding: 30px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <i class="fas fa-star" style="font-size: 3rem; color: #CD7F32; margin-bottom: 20px;"></i>
                <h4 style="margin-bottom: 10px;">Best Digital Innovation</h4>
                <p style="color: var(--text-light); font-size: 0.9rem;">FinTech Excellence Awards 2023</p>
            </div>

            <div style="padding: 30px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <i class="fas fa-certificate" style="font-size: 3rem; color: var(--success-color); margin-bottom: 20px;"></i>
                <h4 style="margin-bottom: 10px;">Top Employer</h4>
                <p style="color: var(--text-light); font-size: 0.9rem;">Great Place to Work 2023</p>
            </div>
        </div>
    </div>
</section>

<!-- Corporate Information -->
<section class="product-highlights" style="background-color: white;">
    <div class="container">
        <div class="section-header">
            <h2>Corporate Information</h2>
            <p>Important details about our organization</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            <div style="padding: 30px; background: var(--light-color); border-radius: var(--border-radius);">
                <h4 style="margin-bottom: 20px; color: var(--primary-color);">Legal Information</h4>
                <div style="space-y: 10px;">
                    <p><strong>Legal Name:</strong> <?php echo $config['company']['legal_name']; ?></p>
                    <p><strong>Established:</strong> <?php echo $config['company']['established']; ?></p>
                    <p><strong>Registration:</strong> <?php echo $config['company']['registration']; ?></p>
                    <p><strong>License:</strong> <?php echo $config['company']['license']; ?></p>
                </div>
            </div>

            <div style="padding: 30px; background: var(--light-color); border-radius: var(--border-radius);">
                <h4 style="margin-bottom: 20px; color: var(--primary-color);">Contact Information</h4>
                <div style="space-y: 10px;">
                    <p><strong>Head Office:</strong> <?php echo $config['contact']['address']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $config['contact']['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $config['contact']['email']; ?></p>
                    <p><strong>Website:</strong> <?php echo $config['site_url']; ?></p>
                </div>
            </div>

            <div style="padding: 30px; background: var(--light-color); border-radius: var(--border-radius);">
                <h4 style="margin-bottom: 20px; color: var(--primary-color);">Service Coverage</h4>
                <div style="space-y: 10px;">
                    <p><strong>Countries:</strong> 24 Countries</p>
                    <p><strong>Branches:</strong> 150+ Locations</p>
                    <p><strong>ATMs:</strong> 500+ Network</p>
                    <p><strong>Customers:</strong> 1M+ Active Users</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Join Our Banking Family?</h2>
        <p>Experience the difference of banking with <?php echo $config['site_name']; ?></p>
        <div class="cta-buttons">
            <a href="forms/account-opening.php" class="btn btn-primary" style="background: white; color: var(--accent-color);">Open an Account</a>
            <a href="forms/contact.php" class="btn btn-outline" style="border-color: white; color: white;">Contact Us</a>
        </div>
    </div>
</section>

<?php include('../../includes/footer.php'); ?>