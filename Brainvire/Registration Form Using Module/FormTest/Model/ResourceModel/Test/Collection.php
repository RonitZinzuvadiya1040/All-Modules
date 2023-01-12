<?php
namespace Brainvire\FormTest\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    
    public function _construct()
    {
        $this->_init(
            \Brainvire\FormTest\Model\Test::class,
            \Brainvire\FormTest\Model\ResourceModel\Test::class
        );
        $this->_map['fields']['id'] = 'main_table.id';
    }
}