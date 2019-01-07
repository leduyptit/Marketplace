<?php
namespace MGS\Marketplace\Block\Profile;

class Index extends \Magento\Framework\View\Element\Template
{
	public function getPostAction()
	{
		return $this->getUrl('mgs_marketplace/profile/index');
	}
}
