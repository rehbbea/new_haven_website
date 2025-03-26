<?php
$file = '/var/www/html/newsite/wp-content/plugins/edge-core/shortcodes/icon/icon.php';
$content = file_get_contents($file);

$old = "class Icon implements ShortcodeInterface {


	/**
	 * Icon constructor.
	 */";

$new = "class Icon implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private \$base;

	/**
	 * Icon constructor.
	 */";

$fixed_content = str_replace($old, $new, $content);
file_put_contents($file, $fixed_content);
echo "Fixed file: $file";
