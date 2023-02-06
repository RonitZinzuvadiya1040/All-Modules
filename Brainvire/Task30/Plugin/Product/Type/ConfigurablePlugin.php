<?php 
namespace Brainvire\Task30\Plugin\Product\Type;

    class ConfigurablePlugin
    {
        public function afterGetUsedProductCollection(\Magento\ConfigurableProduct\Model\Product\Type\Configurable $subject, $result)
        {
            $result->addAttributeToSelect('name');
            $result->addAttributeToSelect('description');
            return $result;
        }
    }