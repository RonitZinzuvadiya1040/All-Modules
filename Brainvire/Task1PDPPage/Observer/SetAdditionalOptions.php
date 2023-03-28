<?php
namespace Brainvire\Task1PDPPage\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;

class SetAdditionalOptions implements ObserverInterface
{
    protected $_request;    
    public function __construct(
        RequestInterface $request, 
        Json $serializer = null
        ) 
    {
        $this->_request = $request;
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Serialize\Serializer\Json::class);
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // Check and set information according to your need
        $product = $observer->getProduct();                    
        if ($this->_request->getFullActionName() == 'checkout_cart_add') { //checking when product is adding to cart
            $product = $observer->getProduct();
            $additionalOptions = [];
            // $additionalOptions1 = [];
            $additionalOptions[] = [
                'label' => "Engraving", //Custom option label
                'value' => "Yes" //Custom option value               
            ]; 
            $additionalOptions[] = [
                'label' => "Size", //Custom option label
                'value' => "50" //Custom option value                
            ];                         
            $product->addCustomOption('additional_options', $this->serializer->serialize($additionalOptions));
            // $product->addCustomOption('additional_options', $this->serializer->serialize($additionalOptions1));
        }
    }
}