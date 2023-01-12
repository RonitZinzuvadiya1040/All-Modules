<?php
namespace Brainvire\Question\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Test extends AbstractDb {

	protected function _construct() {
		$this->_init('question_answer', 'id');
	}
}