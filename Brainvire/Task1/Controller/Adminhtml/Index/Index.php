<?php

namespace Brainvire\Task1\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action {
	protected $_resultPageFactory;

	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	) {
		$this->_resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}

	public function execute() {
		// echo "Hello";
		// die();
		$resultPage = $this->_resultPageFactory->create();
		return $resultPage;
	}
}