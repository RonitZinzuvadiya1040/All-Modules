<?php
namespace Brainvire\Task1PDPPage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper {

	const XML_PATH_PERCENTAGE = 'price_sec/price_group/price_field';
	const XML_PATH_PERCENTAGE1 = 'price_sec/price_group/handling_type';

	public function getpricedata() {
		$configValue = $this->scopeConfig->getValue(self::XML_PATH_PERCENTAGE, ScopeInterface::SCOPE_STORE);
		return $configValue;
	}

	public function getpricetype(){
		$configValue2 = $this->scopeConfig->getValue(self::XML_PATH_PERCENTAGE1, ScopeInterface::SCOPE_STORE);
		return $configValue2;
	}
}