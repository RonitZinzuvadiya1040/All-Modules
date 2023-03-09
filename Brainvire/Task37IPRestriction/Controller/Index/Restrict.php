<?php
namespace Brainvire\Task37IPRestriction\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;

class Restrict extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    protected $resultRedirectFactory;
    protected $customerSession;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RedirectFactory $resultRedirectFactory,
        Session $customerSession
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
    }

    public function execute()
    {
        $allowed_ips = ['192.168.10.157']; // Replace with your allowed IPs
        $remote_ip = $this->getRequest()->getClientIp();

        if (!in_array($remote_ip, $allowed_ips)) {
            if (!$this->customerSession->isLoggedIn()) {
                return $this->resultRedirectFactory->create()->setPath('customer/account/login');
            } else {
                throw new NotFoundException(__('Page not found.'));
            }
        }

        return $this->pageFactory->create();
    }
}
