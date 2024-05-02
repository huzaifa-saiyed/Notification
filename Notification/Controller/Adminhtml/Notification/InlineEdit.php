<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\Notification\Controller\Adminhtml\Notification;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Kitchen\Notification\Model\NotifyFactory;
// give .php file name
use Kitchen\Notification\Model\ResourceModel\Notify as CustomerResourceModel;

class InlineEdit extends \Magento\Backend\App\Action
{
    // const ADMIN_RESOURCE = 'Magento_Cms::save';

    protected $jsonFactory;
    private $customerFactory;
    private $customerResourceModel;

    public function __construct(
        Context $context,
        NotifyFactory $customerFactory,
        JsonFactory $jsonFactory,
        CustomerResourceModel $customerResourceModel
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->customerFactory = $customerFactory;
        $this->customerResourceModel = $customerResourceModel;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if($this->getRequest()->getParam('isAjax')){
            $postItems = $this->getRequest()->getParam('items', []);
            if(!count($postItems)){
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $customerid) {
                $varInlineEdit = $this->customerFactory->create();
                $this->customerResourceModel->load($varInlineEdit, $customerid);
                $varInlineEdit->setData(array_merge($varInlineEdit->getData(), $postItems[$customerid]));
                $this->customerResourceModel->save($varInlineEdit);
                }
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }
}
