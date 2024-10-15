<?php

namespace Eleanorsoft\NonBuyableProducts\Plugin;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Catalog\Model\Product;

class HidePrice
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
     * @param $subject
     * @param $result
     * @return mixed|string
     */
    public function afterRender($subject, $result)
    {
        if($this->helper->isModuleEnabled() && $this->helper->getHidePriceConfigData()){
            if($this->helper->getReplacementPhraseForPrice() &&
                strlen($this->helper->getReplacementPhraseForPrice()) > 0
            ){
                $replacementPhrase = $this->helper->getReplacementPhraseForPrice();
                return $replacementPhrase;
            }

            return '';
        }

        return $result;
    }


}
