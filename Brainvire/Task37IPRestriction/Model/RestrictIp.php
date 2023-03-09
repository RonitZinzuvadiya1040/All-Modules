<?php
namespace Brainvire\Task37IPRestriction\Model;

use Magento\Framework\Model\AbstractModel;
use Brainvire\Task37IPRestriction\Model\ResourceModel\RestrictIp as ResourceModel;

class RestrictIp extends AbstractModel
{
    /**
     * 
     * @param void
     * @return null 
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}