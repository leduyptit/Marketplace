<?php
namespace MGS\Marketplace\Controller\Profile;

class EditPost extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Validator
     */
    protected $formKeyValidator;
    protected $helper;
    protected $customerSession;
    protected $storeFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param Validator $formKeyValidator
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \MGS\Marketplace\Helper\Data $helper,
        \Magento\Customer\Model\Session $customerSession,
        \MGS\Marketplace\Model\StoreFactory $storeFactory
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->storeFactory = $storeFactory;
    }
    public function execute()
    {
        $sellerCheck = $this->helper->checkForSeller();
        if ($sellerCheck == -1) {
            //not logged in
            return $this->_redirect('customer/account/login');
        } elseif ($sellerCheck == 2) {
            //blocked
            $this->messageManager->addError(__('Your account has been blocked from Marketplace. Please contact the administrator!'));
            return $this->_redirect('mgs_marketplace');
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            try {
                $postData = $this->getRequest()->getPostValue();
                // $postData = (array) $this->getRequest()->getPost();
                $customerId = $this->customerSession->getCustomer()->getId();
                if (!empty($postData)) {
                    $this->saveStoreInfo($customerId, $postData);
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        }
        return $resultRedirect->setPath('mgs_marketplace/profile');
    }

    /**
     * save store info
     * @param int sellerId
     * @return redirect
     */
    protected function saveStoreInfo($customerId, $postData)
    {
        if ($customerId && $postData) {
            $store = $this->storeFactory->create();
            $id_post_update = 1;
            // $data = $this->getRequest()->getPostValue();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeUpdate = $objectManager->create('MGS\Marketplace\Model\Store')->load($id_post_update);
            // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();  
            // $storeUpdate = $store->load($id_post_update);
            // $storeUpdate->setTwiiter('test-test');
            // $storeUpdate->save();
            $data = array('twiiter' => 'Simple Question', 'facebook' => 'Question Description');
            $storeUpdate->setData($data);
            $storeUpdate->save();
        }
    }   
}
