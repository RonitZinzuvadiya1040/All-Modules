<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Brainvire\Question\Api\Data;

interface FaqSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface {

	/**
	 * Get faq list.
	 * @return \Brainvire\Question\Api\Data\FaqInterface[]
	 */
	public function getItems();

	/**
	 * Set entity_id list.
	 * @param \Brainvire\Question\Api\Data\FaqInterface[] $items
	 * @return $this
	 */
	public function setItems(array $items);
}
