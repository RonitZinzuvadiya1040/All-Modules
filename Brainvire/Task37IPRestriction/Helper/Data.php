<?php
namespace Brainvire\Task37IPRestriction\Helper;

use Magento\Framework\Form\Helper\AbstractHelper;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;

class Data implements ConfigProviderInterface
{
    const XPATH_IP = 'restrict_ip/test_group/field1';
  
    
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $store = $this->getStoreId();
        
        $ip = $this->scopeConfig->getValue(self::XPATH_IP, ScopeInterface::SCOPE_STORE, $store);
       
		  
        return $ip;
    }

    public function getStoreId()
    {
        return $this->storeManager->getStore()->getStoreId();
    }
}