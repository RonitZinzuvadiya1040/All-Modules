<?php
namespace Brainvire\Question\Model\ResourceModel\Test;
use Brainvire\Question\Model\ResourceModel\Test as TestResourceModel;
use Brainvire\Question\Model\Test as TestModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(TestModel::class, TestResourceModel::class);
	}
}