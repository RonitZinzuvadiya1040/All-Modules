<?php

declare (strict_types = 1);

namespace Brainvire\Task1\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action {
	// const ADMIN_RESOURCE = 'Brainvire_Question::faq_view';

	protected $resultPageFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		$this->resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}

	public function execute() {
		// die();
		$resultPage = $this->resultPageFactory->create();
		$resultPage
			->getConfig()
			->getTitle()
			->prepend(__("Sales Report"));
		return $resultPage;
	}
}
