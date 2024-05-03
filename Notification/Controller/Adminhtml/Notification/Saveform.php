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
        $resultRedirect = $this->resultRedirectFactory->create();
        $varOne = $this->getRequest()->getPostValue();
        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
            $this->_redirect('notify/notification/index');
        } else {
            try {
                if (!empty($varOne['entity_id'])) {
                    $varModel = $this->customerFactory->create()->load($varOne['entity_id']);
                    $this->messageManager->addSuccessMessage(__('Data has been updated.'));
                } else {
                    $varModel = $this->customerFactory->create();
                    $this->messageManager->addSuccessMessage(__('Data has been saved.'));
                }

                $varModel->setTitle($varOne['title']);
                $varModel->setDescription($varOne['description']);
                $varModel->setStatus($varOne['status']);       
                
                $grp = implode(',', $varOne['customer_grp']);
                $varModel->setCustomerGrp($grp);

                $varModel->save();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            }
        }
 
        return $resultRedirect->setPath('notify/notification/index');
    }

} 