<?php

namespace Eleanorsoft\NonBuyableProducts\Helper;

use Magento\Framework\Escaper;
use Magento\Wishlist\Controller\WishlistProviderInterface;
use tests\unit\Magento\FunctionalTestFramework\Config\Reader\FilesystemTest;

class WishlistHelper extends \Magento\Wishlist\Helper\Data
{

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Customer\Helper\View $customerViewHelper,
        WishlistProviderInterface $wishlistProvider,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Eleanorsoft\NonBuyableProducts\Helper\Data $helper,
        \Magento\Framework\Registry $registry,
        Escaper $escaper = null)
    {
        parent::__construct($context, $coreRegistry, $customerSession, $wishlistFactory, $storeManager, $postDataHelper, $customerViewHelper, $wishlistProvider, $productRepository, $escaper);
        $this->helper = $helper;
        $this->registry = $registry;
    }

    /**
     * Check is allow wishlist module
     *
     * @return bool
     */
    public function isAllow()
    {
        $product = $this->registry->registry('current_product');
        if($product && $this->helper->isModuleEnabled() && $product->getData('non_buyable') && $this->helper->getHideWishlistConfigData()){
            return false;
        }

        return parent::isAllow();
    }
}
