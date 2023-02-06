<?php

namespace Brainvire\Task31_Product_Slider\Block;

use Brainvire\Task31_Product_Slider\Helper\Data;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;

class BestSellerProducts extends AbstractSlider {

	protected $_bestSellersCollectionFactory;

	// BestSellerProducts constructor.

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		BestSellersCollectionFactory $bestSellersCollectionFactory,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		$this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;

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

	// get collection of best-seller products

	public function getProductCollection() {
		$bestSellers = $this->_bestSellersCollectionFactory->create()
			->setModel('Magento\Catalog\Model\Product')
			->addStoreFilter($this->getStoreId())
			->setPeriod('month');

		$productIds = $this->getProductParentIds($bestSellers);
		if (empty($productIds)) {
			return null;
		}

		$collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
		$collection->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents()
			->addAttributeToSelect($this->_catalogConfig->getProductAttributes())
			->addStoreFilter($this->getStoreId())
			->addUrlRewrite()
			->setVisibility($this->_catalogProductVisibility->getVisibleInSiteIds())
			->setPageSize($this->getProductsCount());

		return $collection;
	}
}
