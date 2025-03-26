<?php
// Fix all CPT register files with multiple access modifiers

$files = [
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/portfolio/portfolio-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/testimonials/testimonials-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/slider/slider-register.php',
    '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/match/match-register.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Replace the problematic declaration with a single private declaration
        $fixed_content = str_replace(
            "public 	/**
	 * @var string
	 */
	private \$taxBase;",
            "/**
	 * @var string
	 */
	private \$taxBase;",
            $content
        );
        
        // Save the fixed file
        if ($content \!== $fixed_content) {
            file_put_contents($file, $fixed_content);
            echo "Fixed $file successfully.\n";
        } else {
            echo "No changes needed for $file.\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}

echo "All fixes completed.";
