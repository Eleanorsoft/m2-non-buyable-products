<?php

namespace Eleanorsoft\NonBuyableProducts\Plugin;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;
use Magento\Framework\DataObject;

class PreventAddToWishlist
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * @param Data $helper
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        Data $helper,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ){
        $this->helper = $helper;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int|Product $product
     * @param DataObject|array|string|null $buyRequest
     * @param bool $forciblySetQty
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeAddNewItem($product, $buyRequest = null, $forciblySetQty = false)
    {
        $product = $this->productRepository->getById($buyRequest->getId());
        if($this->helper->isModuleEnabled() && boolval($product->getData('non_buyable')) && $this->helper->getHideWishlistConfigData()) {
            throw new \Magento\Framework\Exception\LocalizedException(__("Product can't be added to wishlist"));
        }
    }
}
