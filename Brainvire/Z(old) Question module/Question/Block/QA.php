<?php
namespace Brainvire\Question\Block;

class QA extends \Magento\Framework\View\Element\Template {
	public $testCollection;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Brainvire\Question\Model\ResourceModel\Test\CollectionFactory $testCollection,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {
		$this->testCollection = $testCollection;
		parent::__construct($context, $data);
		$this->_registry = $registry;
		parent::__construct($context);
	}

	public function getTests() {
		return $this->testCollection->create();
	}

	public function getCurrentProduct() {
		return $this->_registry->registry('current_product');
	}

}