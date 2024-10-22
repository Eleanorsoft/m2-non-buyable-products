<?php

namespace Eleanorsoft\NonBuyableProducts\Plugin;

use Eleanorsoft\NonBuyableProducts\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\ViewModel\Product\Checker\AddToCompareAvailability;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\DataObject;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class PreventAddToCompare extends \Magento\Catalog\Controller\Product\Compare\Add
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param Product\Compare\ItemFactory $compareItemFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param Product\Compare\ListCompare $catalogProductCompareList
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Validator $formKeyValidator
     * @param PageFactory $resultPageFactory
     * @param ProductRepositoryInterface $productRepository
     * @param Data $helper
     * @param AddToCompareAvailability|null $compareAvailability
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\Product\Compare\ItemFactory $compareItemFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Compare\Item\CollectionFactory $itemCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Catalog\Model\Product\Compare\ListCompare $catalogProductCompareList,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Validator $formKeyValidator,
        PageFactory $resultPageFactory,
        ProductRepositoryInterface $productRepository,
        Data $helper,
        AddToCompareAvailability $compareAvailability = null)
    {
        $this->helper = $helper;

        parent::__construct($context, $compareItemFactory, $itemCollectionFactory, $customerSession, $customerVisitor, $catalogProductCompareList, $catalogSession, $storeManager, $formKeyValidator, $resultPageFactory, $productRepository, $compareAvailability);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $product = $this->productRepository->getById($this->getRequest()->getParam('product'));
        if($this->helper->isModuleEnabled() && boolval($product->getData('non_buyable')) && $this->helper->getHideCompareConfigData()) {
            $this->messageManager->addErrorMessage(__("Product can't be added to compare list"));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setRefererUrl();
        }

        return parent::execute();
    }
}
