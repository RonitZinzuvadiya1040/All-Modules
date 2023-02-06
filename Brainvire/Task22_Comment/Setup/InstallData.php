<?php
namespace Brainvire\Task22_Comment\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

Class InstallData implements InstallDataInterface {
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
		$installer = $setup;
		$setup->startSetup();
		$addressTable = 'customer_address_entity';
		$setup->getConnection()
			->addColumn(
				$setup->getTable($addressTable),
				'comment',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'label' => 'comment',
					'comment' => 'comment',
					'input' => 'text',
					'required' => false,
					'visible' => true,
					'user_defined' => true,
					'sort_order' => 101,
					'position' => 101,
					'system' => 0,
				]
			);
		$setup->endSetup();
	}
}