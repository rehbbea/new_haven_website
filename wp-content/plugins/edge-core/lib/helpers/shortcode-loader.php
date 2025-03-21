<?php

namespace Eldritch\Modules\Shortcodes\Lib;

use Eldritch\Modules\Shortcodes\BackgroundSlider\BackgroundSlider;
use Eldritch\Modules\Shortcodes\ItemShowcase\ItemShowcase;
use Eldritch\Modules\Shortcodes\ItemShowcaseItem\ItemShowcaseItem;
use Eldritch\Modules\CallToAction\CallToAction;
use Eldritch\Modules\Counter\Countdown;
use Eldritch\Modules\Counter\Counter;
use Eldritch\Modules\Shortcodes\ElementsHolder\ElementsHolder;
use Eldritch\Modules\Shortcodes\ElementsHolderItem\ElementsHolderItem;
use Eldritch\Modules\GoogleMap\GoogleMap;
use Eldritch\Modules\Separator\Separator;
use Eldritch\Modules\PieCharts\PieChartBasic\PieChartBasic;
use Eldritch\Modules\PieCharts\PieChartDoughnut\PieChartDoughnut;
use Eldritch\Modules\PieCharts\PieChartDoughnut\PieChartPie;
use Eldritch\Modules\PieCharts\PieChartWithIcon\PieChartWithIcon;
use Eldritch\Modules\Shortcodes\AnimationsHolder\AnimationsHolder;
use Eldritch\Modules\Shortcodes\BlogSlider\BlogSlider;
use Eldritch\Modules\FramedBanner\FramedBanner;
use Eldritch\Modules\Shortcodes\ComparisonPricingTables\ComparisonPricingTable;
use Eldritch\Modules\Shortcodes\ComparisonPricingTables\ComparisonPricingTablesHolder;
use Eldritch\Modules\Shortcodes\Icon\Icon;
use Eldritch\Modules\Shortcodes\IconProgressBar;
use Eldritch\Modules\Shortcodes\ImageGallery\ImageGallery;
use Eldritch\Modules\Shortcodes\Process\ProcessHolder;
use Eldritch\Modules\Shortcodes\Process\ProcessItem;
use Eldritch\Modules\Shortcodes\SectionSubtitle\SectionSubtitle;
use Eldritch\Modules\Shortcodes\SectionTitle\SectionTitle;
use Eldritch\Modules\Shortcodes\TeamSlider\TeamSlider;
use Eldritch\Modules\Shortcodes\TeamSliderItem\TeamSliderItem;
use Eldritch\Modules\Shortcodes\CardSlider\CardSlider;
use Eldritch\Modules\Shortcodes\CardSliderItem\CardSliderItem;
use Eldritch\Modules\Shortcodes\TwitterSlider\TwitterSlider;
use Eldritch\Modules\Shortcodes\VerticalSplitSlider\VerticalSplitSlider;
use Eldritch\Modules\Shortcodes\VerticalSplitSliderContentItem\VerticalSplitSliderContentItem;
use Eldritch\Modules\Shortcodes\VerticalSplitSliderLeftPanel\VerticalSplitSliderLeftPanel;
use Eldritch\Modules\Shortcodes\VerticalSplitSliderRightPanel\VerticalSplitSliderRightPanel;
use Eldritch\Modules\Shortcodes\VideoBanner\VideoBanner;
use Eldritch\Modules\ProductList\ProductList;
use Eldritch\Modules\SocialShare\SocialShare;
use Eldritch\Modules\Team\Team;
use Eldritch\Modules\OrderedList\OrderedList;
use Eldritch\Modules\UnorderedList\UnorderedList;
use Eldritch\Modules\Message\Message;
use Eldritch\Modules\ProgressBar\ProgressBar;
use Eldritch\Modules\IconListItem\IconListItem;
use Eldritch\Modules\Tabs\Tabs;
use Eldritch\Modules\Tab\Tab;
use Eldritch\Modules\PricingTablesWithIcon\PricingTablesWithIcon;
use Eldritch\Modules\PricingTableWithIcon\PricingTableWithIcon;
use Eldritch\Modules\Accordion\Accordion;
use Eldritch\Modules\AccordionTab\AccordionTab;
use Eldritch\Modules\BlogList\BlogList;
use Eldritch\Modules\Shortcodes\Button\Button;
use Eldritch\Modules\Blockquote\Blockquote;
use Eldritch\Modules\CustomFont\CustomFont;
use Eldritch\Modules\Highlight\Highlight;
use Eldritch\Modules\VideoButton\VideoButton;
use Eldritch\Modules\Dropcaps\Dropcaps;
use Eldritch\Modules\Shortcodes\IconWithText\IconWithText;
use Eldritch\Modules\Shortcodes\MiniTextSlider\MiniTextSlider;
use Eldritch\Modules\Shortcodes\MiniTextSliderItem\MiniTextSliderItem;
use Eldritch\Modules\ImageWithTextOver\ImageWithTextOver;

/**
 * Class ShortcodeLoader
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
		if (self::$instance == null) {
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
		if (!array_key_exists($shortcode->getBase(), $this->loadedShortcodes)) {
			$this->loadedShortcodes[$shortcode->getBase()] = $shortcode;
		}
	}

	/**
	 * Adds all shortcodes.
	 *
	 * @see ShortcodeLoader::addShortcode()
	 */
	private function addShortcodes() {
		$this->addShortcode(new FramedBanner());
		$this->addShortcode(new BackgroundSlider());
		$this->addShortcode(new ElementsHolder());
		$this->addShortcode(new ElementsHolderItem());
		$this->addShortcode(new Team());
		$this->addShortcode(new TeamSlider());
		$this->addShortcode(new TeamSliderItem());
		$this->addShortcode(new Icon());
		$this->addShortcode(new CallToAction());
		$this->addShortcode(new OrderedList());
		$this->addShortcode(new UnorderedList());
		$this->addShortcode(new Message());
		$this->addShortcode(new Counter());
		$this->addShortcode(new Countdown());
		$this->addShortcode(new ProgressBar());
		$this->addShortcode(new IconListItem());
		$this->addShortcode(new Tabs());
		$this->addShortcode(new Tab());
		$this->addShortcode(new PricingTablesWithIcon());
		$this->addShortcode(new PricingTableWithIcon());
		$this->addShortcode(new PieChartBasic());
		$this->addShortcode(new PieChartPie());
		$this->addShortcode(new PieChartDoughnut());
		$this->addShortcode(new PieChartWithIcon());
		$this->addShortcode(new Accordion());
		$this->addShortcode(new AccordionTab());
		$this->addShortcode(new BlogList());
		$this->addShortcode(new Button());
		$this->addShortcode(new Blockquote());
		$this->addShortcode(new CustomFont());
		$this->addShortcode(new Highlight());
		$this->addShortcode(new ImageGallery());
		$this->addShortcode(new GoogleMap());
		$this->addShortcode(new Separator());
		$this->addShortcode(new VideoButton());
		$this->addShortcode(new Dropcaps());
		$this->addShortcode(new IconWithText());
		$this->addShortcode(new SocialShare());
		$this->addShortcode(new VideoBanner());
		$this->addShortcode(new AnimationsHolder());
		$this->addShortcode(new SectionTitle());
		$this->addShortcode(new SectionSubtitle());
		$this->addShortcode(new ProcessHolder());
		$this->addShortcode(new ProcessItem());
		$this->addShortcode(new ComparisonPricingTablesHolder());
		$this->addShortcode(new ComparisonPricingTable());
		$this->addShortcode(new BlogSlider());
		$this->addShortcode(new TwitterSlider());
		$this->addShortcode(new VerticalSplitSlider());
		$this->addShortcode(new VerticalSplitSliderLeftPanel());
		$this->addShortcode(new VerticalSplitSliderRightPanel());
		$this->addShortcode(new VerticalSplitSliderContentItem());
		$this->addShortcode(new MiniTextSlider());
		$this->addShortcode(new MiniTextSliderItem());
		$this->addShortcode(new CardSlider());
		$this->addShortcode(new CardSliderItem());
		$this->addShortcode(new ImageWithTextOver());
        $this->addShortcode(new ItemShowcase());
        $this->addShortcode(new ItemShowcaseItem());
		if (eldritch_edge_is_woocommerce_installed()) {
			$this->addShortcode(new ProductList());
		}

	}

	/**
	 * Calls ShortcodeLoader::addShortcodes and than loops through added shortcodes and calls render method
	 * of each shortcode object
	 */
	public function load() {
		$this->addShortcodes();

		foreach ($this->loadedShortcodes as $shortcode) {
			add_shortcode($shortcode->getBase(), array($shortcode, 'render'));
		}

	}
}

$shortcodeLoader = ShortcodeLoader::getInstance();
$shortcodeLoader->load();