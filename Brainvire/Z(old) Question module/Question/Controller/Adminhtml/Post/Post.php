<?php
namespace Mageplaza\UiForm\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Post extends Action {
	protected $_resultPageFactory;

	public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	) {
		$this->_resultPageFactory = $resultPageFactory;
		parent::__construct($context);
	}

	public function execute() {
		$resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
		return $resultPage;
	}
}