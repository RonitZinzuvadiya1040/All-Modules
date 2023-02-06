<?php
namespace Brainvire\Task09DailyDeal\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddProductdealstatus implements DataPatchInterface {

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
			'custom_dealstatus',
			[
				'group' => 'Daily Deal',
				'type' => 'int',
				'frontend' => '',
				'label' => 'Custom Deal Status',
				'input' => 'boolean',
				'class' => '',
				'source' => 'Brainvire\Task09DailyDeal\Model\Config\Source\Yesno',
				'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
				'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
				'visible' => true,
				'required' => true,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => true,
				'comparable' => true,
				'visible_on_front' => true,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => '',
			]
		);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'custom_dealtime',
			[
				'group' => 'Daily Deal',
				'type' => 'datetime',
				'backend' => '',
				'frontend' => '',
				'label' => 'Custom Daily Deal Date',
				'input' => 'date',
				'class' => '',
				'source' => '',
				'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
				'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => true,
				'default' => '',
				'searchable' => false,
				'filterable' => true,
				'comparable' => true,
				'visible_on_front' => true,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => '',
			]
		);
		$this->moduleDataSetup->getConnection()->endSetup();
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getDependencies() {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAliases() {
		return [];
	}
}
