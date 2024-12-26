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

    protected $request;

    /**
     * @param Data $helper
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        Data $helper,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\Request\Http $request
    ){
        $this->helper = $helper;
        $this->productRepository = $productRepository;
        $this->request = $request;
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
            if(in_array($this->request->getFullActionName(), ["catalogsearch_result_index", "catalog_category_view", "cms_index_index"])){
                return false;
            }

            return true;
        }

        return true;
    }
}
