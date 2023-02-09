<?php

namespace Brainvire\Task1\Model\ResourceModel\Index;

use Brainvire\Task1\Model\Index as TestModel;
use Brainvire\Task1\Model\ResourceModel\Index as TestResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(TestModel::class, TestResourceModel::class);
	}
}
