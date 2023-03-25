<?php
namespace Brainvire\Task5OrderProcessingFeesToCart\Block\Sales\Order;

class Fee extends \Magento\Framework\View\Element\Template {

	protected $_dataHelper;

	/**
	 * @var Order
	 */
	protected $_order;

	/**
	 * @var \Magento\Framework\DataObject
	 */
	protected $_source;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Brainvire\Task5OrderProcessingFeesToCart\Helper\Data $dataHelper,
		array $data = []
	) {
		$this->_dataHelper = $dataHelper;
		parent::__construct($context, $data);
	}

	/**
	 * Check if we need display full tax total info
	 *
	 * @return bool
	 */
	public function displayFullSummary() {
		return true;
	}

	/**
	 * Get data (totals) source model
	 *
	 * @return \Magento\Framework\DataObject
	 */
	public function getSource() {
		return $this->_source;
	}

	public function getStore() {
		return $this->_order->getStore();
	}

	/**
	 * @return Order
	 */
	public function getOrder() {
		return $this->_order;
	}

	/**
	 * @return array
	 */
	public function getLabelProperties() {
		return $this->getParentBlock()->getLabelProperties();
	}

	/**
	 * @return array
	 */
	public function getValueProperties() {
		return $this->getParentBlock()->getValueProperties();
	}

	/**
	 * @return $this
	 */
	public function initTotals() {
		$parent = $this->getParentBlock();
		$this->_order = $parent->getOrder();
		$this->_source = $parent->getSource();
		// $store = $this->getStore();

		$fee = new \Magento\Framework\DataObject(
			[
				'code' => 'processing_fee',
				'strong' => false,
				'value' => $this->_source->getProcessingFee(),
				'label' => __('Processing Fee'),
			]
		);

		$parent->addTotal($fee, 'processing_fee');

		return $this;
	}

}
