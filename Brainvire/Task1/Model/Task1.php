<?php
namespace Brainvire\Task1\Model;

use Brainvire\Task1\Model\ResourceModel\Task1 as TestResourceModel;
use Magento\Framework\Model\AbstractModel;

class Task1 extends \Magento\Framework\Model\AbstractModel {
	protected function _construct() {
		$this->_init(TestResourceModel::class);
	}
}