<?php
namespace Brainvire\Question\Model;
use Brainvire\Question\Model\ResourceModel\Test as TestResourceModel;
use Magento\Framework\Model\AbstractModel;

class Test extends \Magento\Framework\Model\AbstractModel {
	protected function _construct() {
		$this->_init(TestResourceModel::class);
	}
}