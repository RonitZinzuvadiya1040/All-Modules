<?php
namespace Brainvire\Task5OrderProcessingFeesToCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper {

	const XML_PATH_PERCENTAGE = 'percentage/general/display_text';

	public function getfeeinpercentage() {
		$configValue = $this->scopeConfig->getValue(self::XML_PATH_PERCENTAGE, ScopeInterface::SCOPE_STORE);
		return $configValue;
	}
}