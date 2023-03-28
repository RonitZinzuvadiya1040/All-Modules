<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Brainvire\Task1PDPPage\Model;

class Price implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => '$',
                'label' => __('Fixed'),
            ],
            [
                'value' => '%',
                'label' => __('Percent')
            ]
        ];
    }
}
