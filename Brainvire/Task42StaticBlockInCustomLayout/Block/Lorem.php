<?php
namespace Brainvire\Task42StaticBlockInCustomLayout\Block;

use Magento\Framework\View\Element\Template;

class Lorem extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getLorem()
    {
        return 'Lorem: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
    }
}