<?php

namespace Eleanorsoft\NonBuyableProducts\Helper;

use tests\unit\Magento\FunctionalTestFramework\Config\Reader\FilesystemTest;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        array $data = []
    ) {
        parent::__construct($context);
    }

    /**
     * @param $configPath
     * @return mixed
     */
    protected function getConfig($configPath) {
        return $this->scopeConfig->getValue($configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isModuleEnabled(): bool
    {
        return $this->getConfig('sales/non_buyable_products/active') ?? 0;
    }

    /**
     * @return bool
     */
    public function getHidePriceConfigData(): bool
    {
        return $this->getConfig('sales/non_buyable_products/hide_price') ?? 0;
    }

    /**
     * @return bool
     */
    public function getHideWishlistConfigData(): bool
    {
        return $this->getConfig('sales/non_buyable_products/hide_wishlist') ?? 0;
    }

    /**
     * @return bool
     */
    public function getHideCompareConfigData()
    {
        return $this->getConfig('sales/non_buyable_products/hide_compare') ?? 0;
    }

    /**
     * @return mixed
     */
    public function getReplacementPhraseForPrice()
    {
        return $this->getConfig('sales/non_buyable_products/replacement_price') ?? '';
    }

    /**
     * @return string
     */
    public function getReplacementPhraseForAddToCart()
    {
        return $this->getConfig('sales/non_buyable_products/replacement_add_to_cart') ?? '';
    }
}
