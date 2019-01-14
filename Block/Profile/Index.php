<?php
namespace MGS\Marketplace\Block\Profile;

class Index extends \Magento\Framework\View\Element\Template
{
    public function getPostAction()
    {
        return $this->getUrl('mgs_marketplace/profile/editpost');
    }

    /**
     * Return the associated CustomerId.
     *
     * @return \Magento\Customer\Api\Data\StoreInterface
     */
    public function getVendorId()
    {
        return $this->getData(self::STORE_ID);
    }
}
