<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Brainvire\Question\Api\Data;

interface FaqInterface
{

    const EMAIL = 'email';
    const QUESTION = 'question';
    const NAME = 'name';
    const UPDATED_AT = 'updated_at';
    const ENTITY_ID = 'entity_id';
    const CREATED_AT = 'created_at';
    const SKU = 'sku';
    const FAQ_ID = 'faq_id';

    /**
     * Get faq_id
     * @return string|null
     */
    public function getFaqId();

    /**
     * Set faq_id
     * @param string $faqId
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setFaqId($faqId);

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setEntityId($entityId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setName($name);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setEmail($email);

    /**
     * Get question
     * @return string|null
     */
    public function getQuestion();

    /**
     * Set question
     * @param string $question
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setQuestion($question);

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setSku($sku);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Brainvire\Question\Faq\Api\Data\FaqInterface
     */
    public function setUpdatedAt($updatedAt);
}

