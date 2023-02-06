<?php

namespace Brainvire\Task31_Product_Slider\Block\Adminhtml\Slider\Edit\Tab\Renderer;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Escaper;
use Magento\Framework\View\LayoutInterface;

class Responsive extends AbstractElement {

	protected $layout;

	public function __construct(
		Factory $factoryElement,
		CollectionFactory $factoryCollection,
		Escaper $escaper,
		LayoutInterface $layout,
		array $data = []
	) {
		$this->layout = $layout;

		parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
	}

	/**
	 * @return string
	 */
	public function getElementHtml() {
		$html = '<div id="' . $this->getHtmlId() . '">';
		$html .= $this->layout->createBlock(\Brainvire\Task31_Product_Slider\Block\Adminhtml\Config\Field\Responsive::class)
			->setElement($this)
			->toHtml();
		$html .= '</div>';

		return $html;
	}
}
