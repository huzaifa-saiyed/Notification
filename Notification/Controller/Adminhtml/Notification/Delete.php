<?php
namespace Kitchen\Notification\Controller\Adminhtml\Notification;
 
use Magento\Framework\App\Action\HttpPostActionInterface;
use Kitchen\Notification\Model\NotifyFactory;
 
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    //const ADMIN_RESOURCE = 'Magento_Cms::page_delete';
 
    protected $customerFactory;
 
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        NotifyFactory $customerFactory,
    ) {
        parent::__construct($context);
        $this->customerFactory = $customerFactory;
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
       // $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                
                $pageModel = $this->customerFactory->create()->load($id);
                $pageModel->delete();
                
                $this->messageManager->addSuccessMessage(__('The data has been deleted.'));
               // return $resultRedirect->setPath('*/*/');
            } catch (\Exception  $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                //return $resultRedirect->setPath('*/*/edit', ['blog_id' => $id]);
            }
        }
        
        $this->messageManager->addErrorMessage(__('We can\'t find a page to delete.'));
       $this->_redirect('notify/Notification/index');
    }
}
