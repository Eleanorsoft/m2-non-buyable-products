<?php

namespace Eleanorsoft\NonBuyableProducts\Block\ReplaceButton;

class Condition extends \Magento\Catalog\Block\Product\View
{
    /**
     * @var \Eleanorsoft\NonBuyableProducts\Helper\Data
     */
    public $helper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Eleanorsoft\NonBuyableProducts\Helper\Data $helper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Eleanorsoft\NonBuyableProducts\Helper\Data $helper,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->helper = $helper;
        $this->registry = $registry;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $product = $this->registry->registry('current_product');
        if (boolval($product->getData('non_buyable')) && $this->helper->isModuleEnabled() /*&& $this->helper->getReplacementPhraseForAddToCart() && strlen($this->helper->getReplacementPhraseForAddToCart()) > 0 */
        ) {
            $this->_template = 'Eleanorsoft_NonBuyableProducts::addtocart.phtml';
        }
        return parent::_toHtml();
    }
}
