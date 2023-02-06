<?php

namespace Brainvire\Task31_Product_Slider\Block\Widget;

use Brainvire\Task31_Product_Slider\Block\AbstractSlider;
use Brainvire\Task31_Product_Slider\Helper\Data;
use Brainvire\Task31_Product_Slider\Model\Config\Source\ProductType;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\GroupedProduct\Model\Product\Type\Grouped;

class Slider extends AbstractSlider {

	const DISPLAY_TYPE_NEW_PRODUCTS = 'new';

	protected $_template = "Mageplaza_Productslider::widget/productslider.phtml";

	protected $productType;

	// Slider constructor.

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		ProductType $productType,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		parent::__construct(
			$context,
			$productCollectionFactory,
			$catalogProductVisibility,
			$dateTime,
			$helperData,
			$httpContext,
			$urlEncoder,
			$grouped,
			$configurable,
			$layoutFactory,
			$data
		);
		$this->productType = $productType;
	}

	public function _construct() {
		parent::_construct();

		$this->setTemplate('Mageplaza_Productslider::widget/productslider.phtml');
	}

	public function getProductCollection() {
		$collection = [];

		if ($this->hasData('product_type')) {
			$productType = $this->getData('product_type');

			$collection = $this->getLayout()->createBlock($this->productType->getBlockMap($productType))
				->getProductCollection();
			if ($collection && $collection->getSize()) {
				$collection->setPageSize($this->getPageSize())->setCurPage($this->getCurrentPage());
			}
		}

		return $collection;
	}

	// Retrieve how many products should be displayed on page

	protected function getPageSize() {
		return $this->getProductsCount();
	}

	public function getProductsCount() {
		return $this->getData('products_count') ?: 10;
	}

	// for get current page number

	public function getCurrentPage() {
		return abs((int) $this->getRequest()->getParam($this->getData('page_var_name')));
	}

	public function getCacheKeyInfo() {
		$params = $this->_helperData->serialize($this->getRequest()->getParams());

		return array_merge(
			parent::getCacheKeyInfo(),
			[
				$this->getData('page_var_name'),
				(int) $this->getRequest()->getParam($this->getData('page_var_name'), 1),
				$params,
			]
		);
	}

	/**
	 * @return bool|mixed
	 */

	public function getDisplayAdditional() {
		$display = $this->_helperData->getModuleConfig('general/display_information');
		if (!is_array($display)) {
			$display = explode(',', $display);
		}

		return $display;
	}

	// Retrieve display type for products

	public function getDisplayType() {
		if (!$this->hasData('product_type')) {
			$this->setData('product_type', self::DISPLAY_TYPE_NEW_PRODUCTS);
		}

		return $this->getData('product_type');
	}

	public function getTitle() {
		return $this->getData('title');
	}

	// Retrieve all configuration options for product slider

	public function getAllOptions() {
		return $this->_helperData->getAllOptions();
	}
}
