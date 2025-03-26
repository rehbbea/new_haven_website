<?php
/**
 * Fix Deprecated Dynamic Property Warnings in WordPress
 */

// Icon classes that need the socialIcons property declared
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
        
        // First find where the class properties are declared
        if (preg_match('/public \$icons;(.*?)function __construct/s', $content, $matches)) {
            $properties_section = $matches[1];
            
            // Check if socialIcons is already declared
            if (strpos($properties_section, 'public $socialIcons;') === false) {
                // Add the socialIcons property
                $new_properties_section = $properties_section . "\tpublic \$socialIcons;\n\t";
                $content = str_replace($properties_section, $new_properties_section, $content);
                
                // Save the file
                file_put_contents($file, $content);
                echo "Fixed file: " . $file . "<br>";
            } else {
                echo "Property already exists in: " . $file . "<br>";
            }
        }
    }
}

// Fix EldritchEdgeTitle::$hidden_value in edgt.layout-part1.php
$layout_file = '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.layout-part1.php';
if (file_exists($layout_file)) {
    $content = file_get_contents($layout_file);
    
    // Find where the EldritchEdgeTitle class properties are declared
    if (preg_match('/class EldritchEdgeTitle implements iEldritchEdgeRender \{(.*?)function __construct/s', $content, $matches)) {
        $properties_section = $matches[1];
        
        // Check if hidden_value is already declared as a public property (it's currently private)
        if (strpos($properties_section, 'public $hidden_value;') === false) {
            // Add hidden_value as a public property
            $new_properties_section = str_replace('public $hidden_values = array();', "public \$hidden_values = array();\n    public \$hidden_value;", $properties_section);
            $content = str_replace($properties_section, $new_properties_section, $content);
            
            // Save the file
            file_put_contents($layout_file, $content);
            echo "Fixed EldritchEdgeTitle class in: " . $layout_file . "<br>";
        }
    }
}

// Fix Icon::$base in edge-core/shortcodes/icon/icon.php
$icon_shortcode_file = '/var/www/html/newsite/wp-content/plugins/edge-core/shortcodes/icon/icon.php';
if (file_exists($icon_shortcode_file)) {
    $content = file_get_contents($icon_shortcode_file);
    
    // Find the Icon class declaration
    if (preg_match('/class Icon extends \\\EdgeCore\\\Shortcodes\\\Lib\\\ShortcodeInterface \{(.*?)function __construct/s', $content, $matches)) {
        $properties_section = $matches[1];
        
        // Check if base property is already declared
        if (strpos($properties_section, 'public $base;') === false) {
            // Add base as a public property at the beginning of the class
            $new_content = str_replace(
                'class Icon extends \EdgeCore\Shortcodes\Lib\ShortcodeInterface {', 
                "class Icon extends \EdgeCore\Shortcodes\Lib\ShortcodeInterface {\n\tpublic \$base;", 
                $content
            );
            
            // Save the file
            file_put_contents($icon_shortcode_file, $new_content);
            echo "Fixed Icon class in: " . $icon_shortcode_file . "<br>";
        }
    }
}

// Fix taxBase property in CPT register classes
$cpt_files = [
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/portfolio/portfolio-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/testimonials/testimonials-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/slider/slider-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/match/match-register.php'
];

foreach ($cpt_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Check if the class has the taxBase property declared
        if (preg_match('/class \w+Register implements PostTypeInterface \{(.*?)function __construct/s', $content, $matches)) {
            $properties_section = $matches[1];
            
            // Check if taxBase is already declared
            if (strpos($properties_section, 'private $taxBase;') === false && strpos($properties_section, 'public $taxBase;') === false) {
                // Add taxBase as a private property
                $new_properties_section = $properties_section . "\t/**\n\t * @var string\n\t */\n\tprivate \$taxBase;\n\n\t";
                $content = str_replace($properties_section, $new_properties_section, $content);
                
                // Save the file
                file_put_contents($file, $content);
                echo "Fixed taxBase property in: " . $file . "<br>";
            } else {
                echo "taxBase property already exists in: " . $file . "<br>";
            }
        }
    }
}

// Fix EldritchEdgeSidebar::$title property
$sidebar_file = '/var/www/html/newsite/wp-content/themes/eldritch/includes/sidebar/edgt-custom-sidebar.php';
if (file_exists($sidebar_file)) {
    $content = file_get_contents($sidebar_file);
    
    // Find where the EldritchEdgeSidebar class properties are declared
    if (preg_match('/class EldritchEdgeSidebar \{(.*?)function __construct/s', $content, $matches)) {
        $properties_section = $matches[1];
        
        // Check if title is already declared as a property
        if (strpos($properties_section, 'public $title;') === false) {
            // Add title as a public property
            $new_content = str_replace(
                'class EldritchEdgeSidebar {', 
                "class EldritchEdgeSidebar {\n\tpublic \$title;", 
                $content
            );
            
            // Save the file
            file_put_contents($sidebar_file, $new_content);
            echo "Fixed EldritchEdgeSidebar class in: " . $sidebar_file . "<br>";
        }
    }
}

// Fix HeaderStandard::$menuAreaHeight property
$header_file = '/var/www/html/newsite/wp-content/themes/eldritch/framework/modules/header/types/header-standard.php';
if (file_exists($header_file)) {
    $content = file_get_contents($header_file);
    
    // Find the HeaderStandard class
    if (preg_match('/class HeaderStandard extends HeaderType \{(.*?)function __construct/s', $content, $matches)) {
        $properties_section = $matches[1];
        
        // Check if menuAreaHeight is already declared
        if (strpos($properties_section, 'public $menuAreaHeight;') === false) {
            // Add menuAreaHeight as a public property
            $new_content = str_replace(
                'class HeaderStandard extends HeaderType {', 
                "class HeaderStandard extends HeaderType {\n\tpublic \$menuAreaHeight;", 
                $content
            );
            
            // Save the file
            file_put_contents($header_file, $new_content);
            echo "Fixed HeaderStandard class in: " . $header_file . "<br>";
        }
    }
}

// Fix HeaderConnector::$object property
$header_connector_file = '/var/www/html/newsite/wp-content/themes/eldritch/framework/modules/header/lib/header-connector.php';
if (file_exists($header_connector_file)) {
    $content = file_get_contents($header_connector_file);
    
    // Find HeaderConnector class
    if (preg_match('/class HeaderConnector \{(.*?)function __construct/s', $content, $matches)) {
        $properties_section = $matches[1];
        
        // Check if object is already declared
        if (strpos($properties_section, 'public $object;') === false) {
            // Add object as a public property
            $new_content = str_replace(
                'class HeaderConnector {', 
                "class HeaderConnector {\n\tpublic \$object;", 
                $content
            );
            
            // Save the file
            file_put_contents($header_connector_file, $new_content);
            echo "Fixed HeaderConnector class in: " . $header_connector_file . "<br>";
        }
    }
}

echo "<p>All fixes have been applied. You may need to clear any caching to see the changes.</p>";
