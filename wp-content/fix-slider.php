<?php
$file = '/var/www/html/newsite/wp-content/plugins/edge-core/post-types/slider/slider-register.php';
$content = file_get_contents($file);

$old = "	/**
	 * @var string
	 */
	private \$base;

	public function __construct() {
		\$this->base    = 'slides';
		\$this->taxBase = 'slides_category';";

$new = "	/**
	 * @var string
	 */
	private \$base;

	/**
	 * @var string
	 */
	private \$taxBase;

	public function __construct() {
		\$this->base    = 'slides';
		\$this->taxBase = 'slides_category';";

$fixed_content = str_replace($old, $new, $content);
file_put_contents($file, $fixed_content);
echo "Fixed file: $file";
