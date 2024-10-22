<?php

namespace Eleanorsoft\NonBuyableProducts\Checker;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\CatalogInventory\Api\StockConfigurationInterface;

class AddToCompareAvailability extends \Magento\Catalog\ViewModel\Product\Checker\AddToCompareAvailability
{
    /**
     * @var \Eleanorsoft\NonBuyableProducts\Helper\Data
     */
    public $helper;

    /**
     * @param StockConfigurationInterface $stockConfiguration
     * @param \Eleanorsoft\NonBuyableProducts\Helper\Data $helper
     */
    public function __construct(
        StockConfigurationInterface $stockConfiguration,
        \Eleanorsoft\NonBuyableProducts\Helper\Data $helper
    )
    {
        parent::__construct($stockConfiguration);

        $this->helper = $helper;
    }

    /**
     * @param ProductInterface $product
     * @return bool
     */
    public function isAvailableForCompare(ProductInterface $product): bool
    {
        if($this->helper->isModuleEnabled() && $product->getData('non_buyable') && $this->helper->getHideCompareConfigData()){
            return false;
        }

        return parent::isAvailableForCompare($product);
    }
}
