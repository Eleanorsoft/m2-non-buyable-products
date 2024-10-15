<?php

namespace Eleanorsoft\NonBuyableProducts\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddNonBuyableAttributeToAttributeSets implements DataPatchInterface, PatchRevertableInterface
{

    const ATTRIBUTE_CODE = 'non_buyable';

    const ATTRIBUTE_GROUP = 'Product Details';

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    /**
     * @var \Magento\Eav\Setup\EavSetup
     */
    protected $eavSetup;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Catalog\Model\Config
     */
    protected $config;

    /**
     * @var \Magento\Eav\Api\AttributeManagementInterface
     */
    protected $attributeManagement;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    protected $eavSetupFactory;


    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\State $state
     * @param \Magento\Eav\Setup\EavSetup $eavSetup
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Catalog\Model\Config $config
     * @param \Magento\Eav\Api\AttributeManagementInterface $attributeManagement
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\State $state,
        \Magento\Eav\Setup\EavSetup $eavSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Catalog\Model\Config $config,
        \Magento\Eav\Api\AttributeManagementInterface $attributeManagement,
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->scopeConfig = $scopeConfig;

        $this->state = $state;
        $this->eavSetup = $eavSetup;
        $this->config = $config;
        $this->attributeManagement = $attributeManagement;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->state->setAreaCode('adminhtml');

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'group'         => self::ATTRIBUTE_GROUP,
                'type'          => 'varchar',
                'label'         => 'Can be bought?',
                'input'    => 'boolean',
                'source'   => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'      => false,
                'sort_order'    => 50,
                'global'        => ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid'               => false,
                'is_visible_in_grid'            => false,
                'is_filterable_in_grid'         => false,
                'visible'                       => true,
                'is_html_allowed_on_frontend'   => true,
                'visible_on_front'              => true,
            ]
        );

        $entityTypeId = $this->eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetIds = $this->eavSetup->getAllAttributeSetIds($entityTypeId);

        foreach ($attributeSetIds as $attributeSetId) {
            if ($attributeSetId) {
                $group_id = $this->config->getAttributeGroupId($attributeSetId, self::ATTRIBUTE_GROUP);
                $this->attributeManagement->assign(
                    'catalog_product',
                    $attributeSetId,
                    $group_id,
                    self::ATTRIBUTE_CODE,
                    999
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function revert()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
