<?php
namespace Brainvire\Task37IPRestriction\Model\ResourceModel\RestrictIp;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Brainvire\Task37IPRestriction\Model\RestrictIp as Model;
use Brainvire\Task37IPRestriction\Model\ResourceModel\RestrictIp as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * 
     * @param void
     * @return null 
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
