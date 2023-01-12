<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Brainvire\Question\Controller\Adminhtml\Faq;

use Brainvire\Question\Helper\Data;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class Save extends \Magento\Backend\App\Action {
	protected $dataPersistor;
	protected $escaper;
	protected $transportBuilder;
	protected $helperData;
	protected $inlineTranslation;

	/**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
		StateInterface $inlineTranslation,
		Escaper $escaper,
		TransportBuilder $transportBuilder,
		Data $helperData
	) {
		$this->dataPersistor = $dataPersistor;
		$this->helperData = $helperData;
		$this->inlineTranslation = $inlineTranslation;
		$this->escaper = $escaper;
		$this->transportBuilder = $transportBuilder;
		parent::__construct($context);
	}

	/**
	 * Save action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute() {
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();
		$data = $this->getRequest()->getPostValue();
		if ($data) {
			$id = $this->getRequest()->getParam('faq_id');

			$model = $this->_objectManager
				->create(\Brainvire\Question\Model\Faq::class)
				->load($id);
			if (!$model->getId() && $id) {
				$this->messageManager->addErrorMessage(
					__('This Faq no longer exists.')
				);
				return $resultRedirect->setPath('*/*/');
			}

			$model->setData($data);
			$status = $data['status'];

			$question = $data['question'];
			$this->question = $question;
			$answer = $data['answer'];
			$this->answer = $answer;

			try {
				$model->save();
				if ($status == 2) {
					$this->helperData->sendReject($data['email']);
				}

				if ($status == 1) {
					$this->sendApprove($data['email']);
				}

				$this->messageManager->addSuccessMessage(
					__('You saved the Faq.')
				);
				$this->dataPersistor->clear('brainvire_question_faq');

				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath('*/*/edit', [
						'faq_id' => $model->getId(),
					]);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (LocalizedException $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
			} catch (\Exception $e) {
				$this->messageManager->addExceptionMessage(
					$e,
					__('Something went wrong while saving the Faq.')
				);
			}

			$this->dataPersistor->set('brainvire_question_faq', $data);
			return $resultRedirect->setPath('*/*/edit', [
				'faq_id' => $this->getRequest()->getParam('faq_id'),
			]);
		}
		return $resultRedirect->setPath('*/*/');
	}

	public function sendApprove($data) {
		try {
			$this->inlineTranslation->suspend();
			$sender =
				[
				'name' => $this->escaper->escapeHtml('Ronit Zinzuvadiya'),
				'email' => $this->escaper->escapehtml('ronit.zinzuvadiya@brainvire.com'),
			];
			$transport = $this->transportBuilder
				->setTemplateIdentifier('question2')
				->setTemplateOptions(
					[
						'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
						'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
					]
				)
				->setTemplateVars([
					'question' => $this->question,
					'answer' => $this->answer,
				])
				->setFrom($sender)
				->addTo($data)
				->getTransport();
			$transport->sendMessage();
			$this->inlineTranslation->resume();
		} catch (Exception $e) {
			$this->logger->debug($e->getMessage());
		}
	}
}
