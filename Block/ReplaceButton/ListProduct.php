<?php

namespace Eleanorsoft\NonBuyableProducts\Block\ReplaceButton;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    /**
     * @var \Eleanorsoft\NonBuyableProducts\Helper\Data
     */
    public $helper;

    public function __construct(
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        \Eleanorsoft\NonBuyableProducts\Helper\Data $helper,
        array $data = [],
        ?OutputHelper $outputHelper = null
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data, $outputHelper);
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        if ($this->helper->isModuleEnabled() && $this->helper->getReplacementPhraseForAddToCart() && strlen($this->helper->getReplacementPhraseForAddToCart()) > 0
        ) {
            $this->_template = 'Eleanorsoft_NonBuyableProducts::list.phtml';
        }
        return parent::_toHtml();
    }
}
