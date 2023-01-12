<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Brainvire\Question\Controller\Adminhtml\Faq;
use Brainvire\Question\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

class Massdelete extends \Magento\Backend\App\Action {
	/**
	 * @var Filter
	 */
	protected $filter;
	/**
	 * @var CollectionFactory
	 */
	protected $collectionFactory;
	/**
	 * @param Context           $context
	 * @param Filter            $filter
	 * @param CollectionFactory $collectionFactory
	 */
	public function __construct(
		Context $context,
		Filter $filter,
		CollectionFactory $collectionFactory
	) {
		$this->filter = $filter;
		$this->collectionFactory = $collectionFactory;
		parent::__construct($context);
	}
	/**
	 * Execute action
	 *
	 * @return \Magento\Backend\Model\View\Result\Redirect
	 * @throws \Magento\Framework\Exception\LocalizedException|\Exception
	 */
	public function execute() {
		$collection = $this->filter->getCollection($this->collectionFactory->create());
		$collectionSize = $collection->getSize();
		foreach ($collection as $item) {
			$item->delete();
		}
		$this->messageManager->addSuccess(__('A total of %1 element(s) have been deleted.', $collectionSize));
		// @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		return $resultRedirect->setPath('*/*/');
	}
}