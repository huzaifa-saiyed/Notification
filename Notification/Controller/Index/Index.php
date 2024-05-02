<?php

namespace Kitchen\Notification\Controller\Index;

use Kitchen\Notification\Model\NoticeFactory;
use Magento\Customer\Model\Session as CustomerSession;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;
    protected $noticeFactory;
    protected $customerSession;

    public function __construct(
        NoticeFactory $noticeFactory,
        CustomerSession $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);

        $this->noticeFactory = $noticeFactory;
        $this->customerSession = $customerSession;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $customerId = $this->customerSession->getCustomerId();
        $jsonData = $this->getRequest()->getContent();
        $data = json_decode($jsonData, true);

        $checks = $data['value'];

        $getNotice = $this->noticeFactory->create();
        $getNotice->setNotice($checks);
        $getNotice->setCustomerId($customerId);
        $getNotice->save();

        return $result->setData([
            'checkbox' => $checks,
            'message' => 'checks exists'
        ]);
    }
}
