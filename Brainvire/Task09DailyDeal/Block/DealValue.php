<?php
namespace Brainvire\Task09DailyDeal\Block;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class DealValue extends Template {

	protected $_objectManager;

	protected $_registry;

	public function __construct(
		Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {
		parent::__construct($context, $data);
		$this->_objectManager = $objectManager;
		$this->_registry = $registry;
	}

	public function getCurrentProduct() {
		return $this->_registry->registry('current_product');
	}

	public function getAttributevalue() {
		$current_prod = $this->_registry->registry('current_product');
		return $current_prod->getcustom_dealtime();

	}
}
