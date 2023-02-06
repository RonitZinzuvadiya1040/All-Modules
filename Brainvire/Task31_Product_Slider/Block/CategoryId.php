<?php

namespace Brainvire\Task31_Product_Slider\Block;

use Brainvire\Task31_Product_Slider\Helper\Data;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\GroupedProduct\Model\Product\Type\Grouped;

class CategoryId extends AbstractSlider {

	protected $_categoryFactory;

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		CategoryFactory $categoryFactory,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		$this->_categoryFactory = $categoryFactory;

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

	// Get Product Collection by Category Ids

	public function getProductCollection() {
		$productIds = $this->getProductIdsByCategory();
		$collection = [];
		if (!empty($productIds)) {
			$collection = $this->_productCollectionFactory->create()
				->addIdFilter(array('in' => $productIds));
			$this->_addProductAttributesAndPrices($collection);
		}

		return $collection;
	}

	// Get ProductIds by Category

	public function getProductIdsByCategory() {
		$productIds = [];
		$catIds = $this->getSliderCategoryIds();

		if (is_array($catIds)) {
			$productId = [];

			foreach ($catIds as $cat) {
				$collection = $this->_productCollectionFactory->create();
				$category = $this->_categoryFactory->create()->load($cat);
				$collection->addAttributeToSelect('*')->addCategoryFilter($category);

				foreach ($collection as $item) {
					$productId[] = $item->getData('entity_id');
				}

				$productIds = array_merge($productIds, $productId);
			}
		} else {
			$collection = $this->_productCollectionFactory->create();
			$category = $this->_categoryFactory->create()->load($catIds);
			$collection->addAttributeToSelect('*')->addCategoryFilter($category);

			foreach ($collection as $item) {
				$productIds[] = $item->getData('entity_id');
			}
		}

		$keys = array_keys($productIds);
		shuffle($keys);
		$productIdsRandom = [];

		foreach ($keys as $key => $value) {
			$productIdsRandom[] = $productIds[$value];

			if ($key >= ($this->getProductsCount() - 1)) {
				break;
			}
		}

		return $productIdsRandom;
	}

	// Get Slider CategoryIds

	public function getSliderCategoryIds() {
		if ($this->getData('category_id')) {
			return $this->getData('category_id');
		}
		if ($this->getSlider()) {
			return explode(',', $this->getSlider()->getCategoriesIds());
		}

		return 2;
	}
}