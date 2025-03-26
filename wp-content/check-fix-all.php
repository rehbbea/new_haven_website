<?php
// This script will check for multiple access modifiers in all fixed files

// List all the areas we've applied fixes to
$paths = [
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/edgt.icons/',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/lib/',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/',
    '/var/www/html/newsite/wp-content/plugins/edge-core/shortcodes/icon/',
    '/var/www/html/newsite/wp-content/themes/eldritch/includes/sidebar/',
    '/var/www/html/newsite/wp-content/themes/eldritch/framework/modules/header/'
];

// Pattern to match multiple access modifiers
$patterns = [
    '/public\s+public\s+/',
    '/private\s+private\s+/',
    '/protected\s+protected\s+/',
    '/public\s+private\s+/',
    '/private\s+public\s+/',
    '/public\s+protected\s+/',
    '/protected\s+public\s+/',
    '/private\s+protected\s+/',
    '/protected\s+private\s+/'
];

// Recursively scan directories and check PHP files
foreach ($paths as $path) {
    if (is_dir($path)) {
        $dir_iterator = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($dir_iterator);
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $content)) {
                        echo "Found multiple modifiers in: " . $file->getPathname() . "\n";
                        
                        // Fix the file
                        foreach ($patterns as $fix_pattern) {
                            $first_modifier = substr($fix_pattern, 1, strpos($fix_pattern, '\\') - 1);
                            $content = preg_replace($fix_pattern, $first_modifier . ' ', $content);
                        }
                        
                        file_put_contents($file->getPathname(), $content);
                        echo "  Fixed the file.\n";
                        break;
                    }
                }
            }
        }
    } else {
        echo "Directory not found: $path\n";
    }
}

echo "Check completed.";
