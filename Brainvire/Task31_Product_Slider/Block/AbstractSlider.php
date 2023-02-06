<?php

namespace Brainvire\Task31_Product_Slider\Block;

use Brainvire\Task31_Product_Slider\Helper\Data;
use Brainvire\Task31_Product_Slider\Model\Config\Source\Additional;
use Exception;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Widget\Block\BlockInterface;

abstract class AbstractSlider extends AbstractProduct implements BlockInterface, IdentityInterface {

	protected $_date;

	protected $_helperData;

	protected $_productCollectionFactory;

	protected $_catalogProductVisibility;

	protected $httpContext;

	protected $urlEncoder;

	protected $grouped;

	protected $configurable;

	protected $rendererListBlock;

	private $priceCurrency;

	private $layoutFactory;

	// AbstractSlider constructor.

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		$this->_productCollectionFactory = $productCollectionFactory;
		$this->_catalogProductVisibility = $catalogProductVisibility;
		$this->_date = $dateTime;
		$this->_helperData = $helperData;
		$this->httpContext = $httpContext;
		$this->urlEncoder = $urlEncoder;
		$this->grouped = $grouped;
		$this->configurable = $configurable;
		$this->layoutFactory = $layoutFactory;

		parent::__construct($context, $data);
	}

	// Get Key pieces for caching block content

	public function getCacheKeyInfo() {
		return [
			'BRAINVIRE_TASK31_PRODUCT_SLIDER',
			$this->getPriceCurrency()->getCurrency()->getCode(),
			$this->_storeManager->getStore()->getId(),
			$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP),
			$this->getSliderId(),
		];
	}

	protected function _construct() {
		parent::_construct();

		$this->addData([
			'cache_lifetime' => $this->getSlider() ? $this->getSlider()->getTimeCache() : 86400,
			'cache_tags' => [Product::CACHE_TAG],
		]);

		$this->setTemplate('Brainvire_Task31_Product_Slider::productslider.phtml');
	}

	// Get Slider Id

	public function getSliderId() {
		if ($this->getSlider()) {
			return $this->getSlider()->getSliderId();
		}

		return uniqid('-', false);
	}

	// Return data

	public function getHelperData() {
		return $this->_helperData;
	}

	// Get post parameters.

	public function getAddToCartPostParams(Product $product) {
		$url = $this->getAddToCartUrl($product);

		return [
			'action' => $url,
			'data' => [
				'product' => $product->getEntityId(),
				ActionInterface::PARAM_NAME_URL_ENCODED => $this->urlEncoder->encode($url),
			],
		];
	}

	public function canShowPrice() {
		return in_array(Additional::SHOW_PRICE, $this->getDisplayAdditional(), true);
	}

	public function getDisplayAdditional() {
		if ($this->getSlider()) {
			$display = $this->getSlider()->getDisplayAdditional();
		} else {
			$display = $this->_helperData->getModuleConfig('general/display_information');
		}

		if (!is_array($display)) {
			$display = explode(',', $display);
		}

		return $display;
	}

	public function getProductPriceHtml(
		Product $product,
		$priceType = null,
		$renderZone = Render::ZONE_ITEM_LIST,
		array $arguments = []
	) {
		if (!isset($arguments['zone'])) {
			$arguments['zone'] = $renderZone;
		}
		$arguments['price_id'] = isset($arguments['price_id'])
		? $arguments['price_id']
		: 'old-price-' . $product->getId() . '-' . $priceType;
		$arguments['include_container'] = isset($arguments['include_container'])
		? $arguments['include_container']
		: true;
		$arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
		? $arguments['display_minimal_price']
		: true;

		/** @var Render $priceRender */
		$priceRender = $this->getPriceRender();
		if (!$priceRender) {
			$priceRender = $this->getLayout()->createBlock(
				Render::class,
				'product.price.render.default',
				['data' => ['price_render_handle' => 'catalog_product_prices']]
			);
		}

		return $priceRender->render(
			FinalPrice::PRICE_CODE,
			$product,
			$arguments
		);
	}

	protected function getPriceRender() {
		return $this->getLayout()->getBlock('product.price.render.default');
	}

	private function getPriceCurrency() {
		if ($this->priceCurrency === null) {
			$this->priceCurrency = ObjectManager::getInstance()
				->get(PriceCurrencyInterface::class);
		}

		return $this->priceCurrency;
	}

	public function canShowReview() {
		return in_array(Additional::SHOW_REVIEW, $this->getDisplayAdditional(), true);
	}

	public function canShowAddToCart() {
		return in_array(Additional::SHOW_CART, $this->getDisplayAdditional(), true);
	}

	// for Get Slider Title

	public function getTitle() {
		if ($title = $this->hasData('title')) {
			return $this->getData('title');
		}

		if ($this->getSlider()) {
			return $this->getSlider()->getTitle();
		}

		return '';
	}

	// for Get Slider Description

	public function getDescription() {
		if ($this->hasData('description')) {
			return $this->getData('description');
		}

		if ($this->getSlider()) {
			return $this->getSlider()->getDescription();
		}

		return '';
	}

	public function getAllOptions() {
		$sliderOptions = '';
		$allConfig = $this->_helperData->getModuleConfig('slider_design');

		foreach ($allConfig as $key => $value) {
			if ($key === 'item_slider') {
				if (empty($this->getSlider())) {
					$sliderOptions .= $this->_helperData->getResponseValue();
				} else {
					$sliderOptions .= $this->getResponsiveConfig();
				}
			} elseif ($key !== 'responsive') {
				if (in_array($key, ['loop', 'nav', 'dots', 'lazyLoad', 'autoplay', 'autoplayHoverPause'])) {
					$value = $value ? 'true' : 'false';
				}
				$sliderOptions .= $key . ':' . $value . ',';
			}
		}

		return '{' . $sliderOptions . '}';
	}

	/**
	 * @return string
	 */
	public function getResponsiveConfig() {
		$slider = $this->getSlider();
		if ($slider && $slider->getIsResponsive()) {
			try {
				if ($slider->getIsResponsive() === '2') {
					return $this->_helperData->getResponseValue();
				}

				$responsiveConfig = $slider->getResponsiveItems()
				? $this->_helperData->unserialize($slider->getResponsiveItems())
				: [];
			} catch (Exception $e) {
				$responsiveConfig = [];
			}

			if (empty($responsiveConfig)) {
				return '';
			}

			$responsiveOptions = '';
			foreach ($responsiveConfig as $config) {
				if (!empty($config['size']) && !empty($config['items'])) {
					$responsiveOptions .= $config['size'] . ':{items:' . $config['items'] . '},';
				}
			}
			$responsiveOptions = rtrim($responsiveOptions, ',');

			return 'responsive:{' . $responsiveOptions . '}';
		}

		return '';
	}

	// Get End of Day Date

	public function getEndOfDayDate() {
		return $this->_date->date(null, '23:59:59');
	}

	// Get Start of Day Date

	public function getStartOfDayDate() {
		return $this->_date->date(null, '0:0:0');
	}

	// Get Store Id

	public function getStoreId() {
		return $this->_storeManager->getStore()->getId();
	}

	// return array string

	public function getIdentities() {
		$identities = [];
		if ($this->getProductCollection()) {
			foreach ($this->getProductCollection() as $product) {
				if ($product instanceof IdentityInterface) {
					$identities += $product->getIdentities();
				}
			}
		}

		return $identities ?: [Product::CACHE_TAG];
	}

	abstract public function getProductCollection();

	// Get Product Count is displayed

	public function getProductsCount() {
		if ($this->hasData('products_count')) {
			return $this->getData('products_count');
		}

		if ($this->getSlider()) {
			return $this->getSlider()->getLimitNumber() ?: 5;
		}

		return 5;
	}

	public function getProductParentIds($collection) {
		$productIds = [];

		foreach ($collection as $product) {
			if (isset($product->getData()['entity_id'])) {
				$productId = $product->getData()['entity_id'];
			} else {
				$productId = $product->getProductId();
			}

			$parentIdsGroup = $this->grouped->getParentIdsByChild($productId);
			$parentIdsConfig = $this->configurable->getParentIdsByChild($productId);

			if (!empty($parentIdsGroup)) {
				$productIds[] = $parentIdsGroup;
			} elseif (!empty($parentIdsConfig)) {
				$productIds[] = $parentIdsConfig[0];
			} else {
				$productIds[] = $productId;
			}
		}

		return $productIds;
	}

	protected function getDetailsRendererList() {
		if (empty($this->rendererListBlock)) {
			$layout = $this->layoutFactory->create(['cacheable' => false]);
			$layout->getUpdate()->addHandle('catalog_widget_product_list')->load();
			$layout->generateXml();
			$layout->generateElements();

			$this->rendererListBlock = $layout->getBlock('category.product.type.widget.details.renderers');
		}

		return $this->rendererListBlock;
	}
}
