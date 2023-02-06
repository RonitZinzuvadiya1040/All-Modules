<?php

namespace Brainvire\Newmodule\Block;

use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use \Magento\Framework\View\Element\Template;

class ProductSlider extends Template {
	protected $_productCollectionFactory;
	protected $imageHelper;
	protected $_storeManager;
	protected $_bestSellersCollectionFactory;

	public function __construct(
		BestSellersCollectionFactory $bestSellersCollectionFactory,
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Store\Model\StoreManagerInterface $storemanager,
		\Magento\Catalog\Api\ProductRepositoryInterface $productrepository,
		array $data = []
	) {
		$this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
		$this->_storeManager = $storemanager;
		$this->_productCollectionFactory = $productCollectionFactory;
		$this->productrepository = $productrepository;
		parent::__construct($context, $data);
	}

	// public function getProductCollection() {
	// 	$collection = $this->_productCollectionFactory->create();
	// 	$collection->addAttributeToSelect('*');
	// 	return $collection;
	// }

	public function getProductCollection() {
		$productIds = [];
		$bestSellers = $this->_bestSellersCollectionFactory->create()
			->setPeriod('month');
		foreach ($bestSellers as $product) {
			$productIds[] = $product->getProductId();
		}
		$collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
		$collection->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents()
			->addAttributeToSelect('*')
			->addStoreFilter($this->getStoreId())->setPageSize($this->getProductsCount());
		return $collection;
	}

	public function getProductImageUrl($id) {
		$store = $this->_storeManager->getStore();

		$product = $this->productrepository->getById($id);
		$productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getImage();
		return $productImageUrl;
	}
}