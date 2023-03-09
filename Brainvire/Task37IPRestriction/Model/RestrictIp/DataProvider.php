<?php
namespace Brainvire\Task37IPRestriction\Model\RestrictIp;

use Brainvire\Task37IPRestriction\Model\ResourceModel\RestrictIp\CollectionFactory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $restrictedIpCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $restrictedIpCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        
        /** @var Customer $customer */
        foreach ($items as $restrictedIp) {
            $this->loadedData[$restrictedIp->getId()]['restrictedIp'] = $restrictedIp->getData();
        }

        return $this->loadedData;

    }
}
