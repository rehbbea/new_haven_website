<?php
// Fix file: /var/www/html/newsite/wp-content/plugins/edge-core/post-types/portfolio/portfolio-register.php

$file = '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/portfolio/portfolio-register.php';
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
file_put_contents($file, $fixed_content);
echo "Fixed $file successfully.";
