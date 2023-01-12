<?php
namespace Brainvire\Question\Block;

class QA extends \Magento\Framework\View\Element\Template {
	public $testCollection;
	protected $customerSession;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Brainvire\Question\Model\ResourceModel\Faq\CollectionFactory $testCollection,
		\Magento\Framework\Registry $registry,
		\Magento\Customer\Model\Session $customerSession,

		array $data = []
	) {
		$this->customerSession = $customerSession;
		$this->testCollection = $testCollection;
		parent::__construct($context, $data);
		$this->_registry = $registry;
		parent::__construct($context);
	}

	public function getCustomerId() {
		return $this->customerSession->getCustomer()->getId();
		return parent::getCustomerId();
	}

	public function getCustomerName() {
		return $this->customerSession->getCustomer()->getName();
		return parent::getCustomerName();
	}

	public function getCustomerEmail() {
		return $this->customerSession->getCustomer()->getEmail();
		return parent::getCustomerEmail();
	}

	public function getTests() {
		return $collection = $this->testCollection->create()
			->addFieldToFilter('status', 1)
			->addFieldToFilter('product_id', $this->getCurrentProduct()->getId());
	}

	public function getCurrentProduct() {
		return $this->_registry->registry('current_product');
	}
}
