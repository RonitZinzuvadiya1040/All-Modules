<?php
namespace Brainvire\Task37IPRestriction\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RestrictIp extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_restricted_customer_ipaddress', 'restrict_id');
    }
}
