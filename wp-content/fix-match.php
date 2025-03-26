<?php
$file = '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/match/match-register.php';
$content = file_get_contents($file);

$old = "	public 	/**
	 * @var string
	 */
	private \$taxBase;";

$new = "	/**
	 * @var string
	 */
	private \$taxBase;";

$fixed_content = str_replace($old, $new, $content);
file_put_contents($file, $fixed_content);
echo "Fixed file: $file";
