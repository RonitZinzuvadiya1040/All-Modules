<?php
namespace Brainvire\Task5OrderProcessingFeesToCart\Plugin\Model;

class ShippingInformationManagement {

	protected $quoteRepository;

	protected $dataHelper;

	public function __construct(
		\Magento\Quote\Model\QuoteRepository $quoteRepository,
		\Brainvire\Task5OrderProcessingFeesToCart\Helper\Data $dataHelper
	) {
		$this->quoteRepository = $quoteRepository;
		$this->dataHelper = $dataHelper;
	}

	public function beforeSaveAddressInformation(
		\Magento\Checkout\Model\ShippingInformationManagement $subject,
		$cartId,
		\Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
	) {
		$Processingfee = $addressInformation->getExtensionAttributes()->getProcessingFee();
		// echo "<pre>";
		// print_r($Processingfee);
		// die();

		$quote = $this->quoteRepository->getActive($cartId);
		if ($Processingfee) {
			$fee = $this->dataHelper->getfeeinpercentage();
			$quote->setProcessingFee($fee);
		} else {
			$quote->setProcessingFee(NULL);
		}
	}
}
