<?php

namespace Brainvire\Question\Model\ResourceModel\Faq;

use Brainvire\Question\Model\Faq as TestModel;
use Brainvire\Question\Model\ResourceModel\Faq as TestResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(TestModel::class, TestResourceModel::class);
	}
}
