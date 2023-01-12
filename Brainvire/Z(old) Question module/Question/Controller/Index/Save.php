<?php
namespace Brainvire\Question\Controller\Index;

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

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Brainvire\Question\Model\TestFactory $testFactory,
		StateInterface $inlineTranslation,
		Escaper $escaper,
		TransportBuilder $transportBuilder
	) {
		$this->_pageFactory = $pageFactory;
		$this->testFactory = $testFactory;
		$this->inlineTranslation = $inlineTranslation;
		$this->escaper = $escaper;
		$this->transportBuilder = $transportBuilder;
		return parent::__construct($context);
	}

	public function execute() {
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		if ($this->getRequest()->isPost()) {
			$input = $this->getRequest()->getPostValue();
			// echo "<pre>";
			// print_r($input);
			// die;
			$postData = $this->testFactory->create();
			if (isset($input['id'])) {
				$id = $input['id'];
			} else {
				$id = 0;
			}
			if ($id != 0) {
				$postData->load($id);
				$postData->addData($input);
				$postData->setId($id);
				$postData->save();
			} else {
				$postData->setData($input)->save();
				// $this->sendEmail($input['Email']);
			}
			$this->messageManager->addSuccessMessage("Data Sent successfully");
			$resultRedirect->setUrl($this->_redirect->getRefererUrl());
			return $resultRedirect;
		}
		// $this->messageManager->addSuccessMessage("Email Sent successfully");
		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
		return $resultRedirect;
	}

	// public function sendEmail($Email)
	// {
	//     try {
	//         $this->inlineTranslation->suspend();
	//         $sender =
	//         [
	//                 'name' => $this->escaper->escapeHtml('Test'),
	//                 'email' =>$this->escaper->escapehtml('umorgodfather9x02@gmail.com'),
	//         ];
	//         $transport = $this->transportBuilder
	//             ->setTemplateIdentifier('email_section_sendmail_email_template')
	//             ->setTemplateOptions(
	//                 [
	//                     'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
	//                     'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
	//                 ]
	//             )
	//             ->setTemplateVars([
	//                 'templateVar'  => 'My Topic',
	//             ])
	//             ->setFrom($sender)
	//             ->addTo($Email)
	//             ->getTransport();
	//             $transport->sendMessage();
	//             $this->inlineTranslation->resume();
	//     } catch (Exception $e) {
	//         $this->logger->debug($e->getMessage());
	//     }
	// }
}
