<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\Notification\Controller\Adminhtml\Notification;

use Magento\Framework\App\Action\HttpPostActionInterface;
// use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Kitchen\Notification\Model\ResourceModel\Notify\CollectionFactory;

/**
 * Class MassEnable
 */
class MassEnable extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Cms::save';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $customerCollectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CustomerCollectionFactory $customerCollectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $customerCollectionFactory)
    {
        $this->filter = $filter;
        $this->customerCollectionFactory = $customerCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->customerCollectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus('1');
            $item->save();
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been enabled.', $collection->getSize())
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // return $resultRedirect->setPath('*/*/');
        $this->_redirect('notify/Notification/index');
    }
}
