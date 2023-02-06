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

// Class OnSaleProduct

class OnSaleProduct extends AbstractSlider {

	protected $_dateTimeStore;

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
		$this->_dateTimeStore = $dateTime;
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

	public function getProductCollection() {
		$productCollection = $this->_productCollectionFactory->create();
		$productCollection
			->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents()
			->addStoreFilter($this->getStoreId())
			->addAttributeToSelect('special_from_date')
			->addAttributeToSelect('special_to_date')
			->addAttributeToFilter('special_price', ['gt' => 0])
			->addAttributeToSort(
				'minimal_price',
				'asc'
			)
			->setPageSize($this->getProductsCount());

		$productCollection->getSelect()->where(
			'price_index.final_price < price_index.price'
		);

		$productIds = $this->getProductParentIds($productCollection);
		$productCollection = $this->_productCollectionFactory->create()->addIdFilter($productIds);

		$productCollection->addAttributeToFilter('visibility', ['neq' => 1])
			->addAttributeToFilter('status', 1)
			->addStoreFilter($this->getStoreId())
			->setPageSize($this->getProductsCount());
		$this->_addProductAttributesAndPrices($productCollection);

		return $productCollection;
	}
}
