<?php
namespace Brainvire\Task1PDPPage\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateCustomAttr implements DataPatchInterface {

	private $moduleDataSetup;

	public function __construct(
		\Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
		EavSetupFactory $eavSetupFactory
	) {
		$this->eavSetupFactory = $eavSetupFactory;
		$this->moduleDataSetup = $moduleDataSetup;
	}

	public function apply() {
		$this->moduleDataSetup->getConnection()->startSetup();

		$eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'engraving',
			[
				'type' => 'text',
				'backend' => '',
				'frontend' => '',
				'label' => 'Engraving',
				'input' => 'text',
				'class' => '',
				'source' => '',
				// 'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => 'simple,configurable,virtual,bundle,downloadable',
			]
		);

		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'size',
			[
				'type' => 'text',
				'backend' => '',
				'frontend' => '',
				'label' => 'Size',
				'input' => 'text',
				'class' => '',
				'source' => '',
				// 'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => 'simple,configurable,virtual,bundle,downloadable',
			]
		);
		$this->moduleDataSetup->getConnection()->endSetup();
	}

	public static function getDependencies() {
		return [];
	}

	public function getAliases() {
		return [];
	}
}
