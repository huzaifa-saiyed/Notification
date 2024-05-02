<?php

namespace Kitchen\Notification\Block;

use Kitchen\Notification\Model\NotifyFactory;
use Kitchen\Notification\Model\NoticeFactory;
use Magento\Customer\Model\Session as CustomerSession;

class Notice extends \Magento\Framework\View\Element\Template
{
    protected $notifyFactory;
    protected $noticeFactory;
    protected $customerSession;

    public function __construct(
        NotifyFactory $notifyFactory,
        NoticeFactory $noticeFactory,
        CustomerSession $customerSession,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->notifyFactory = $notifyFactory;
        $this->noticeFactory = $noticeFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function getCustomerGroup()
    {
        $customerGrpId = $this->customerSession->getCustomerGroupId();

        return $customerGrpId;
    }

    public function loggedIn()
    {
        $loggedIn = $this->customerSession->isLoggedIn();

        return $loggedIn;
    }

    public function checksRead()
    {
        $customerId = $this->customerSession->getCustomerId();
        if (!$customerId) {
            return false;
        }

        $notice = $this->noticeFactory->create()->getCollection()
        ->addFieldToFilter('customer_id', $customerId)
        ->addFieldToFilter('notice', 1)
        ->getFirstItem();

        return (bool) $notice->getId(); 
    }

    public function showTitle()
    {
        // echo "This is Notice";
        $getNotice = $this->notifyFactory->create();
        $getCollection = $getNotice->getCollection()->addFieldToFilter('customer_grp',$this->getCustomerGroup());

        foreach ($getCollection as $row) {
            echo $row->getTitle();
        }
    }

    public function showDescription()
    {
        // echo "This is Notice";
        $getNotice = $this->notifyFactory->create();
        $getCollection = $getNotice->getCollection()->addFieldToFilter('customer_grp',$this->getCustomerGroup());

        foreach ($getCollection as $row) {
            echo $row->getDescription();
        }
    }
}
