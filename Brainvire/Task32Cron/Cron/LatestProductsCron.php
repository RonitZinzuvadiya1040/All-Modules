<?php
namespace Brainvire\Task32Cron\Cron;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\CategoryManagementInterface;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class LatestProductsCron
{    
    protected $_productCollectionFactory;

    public function __construct(
        CollectionFactory $productCollectionFactory,
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryManagementInterface $categoryManagement,
        CategoryRepositoryInterface $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryManagement = $categoryManagement;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }
    
    public function execute()
    {
        $this->logger->info('Cron Start'); // Get entry in system.log to check cron start working
        $category = $this->categoryRepository->getCategory(); // get category id=42 where our 10 recently added product will store.
        // $category = $this->categoryRepository->get(42); // get category id=42 where our 10 recently added product will store.
        $product_count = $category->getProductCollection()->Count(); // Store Total count of product for category id=42 in $product_count.

        $create = $this->_productCollectionFactory->create()->getCreatedAt();

        $collection = $this->_productCollectionFactory->create()->addFieldToFilter('created_at', ['gt' => date("Y-m-d H:i:s", strtotime('-3 day'))]);
            // 2 condition aapvani jo last 3 day ma product na hoy to biji condition run karavani
            // $categoryId = [42]; // perticular category id where our 10 recently added product will store.
            $categoryId = $category; // all category id where our 10 recently added product will store.
            $collection->addAttributeToSelect('*'); // for get collection of sku, name etc.. of category 42.

        foreach ($collection as $product) {
            if ($product_count < 11) {  // for get recent 10 products 
                $hasProductAssignedSuccess = $this->categoryLinkManagement
                    ->assignProductToCategories( // for get sku of recent 10 product and added to category where category id is 42.
                        $product->getSku(), //get sku of product and category id.
                        $categoryId
                    );
            }

        }

        if($collection->getSize() == 0)
        {
            $collection2 = $this->_productCollectionFactory->create()->addFieldToFilter('created_at', ['gt' => date("Y-m-d H:i:s", strtotime('-6 day'))]);
            // if no product found for last 3 thay check then it for last 6 days product 
            // 2 condition aapvani jo last 3 day ma product na hoy to biji condition run karavani
            // $categoryId = [42]; // category id where our 10 recently added product will store.
            $categoryId = $category; // category id where our 10 recently added product will store.
            $collection2->addAttributeToSelect('*'); // for get collection of sku, name etc.. of category 42.

            foreach ($collection2 as $product) {
                if ($product_count < 11) {  // for get recent 10 products 

                    $hasProductAssignedSuccess = $this->categoryLinkManagement
                        ->assignProductToCategories( // for get sku of recent 10 product and added to category where category id is 42.
                            $product->getSku(), //get sku of product and category id.
                            $categoryId
                        );
                }
            }
        }

        $this->logger->info('Cron End'); // Get entry in system log to check cron terminated
        return $this;
    }
}