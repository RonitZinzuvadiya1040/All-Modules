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
use Magento\Reports\Block\Product\Viewed as ReportProductViewed;

// Class RecentProducts

class RecentProducts extends AbstractSlider {

	protected $reportProductViewed;

	public function __construct(
		Context $context,
		CollectionFactory $productCollectionFactory,
		Visibility $catalogProductVisibility,
		DateTime $dateTime,
		Data $helperData,
		HttpContext $httpContext,
		EncoderInterface $urlEncoder,
		ReportProductViewed $reportProductViewed,
		Grouped $grouped,
		Configurable $configurable,
		LayoutFactory $layoutFactory,
		array $data = []
	) {
		$this->reportProductViewed = $reportProductViewed;

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

	// Get Collection for Recently Viewed product

	public function getProductCollection() {
		return $this->reportProductViewed->getItemsCollection()->setPageSize($this->getProductsCount());
	}
}
