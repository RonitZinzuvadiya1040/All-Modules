<?php

namespace Brainvire\Task31_Product_Slider\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Exception\LocalizedException;

class Form extends Generic {
	/**
	 * @return $this
	 * @throws LocalizedException
	 */
	protected function _prepareForm() {
		/** @var \Magento\Framework\Data\Form $form */
		$form = $this->_formFactory->create(
			[
				'data' => [
					'id' => 'edit_form',
					'action' => $this->getUrl('*/*/save', ['id' => $this->getRequest()->getParam('id')]),
					'method' => 'post',
					'enctype' => 'multipart/form-data',
				],
			]
		);
		$form->setUseContainer(true);
		$this->setForm($form);

		return parent::_prepareForm();
	}
}
