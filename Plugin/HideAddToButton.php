<?php

namespace Eleanorsoft\NonBuyableProducts\Plugin;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Catalog\Model\Product;

class HideAddToButton
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
     * @param Product $product
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterIsSaleable(\Magento\Catalog\Model\Product $product)
    {
        $localProduct = $this->productRepository->get($product->getSku());
        if($this->helper->isModuleEnabled() && boolval($localProduct->getData('non_buyable'))) {
            if($this->helper->getReplacementPhraseForAddToCart() && strlen($this->helper->getReplacementPhraseForAddToCart()) > 0){
                return true;
            }

            return false;
        }

        return true;
    }
}
