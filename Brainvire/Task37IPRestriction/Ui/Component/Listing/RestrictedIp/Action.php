<?php

namespace Brainvire\Task37IPRestriction\Ui\Component\Listing\RestrictedIp;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    
    const ROW_EDIT_URL = 'restricted_customer/post/edit';
    const ROW_DELETE_URL = 'restricted_customer/post/delete';
    
    protected $_urlBuilder;

    private $_editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL,
        $deleteUrl = self::ROW_DELETE_URL
    ) 
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        $this->_deleteUrl = $deleteUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) 
        {
            foreach ($dataSource['data']['items'] as &$item) 
            {
                $name = $this->getData('name');
                if (isset($item['restrict_id'])) 
                {
                    $item[$name]['edit_action'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_editUrl, 
                            ['id' => $item['restrict_id']]
                        ),
                        'label' => __('Edit'),
                    ];


                    $item[$name]['delete_action'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_deleteUrl, 
                            ['id' => $item['restrict_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete Ip Address'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
