<?php
// Check if we've missed any fixes from the original list of warnings

// Check the socialIcons properties in icon classes
$icon_files = [
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.fontawesome.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.fontelegant.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.ionicons.php'
];

foreach ($icon_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "Checking file: " . basename($file) . "\n";
        
        // Check if socialIcons property is defined
        if (preg_match('/public \$socialIcons;/', $content)) {
            echo "  ✓ socialIcons property is declared\n";
        } else {
            echo "  ✗ socialIcons property is missing\!\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}

// Check the EldritchEdgeTitle class for hidden_value
$layout_file = '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.layout-part1.php';
if (file_exists($layout_file)) {
    $content = file_get_contents($layout_file);
    echo "Checking EldritchEdgeTitle in edgt.layout-part1.php\n";
    
    // Check if hidden_value property is defined
    if (preg_match('/public \$hidden_value;/', $content)) {
        echo "  ✓ hidden_value property is declared\n";
    } else {
        echo "  ✗ hidden_value property is missing\!\n";
    }
}

// Check taxBase in CPT register classes
$cpt_files = [
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/portfolio/portfolio-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/testimonials/testimonials-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/slider/slider-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/match/match-register.php'
];

foreach ($cpt_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "Checking file: " . basename($file) . "\n";
        
        // Check if taxBase property is defined
        if (preg_match('/private \$taxBase;/', $content)) {
            echo "  ✓ taxBase property is declared\n";
        } else {
            echo "  ✗ taxBase property is missing or has wrong modifier\!\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}

echo "Check completed.";
