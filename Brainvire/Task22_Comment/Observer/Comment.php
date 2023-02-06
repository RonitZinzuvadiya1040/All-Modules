<?php
namespace Brainvire\Task22_Comment\Observer;
use Magento\Framework\Event\ObserverInterface;

class Comment implements ObserverInterface {
	public function __construct(
		\Magento\Framework\App\ResourceConnection $resource
	) {
		$this->_resource = $resource;
	}
	public function execute(\Magento\Framework\Event\Observer $observer) {
		$comment = $observer->getEvent()->getDataObject();
		$connection = $this->_resource;
		$tableName = $connection->getTableName('customer_address_entity');
		$detail = [
			'comment' => $comment->getComment(),
		];

		$select = $connection->getConnection()->select()->from($tableName)->where('parent_id = :parent_id');
		$commentId = $connection->getConnection()->fetchOne($select, [':parent_id' => $comment->getId()]);

	}
}