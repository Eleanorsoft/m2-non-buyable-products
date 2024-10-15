<?php

namespace Eleanorsoft\NonBuyableProducts\Plugin;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Checkout\Model\Cart;

class PreventAddToCart
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
     * @param Cart $subject
     * @param $productInfo
     * @param null $requestInfo
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeAddProduct(Cart $subject, $productInfo, $requestInfo = null)
    {
        if($this->helper->isModuleEnabled() && boolval($productInfo->getData('non_buyable'))) {
            throw new \Magento\Framework\Exception\LocalizedException(__("Product can't be added to cart"));
        }

        return [$productInfo,$requestInfo];
    }
}
