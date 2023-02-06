<?php

namespace Brainvire\Task31_Product_Slider\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container {

	protected $_coreRegistry;

	public function __construct(
		Registry $coreRegistry,
		Context $context,
		array $data = []
	) {
		parent::__construct($context, $data);

		$this->_coreRegistry = $coreRegistry;
	}

	public function getHeaderText() {
		$slider = $this->getSlider();
		if ($slider->getId()) {
			return __("Edit Slider '%1'", $this->escapeHtml($slider->getName()));
		}

		return __('New Slider');
	}

	public function getSlider() {
		return $this->_coreRegistry->registry('brainvire_task31_product_slider');
	}

	protected function _construct() {
		$this->_objectId = 'id';
		$this->_blockGroup = 'Brainvire_Task31_Product_Slider';
		$this->_controller = 'adminhtml_slider';

		parent::_construct();

		$this->buttonList->add(
			'save-and-continue',
			[
				'label' => __('Save and Continue Edit'),
				'class' => 'save',
				'data_attribute' => [
					'mage-init' => [
						'button' => [
							'event' => 'saveAndContinueEdit',
							'target' => '#edit_form',
						],
					],
				],
			],
			-100
		);

		$this->_formScripts[] = "
        require(['jquery'], function ($){
            $('#slider_product_type').on('change', function(){
                showHideProductTab();
            });
            showHideProductTab();

            function showHideProductTab(){
                if($('#slider_product_type').val() == 'custom'){
                    $('#slider_tabs_products').show();
                } else {
                    $('#slider_tabs_products').hide();
                }
            }
        });
        ";
	}
}
