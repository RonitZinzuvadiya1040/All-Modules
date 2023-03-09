<?php
namespace Brainvire\Task37IPRestriction\Observer;

use Brainvire\Task37IPRestriction\Model\RestrictIp;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Customer\Model\Session as CustomerSession;


class IpRestrict implements ObserverInterface
{
	/**
	 * @var RemoteAddress $remoteAddress
	 */
	protected $remoteAddress;

	/**
	 * @var \Magento\Framework\App\ResourceConnection $resource
	 */
	protected $resource;

	/**
	 * @var CustomerSession $session
	 */
	protected $session;

	/**
	 * @var \Magento\Framework\Message\ManagerInterface $messageManager
	 */
	protected $messageManager;

	/**
     * 
     * @param RemoteAddress $remoteAddress
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param CustomerSession $session
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @return null 
     */
	public function __construct(
			RemoteAddress $remoteAddress,
			\Magento\Framework\App\ResourceConnection $resource,
			CustomerSession $session,
			\Magento\Framework\Message\ManagerInterface $messageManager
		)
	{
		$this->remoteAddress = $remoteAddress;
		$this->resource = $resource;
		$this->session = $session;
		$this->messageManager = $messageManager;
	}

	/**
	 * 
	 * @param \Magento\Framework\Event\Observer $observer
	 * @return null
	 */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		echo "Observer Working...";
        echo "<pre>";
		$ipAddresses = $this->remoteAddress->getRemoteAddress();
		print_r($ipAddresses);
		// die;
		// print_r(get_class_methods($observer));

		// $remote = $objctManager->get('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
        // echo "IP ADDRESS:".$remote->getRemoteAddress();
        // echo "<pre>";
        // print_r($loginParams);
        // die;
		// die;

        // $ipAddresses = $this->remoteAddress->getRemoteAddress();

        $connection = $this->resource;

        $tableName = $connection->getTableName('custom_restricted_customer_ipaddress');

        $select = $connection->getConnection()->select()->from($tableName)->where('restricted_address = :restricted_address');
        $id = $connection->getConnection()->fetchAll($select, [':restricted_address' => $ipAddresses]);

        if($id)
        {
		    $this->session->logout()->setBeforeAuthUrl($this->_redirect->getRefererUrl())
		        ->setLastCustomerId($id);

		    $this->messageManager->addError(__('You are restricted!'));

		    /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
		    $resultRedirect = $this->resultRedirectFactory->create();
		    $resultRedirect->setPath('customer/account/login');
		    return $resultRedirect;
        }
    }
}