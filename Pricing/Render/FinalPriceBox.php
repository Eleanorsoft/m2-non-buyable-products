<?php

namespace Eleanorsoft\NonBuyableProducts\Pricing\Render;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Pricing\Render\PriceBox as BasePriceBox;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Msrp\Pricing\Price\MsrpPrice;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param Data $helper
     * @param array $data
     * @param SalableResolverInterface|null $salableResolver
     * @param MinimalPriceCalculatorInterface|null $minimalPriceCalculator
     */
    public function __construct(
        Context $context,
        SaleableInterface $saleableItem,
        PriceInterface $price,
        RendererPool $rendererPool,
        Data $helper,
        array $data = [],
        SalableResolverInterface $salableResolver = null,
        MinimalPriceCalculatorInterface $minimalPriceCalculator = null
    )
    {
        parent::__construct($context, $saleableItem, $price, $rendererPool, $data, $salableResolver, $minimalPriceCalculator);

        $this->helper = $helper;
    }

    /**
     * @param string $html
     * @return string
     */
    protected function wrapResult($html)
    {
        if($this->helper->isModuleEnabled() && $this->helper->getHidePriceConfigData()){
            if($this->helper->getReplacementPhraseForPrice() &&
                strlen($this->helper->getReplacementPhraseForPrice()) > 0
            ){
                $replacementPhrase = $this->helper->getReplacementPhraseForPrice();
                return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
                    'data-role="priceBox" ' .
                    'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                    '>'. $replacementPhrase .'</div>';
            }

            return '';
        }

        return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
            'data-role="priceBox" ' .
            'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
            '>' . $html . '</div>';
    }
}
