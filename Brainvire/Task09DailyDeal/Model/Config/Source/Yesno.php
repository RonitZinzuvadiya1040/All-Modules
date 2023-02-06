<?php

namespace Brainvire\Task09DailyDeal\Model\Config\Source;
class Yesno implements \Magento\Framework\Option\ArrayInterface {
	/**
	 * @return array
	 */
	public function toOptionArray() {
		return [
			['value' => 'Yes', 'label' => __('Yes')],
			['value' => 'No', 'label' => __('No')],

		];
	}
}

?>