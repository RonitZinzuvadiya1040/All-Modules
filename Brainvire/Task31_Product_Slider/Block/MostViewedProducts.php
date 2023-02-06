<?php

namespace Brainvire\Task31_Product_Slider\Block;

use Brainvire\Task31_Product_Slider\Helper\Data;
use Brainvire\Task31_Product_Slider\Model\ResourceModel\Report\Product\CollectionFactory as MostViewedCollectionFactory;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\GroupedProduct\Model\Product\Type\Grouped;

// Class MostViewedProducts

class MostViewedProducts extends AbstractSlider {

	protected $_mostViewedProductsFactory;

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		MostViewedCollectionFactory $mostViewedProductsFactory,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		$this->_mostViewedProductsFactory = $mostViewedProductsFactory;

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
	}

	// collection of most viewed product

	public function getProductCollection() {
		$collection = $this->_mostViewedProductsFactory->create()
			->setStoreId($this->getStoreId())->addViewsCount()
			->addStoreFilter($this->getStoreId())
			->setPageSize($this->getProductsCount());

		$productIds = $this->getProductParentIds($collection);

		$collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
		$collection->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents()
			->addAttributeToSelect('*')
			->addStoreFilter($this->getStoreId());

		return $collection;
	}
}