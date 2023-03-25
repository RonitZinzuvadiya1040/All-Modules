<?php
namespace Brainvire\Task5OrderProcessingFeesToCart\Model\Total;
use Brainvire\Task5OrderProcessingFeesToCart\Helper\Data;
use Magento\Checkout\Model\Cart as CustomerCart;

class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal {

	protected $quoteValidator = null;

	public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator, Data $helper, CustomerCart $cart,
		\Magento\Checkout\Model\Session $cartSession) {
		$this->quoteValidator = $quoteValidator;
		$this->helper = $helper;
		$this->cart = $cart;
		$this->cartSession = $cartSession;
	}

	public function collect(
		\Magento\Quote\Model\Quote $quote,
		\Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
		\Magento\Quote\Model\Quote\Address\Total $total
	) {
		parent::collect($quote, $shippingAssignment, $total);

		$fee = $this->helper->getfeeinpercentage();
		$totals = $this->cart->getQuote()->getTotals();
		$subtotal = $totals['subtotal']['value'];

		$processfee = ($subtotal * $fee) / 100;
		$balance = $processfee;
		$this->cartSession->setProcessingFee($balance);
		$total->setTotalAmount('processing_fee', $balance);
		$total->setBaseTotalAmount('processing_fee', $balance);
		$total->setProcessingFee($balance);
		$total->setBaseProcessingFee($balance);
		$quote->setProcessingFee($balance);
		$quote->setBaseProcessingFee($balance);

		$quote->setHasProcessingFee(0);
		$total->setHasProcessingFee(0);
		if ($balance > 0) {
			$quote->setHasProcessingFee(1);
			$total->setHasProcessingFee(1);
		}

		$total->setGrandTotal($total->getGrandTotal());
		$total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

		return $this;
	}

	protected function clearValues(Address\Total $total) {
		$total->setTotalAmount('subtotal', 0);
		$total->setBaseTotalAmount('subtotal', 0);
		$total->setTotalAmount('tax', 0);
		$total->setBaseTotalAmount('tax', 0);
		$total->setTotalAmount('discount_tax_compensation', 0);
		$total->setBaseTotalAmount('discount_tax_compensation', 0);
		$total->setTotalAmount('shipping_discount_tax_compensation', 0);
		$total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
		$total->setSubtotalInclTax(0);
		$total->setBaseSubtotalInclTax(0);
	}

	public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total) {
		// $new = $this->cartSession->getProcessingFee();
		// print_r($new);
		return [
			'code' => 'processing_fee',
			'title' => 'Processing Fee',
			'value' => $this->cartSession->getProcessingFee(),
			// 'value' => 50,
		];
	}

	public function getLabel() {
		return __('Processing Fee');
	}
}