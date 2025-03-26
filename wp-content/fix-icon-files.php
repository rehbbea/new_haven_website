<?php
// Fix all icon files with multiple access modifiers

$icon_files = [
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.fontawesome.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.fontelegant.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.ionicons.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.dripicons.php',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/edgt.simplelineicons.php'
];

foreach ($icon_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Fix multiple public modifiers
        $fixed_content = preg_replace('/public\s+public\s+\$socialIcons;/', 'public $socialIcons;', $content);
        
        // Save the fixed file
        if ($content \!== $fixed_content) {
            file_put_contents($file, $fixed_content);
            echo "Fixed multiple modifiers in: $file\n";
        }
    }
}

echo "All icon files fixed.";
