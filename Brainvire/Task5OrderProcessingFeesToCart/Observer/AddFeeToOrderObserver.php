<?php
namespace Brainvire\Task5OrderProcessingFeesToCart\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;

class AddFeeToOrderObserver implements ObserverInterface {

	private $quoteRepository;

	public function __construct(
		QuoteRepository $quoteRepository
	) {
		$this->quoteRepository = $quoteRepository;
	}

	public function execute(EventObserver $observer) {
		$order = $observer->getOrder();
		$quote = $this->quoteRepository->get($order->getQuoteId());
		$order->setProcessingFee($quote->getProcessingFee());

		return $this;
	}
}