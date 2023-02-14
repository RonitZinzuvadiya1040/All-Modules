<?php

namespace Brainvire\Task1\Block\Adminhtml;

class Index extends \Magento\Backend\Block\Widget\Grid\Container {
	protected function _construct() {
		$this->_controller = 'adminhtml_index';
		$this->_blockGroup = 'Brainvire_Task1';
		$this->_headerText = __('Index');
		parent::_construct();
		if ($this->_isAllowedAction('Brainvire_Task1::save')) {
		} else {
			$this->buttonList->remove('add');
		}
	}
	protected function _isAllowedAction($resourceId) {
		return $this->_authorization->isAllowed($resourceId);
	}
}