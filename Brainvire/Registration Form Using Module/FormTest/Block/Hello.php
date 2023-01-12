<?php
namespace Brainvire\FormTest\Block;

class Hello extends \Magento\Framework\View\Element\Template
{
    public $testCollection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Brainvire\FormTest\Model\ResourceModel\Test\CollectionFactory $testCollection,
        array $data = []
    ) {
        $this->testCollection = $testCollection;
        parent::__construct($context, $data);
    }

    public function getTests()
    {
        $collection = $this->testCollection->create();
        return $collection;
    }

    public function getText() {
        return "REGISTRATION FORM";
    }
}