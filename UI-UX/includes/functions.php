<?php
/**
 * Helper Functions
 */

// Load configuration
function getConfig() {
    static $config = null;
    if ($config === null) {
        $config = include(__DIR__ . '/../config/site.config.php');
    }
    return $config;
}

// Format currency
function formatCurrency($amount, $currency = 'USD') {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'AED' => 'AED '
    ];

    $symbol = isset($symbols[$currency]) ? $symbols[$currency] : $currency . ' ';
    return $symbol . number_format($amount, 2);
}

// Format phone number
function formatPhone($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // Format as XXX XX XX XX
    if (strlen($phone) == 9) {
        return substr($phone, 0, 3) . ' ' . substr($phone, 3, 2) . ' ' . substr($phone, 5, 2) . ' ' . substr($phone, 7, 2);
    }

    return $phone;
}

// Generate breadcrumb
function generateBreadcrumb($items) {
    $config = getConfig();
    $html = '<nav class="breadcrumb"><ol>';
    $html .= '<li><a href="/UI-UX/">Home</a></li>';

    foreach ($items as $label => $url) {
        if ($url) {
            $html .= '<li><a href="' . $url . '">' . $label . '</a></li>';
        } else {
            $html .= '<li class="active">' . $label . '</li>';
        }
    }

    $html .= '</ol></nav>';
    return $html;
}

// Get service card HTML
function getServiceCard($title, $description, $icon, $link, $link_text = 'Learn More') {
    $html = '<div class="service-card">';
    $html .= '<div class="service-icon"><i class="' . $icon . '"></i></div>';
    $html .= '<h3>' . $title . '</h3>';
    $html .= '<p>' . $description . '</p>';
    $html .= '<a href="' . $link . '" class="service-link">' . $link_text . ' <i class="fas fa-arrow-right"></i></a>';
    $html .= '</div>';
    return $html;
}

// Get feature box HTML
function getFeatureBox($title, $features = [], $cta_text = null, $cta_link = null) {
    $html = '<div class="feature-box">';
    $html .= '<h3>' . $title . '</h3>';

    if (!empty($features)) {
        $html .= '<ul class="feature-list">';
        foreach ($features as $feature) {
            $html .= '<li><i class="fas fa-check"></i> ' . $feature . '</li>';
        }
        $html .= '</ul>';
    }

    if ($cta_text && $cta_link) {
        $html .= '<a href="' . $cta_link . '" class="btn btn-primary">' . $cta_text . '</a>';
    }

    $html .= '</div>';
    return $html;
}

// Calculate loan EMI
function calculateEMI($principal, $rate, $tenure_months) {
    // Convert annual rate to monthly rate
    $monthly_rate = ($rate / 100) / 12;

    // Calculate EMI using formula
    $emi = ($principal * $monthly_rate * pow(1 + $monthly_rate, $tenure_months)) /
           (pow(1 + $monthly_rate, $tenure_months) - 1);

    return round($emi, 2);
}

// Calculate interest amount
function calculateInterest($principal, $rate, $tenure_months) {
    $emi = calculateEMI($principal, $rate, $tenure_months);
    $total_payment = $emi * $tenure_months;
    return round($total_payment - $principal, 2);
}

// Generate random transaction reference
function generateTransactionRef() {
    return 'TXN' . date('YmdHis') . rand(1000, 9999);
}

// Sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validate phone
function validatePhone($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 9 && strlen($phone) <= 15;
}

// Get client IP address
function getClientIP() {
    $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP,
                    FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

// Create alert message
function createAlert($message, $type = 'info') {
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle'
    ];

    $icon = isset($icons[$type]) ? $icons[$type] : $icons['info'];

    $html = '<div class="alert alert-' . $type . '">';
    $html .= '<i class="fas ' . $icon . '"></i>';
    $html .= '<span>' . $message . '</span>';
    $html .= '<button class="alert-close" onclick="this.parentElement.remove();">&times;</button>';
    $html .= '</div>';

    return $html;
}

// Format date
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

// Get working hours status
function getWorkingHoursStatus() {
    $config = getConfig();
    $current_time = date('H:i');
    $current_day = date('N'); // 1 (Monday) to 7 (Sunday)

    // Check if it's a weekday (Monday to Friday)
    if ($current_day >= 1 && $current_day <= 5) {
        if ($current_time >= '08:00' && $current_time <= '17:00') {
            return ['status' => 'open', 'message' => 'We are currently open'];
        }
    }
    // Saturday
    elseif ($current_day == 6) {
        if ($current_time >= '09:00' && $current_time <= '13:00') {
            return ['status' => 'open', 'message' => 'We are currently open'];
        }
    }

    return ['status' => 'closed', 'message' => 'We are currently closed'];
}

// Generate meta tags
function generateMetaTags($title = null, $description = null, $keywords = null, $image = null) {
    $config = getConfig();

    $title = $title ?: $config['seo']['default_title'];
    $description = $description ?: $config['seo']['default_description'];
    $keywords = $keywords ?: $config['seo']['default_keywords'];
    $image = $image ?: $config['seo']['og_image'];

    $html = '<meta name="description" content="' . $description . '">' . "\n";
    $html .= '<meta name="keywords" content="' . $keywords . '">' . "\n";
    $html .= '<meta property="og:title" content="' . $title . '">' . "\n";
    $html .= '<meta property="og:description" content="' . $description . '">' . "\n";
    $html .= '<meta property="og:image" content="' . $image . '">' . "\n";
    $html .= '<meta property="og:url" content="' . $config['site_url'] . $_SERVER['REQUEST_URI'] . '">' . "\n";

    return $html;
}
?>