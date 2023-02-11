<?php

namespace Brainvire\Task1\Model\ResourceModel\Task1;

use Brainvire\Task1\Model as TestModel;
use Brainvire\Task1\Model\ResourceModel as TestResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(TestModel::class, TestResourceModel::class);
	}
}
