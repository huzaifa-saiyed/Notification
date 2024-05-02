<?php
 
namespace Kitchen\Notification\Controller\Adminhtml\Notification;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\Notification\Model\NotifyFactory;
 
class Saveform extends Action
{
    protected $customerFactory;
 
    public function __construct(
        Context $context,
        NotifyFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $varOne = $this->getRequest()->getPostValue();
        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
            $this->_redirect('notify/notification/index');
        }
 
        $varModel = $this->customerFactory->create();
        $varModel->setTitle($varOne['title']);
        $varModel->setDescription($varOne['description']);
        $varModel->setStatus($varOne['status']);       
        
        $grp = implode(',', $varOne['customer_grp']);
        $varModel->setCustomerGrp($grp);
            
        try {
            $varModel->save();
            $this->messageManager->addSuccessMessage(__('data has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            $this->_getSession()->setFormData($varOne);
            $this->_redirect('notify/notification/index');
        }
        $this->_redirect('notify/notification/index');
    }

} 