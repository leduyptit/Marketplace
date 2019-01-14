<?php
namespace MGS\Marketplace\Block\Profile;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_storeFactory;
    protected $customerSession;
    protected $_resourceConnection;
    protected $_connection;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MGS\Marketplace\Model\StoreFactory $storeFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    )
    {
        $this->_storeFactory = $storeFactory;
        $this->customerSession = $customerSession;
        $this->_resourceConnection = $resourceConnection;
        parent::__construct($context);
    }

    public function getPostAction()
    {
        return $this->getUrl('mgs_marketplace/profile/editpost');
    }

     public function getStore()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        $this->_connection = $this->_resourceConnection->getConnection();
        //Your custom sql query
        $query = "SELECT * FROM mgs_marketplace_store INNER JOIN mgs_marketplace_seller ON mgs_marketplace_store.store_id = mgs_marketplace_seller.seller_id WHERE mgs_marketplace_seller.customer_id = ".$customerId; 
        $collection = $this->_connection->fetchAll($query);
        return $collection;
    }
}
