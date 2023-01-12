<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare (strict_types = 1);

namespace Brainvire\Question\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface FaqRepositoryInterface {

	/**
	 * Save faq
	 * @param \Brainvire\Question\Api\Data\FaqInterface $faq
	 * @return \Brainvire\Question\Api\Data\FaqInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function save(
		\Brainvire\Question\Api\Data\FaqInterface $faq
	);

	/**
	 * Retrieve faq
	 * @param string $faqId
	 * @return \Brainvire\Question\Api\Data\FaqInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function get($faqId);

	/**
	 * Retrieve faq matching the specified criteria.
	 * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	 * @return \Brainvire\Question\Api\Data\FaqSearchResultsInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getList(
		\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
	);

	/**
	 * Delete faq
	 * @param \Brainvire\Question\Api\Data\FaqInterface $faq
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function delete(
		\Brainvire\Question\Api\Data\FaqInterface $faq
	);

	/**
	 * Delete faq by ID
	 * @param string $faqId
	 * @return bool true on success
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function deleteById($faqId);
}