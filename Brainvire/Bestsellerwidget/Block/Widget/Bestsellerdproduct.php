<?php
namespace Brainvire\Bestsellerwidget\Block\Widget;
class Bestsellerdproduct extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {
	protected $_template = 'widget/bestsellerdproduct.phtml';

	const DEFAULT_PRODUCTS_COUNT = 10;
	const DEFAULT_IMAGE_WIDTH = 150;
	const DEFAULT_IMAGE_HEIGHT = 150;

	protected $productsCount;

	protected $httpContext;
	protected $resourceCollection;
	protected $productloader;
	protected $resourceFactory;

	protected $catalogProductVisibility;
	protected $productCollectionFactory;
	protected $imageHelper;
	protected $cartHelper;

	public function __construct(
		\Magento\Catalog\Block\Product\Context $context,
		\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
		\Magento\Reports\Model\Grouped\CollectionFactory $collectionFactory,
		\Magento\Reports\Helper\Data $reportsData,
		\Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $resourceCollection,
		\Magento\Catalog\Model\ProductFactory $productloader,
		array $data = []
	) {
		$this->resourceFactory = $resourceFactory;
		$this->_collectionFactory = $collectionFactory;
		$this->_reportsData = $reportsData;
		$this->imageHelper = $context->getImageHelper();
		$this->productloader = $productloader;
		$this->cartHelper = $context->getCartHelper();
		$this->resourceCollection = $resourceCollection;
		parent::__construct($context, $data);
	}

	public function imageHelperObj() {
		return $this->imageHelper;
	}

	public function getBestsellerProduct() {
		$limit = $this->getProductLimit();
		$resourceCollection = $this->resourceCollection->create();
		$resourceCollection->setPageSize($limit);
		return $resourceCollection;
	}

	public function getProductLimit() {
		if ($this->getData('productcount') == '') {
			return DEFAULT_PRODUCTS_COUNT;
		}
		return $this->getData('productcount');
	}

	public function getProductimagewidth() {
		if ($this->getData('imagewidth') == '') {
			return DEFAULT_IMAGE_WIDTH;
		}
		return $this->getData('imagewidth');
	}

	public function getProductimageheight() {
		if ($this->getData('imageheight') == '') {
			return DEFAULT_IMAGE_HEIGHT;
		}
		return $this->getData('imageheight');
	}

	public function getAddToCartUrl($product, $additional = []) {
		return $this->cartHelper->getAddUrl($product, $additional);
	}

	public function getProductPriceHtml(
		\Magento\Catalog\Model\Product $product,
		$priceType = null,
		$renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
		array $arguments = []
	) {
		if (!isset($arguments['zone'])) {
			$arguments['zone'] = $renderZone;
		}
		$arguments['zone'] = isset($arguments['zone'])
		? $arguments['zone']
		: $renderZone;
		$arguments['price_id'] = isset($arguments['price_id'])
		? $arguments['price_id']
		: 'old-price-' . $product->getId() . '-' . $priceType;
		$arguments['include_container'] = isset($arguments['include_container'])
		? $arguments['include_container']
		: true;
		$arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
		? $arguments['display_minimal_price']
		: true;
		/** @var \Magento\Framework\Pricing\Render $priceRender */
		$priceRender = $this->getLayout()->getBlock('product.price.render.default');
		$price = '';
		if ($priceRender) {
			$price = $priceRender->render(
				\Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
				$product,
				$arguments
			);
		}
		return $price;
	}
	public function loadProduct($id) {
		return $this->productloader->create()->load($id);
	}
}