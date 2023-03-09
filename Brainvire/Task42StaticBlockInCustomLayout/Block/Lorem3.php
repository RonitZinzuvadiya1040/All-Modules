<?php
namespace Brainvire\Task42StaticBlockInCustomLayout\Block;

use Magento\Framework\View\Element\Template;

class Lorem3 extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getLorem3()
    {
        return 'Lorem3: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
    }
}