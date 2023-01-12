<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Brainvire\Question\Controller\Adminhtml;

abstract class Faq extends \Magento\Backend\App\Action {
	protected $_coreRegistry;
	const ADMIN_RESOURCE = 'Brainvire_Question::top_level';

	/**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\Registry $coreRegistry
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\Registry $coreRegistry
	) {
		$this->_coreRegistry = $coreRegistry;
		parent::__construct($context);
	}

	/**
	 * Init page
	 *
	 * @param \Magento\Backend\Model\View\Result\Page $resultPage
	 * @return \Magento\Backend\Model\View\Result\Page
	 */
	public function initPage($resultPage) {
		$resultPage
			->setActiveMenu(self::ADMIN_RESOURCE)
			->addBreadcrumb(__('Brainvire'), __('Brainvire'))
			->addBreadcrumb(__('Faq'), __('Faq'));
		return $resultPage;
	}
}
