<?php
namespace EdgeCore\Lib;

use EdgeCore\CPT\Portfolio;
use EdgeCore\CPT\Match;
use EdgeCore\CPT\Carousels;
use EdgeCore\CPT\Slider;
use EdgeCore\CPT\Testimonials;

/**
 * Class ShortcodeLoader
 * @package EdgeCore\Lib
 */
class ShortcodeLoader {
	/**
	 * @var private instance of current class
	 */
	private static $instance;
	/**
	 * @var array
	 */
	private $loadedShortcodes = array();

	/**
	 * Private constuct because of Singletone
	 */
	private function __construct() {
	}

	/**
	 * Returns current instance of class
	 * @return ShortcodeLoader
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			return new self;
		}

		return self::$instance;
	}

	/**
	 * Adds new shortcode. Object that it takes must implement ShortcodeInterface
	 *
	 * @param ShortcodeInterface $shortcode
	 */
	private function addShortcode(ShortcodeInterface $shortcode) {
		if(!array_key_exists($shortcode->getBase(), $this->loadedShortcodes)) {
			$this->loadedShortcodes[$shortcode->getBase()] = $shortcode;
		}
	}

	/**
	 * Adds all shortcodes.
	 *
	 * @see ShortcodeLoader::addShortcode()
	 */
	private function addShortcodes() {
		$this->addShortcode(new Portfolio\Shortcodes\PortfolioList());
		$this->addShortcode(new Portfolio\Shortcodes\PortfolioSlider());
		$this->addShortcode(new Portfolio\Shortcodes\HorizontallyScrollingPortfolioList());
		$this->addShortcode(new Match\Shortcodes\MatchList());
		$this->addShortcode(new Match\Shortcodes\MatchSmallList());
		$this->addShortcode(new Match\Shortcodes\MatchFeatured());
		$this->addShortcode(new Carousels\Shortcodes\Carousel());
		$this->addShortcode(new Slider\Shortcodes\Slider());
		$this->addShortcode(new Testimonials\Shortcodes\Testimonials());
	}

	/**
	 * Calls ShortcodeLoader::addShortcodes and than loops through added shortcodes and calls render method
	 * of each shortcode object
	 */
	public function load() {
		$this->addShortcodes();

		foreach($this->loadedShortcodes as $shortcode) {
			add_shortcode($shortcode->getBase(), array($shortcode, 'render'));
		}

	}
}