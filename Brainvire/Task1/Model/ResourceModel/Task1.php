<?php

namespace Brainvire\Task1\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Task1 extends AbstractDb {

	protected function _construct() {
		$this->_init('sales_order', 'entity_id');
	}
}
