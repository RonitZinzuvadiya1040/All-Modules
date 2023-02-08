<?php

// namespace Brainvire\Task1\Setup;

// use Magento\Framework\Setup\InstallSchemaInterface;
// use Magento\Framework\Setup\ModuleContextInterface;
// use Magento\Framework\Setup\SchemaSetupInterface;

// class InstallSchema implements InstallSchemaInterface {
// 	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
// 		$setup->startSetup();
// 		$setup->getConnection()->addColumn(
// 			$setup->getTable('store'),
// 			'custom_field',
// 			[
// 				'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
// 				'length' => 255,
// 				'nullable' => true,
// 				'comment' => 'Custom Field',
// 			]
// 		);
// 		$setup->endSetup();
// 	}
// }
