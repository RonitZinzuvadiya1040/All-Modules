<?php
namespace Brainvire\Question\Controller\Index;

use Brainvire\Question\Helper\Data;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class Save extends \Magento\Framework\App\Action\Action {
	protected $_pageFactory;
	protected $_contactFactory;
	protected $inlineTranslation;
	protected $escaper;
	protected $transportBuilder;
	protected $helperData;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Brainvire\Question\Model\FaqFactory $faqFactory,
		StateInterface $inlineTranslation,
		Escaper $escaper,
		Data $helperData,
		TransportBuilder $transportBuilder

	) {
		$this->_pageFactory = $pageFactory;
		$this->faqFactory = $faqFactory;
		$this->inlineTranslation = $inlineTranslation;
		$this->escaper = $escaper;
		$this->transportBuilder = $transportBuilder;
		$this->helperData = $helperData;
		return parent::__construct($context);
	}

	public function execute() {
		// $this->validatedParams();
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		if ($this->getRequest()->isPost()) {
			$request = $this->getRequest()->getPostValue();
			// echo "<pre>";
			// print_r($request);
			// die;
			$postData = $this->faqFactory->create();
			if (isset($request['faq_id'])) {
				$id = $request['faq_id'];
			} else {
				$id = 0;
			}
			if ($id != 0) {
				$postData->load($id);
				$postData->addData($request);
				$postData->setId($id);
				$postData->save();
			} else {
				$postData->setData($request)->save();
				$this->helperData->sendEmail($request['email']);
			}
			// $this->messageManager->addSuccessMessage("Data Sent successfully");
			$resultRedirect->setUrl($this->_redirect->getRefererUrl());
			return $resultRedirect;
		}
		$this->messageManager->addSuccessMessage("Data Sent successfully");
		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
		return $resultRedirect;
	}
	// private function validatedParams() {
	// 	$request = $this->getRequest();
	// 	if (trim($request->getParam('name')) == '') {
	// 		throw new LocalizedException(__('Name is missing'));
	// 	}
	// 	if (false === \strpos($request->getParam('email'), '@')) {
	// 		throw new LocalizedException(__('Invalid Email address'));
	// 	}

	// 	if (trim($request->getParam('question')) == '') {
	// 		throw new LocalizedException(__('Question is missing'));
	// 	}
	// 	//Add your more validations here
	// 	return $request->getParams();
	// }
}