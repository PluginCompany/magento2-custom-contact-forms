<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $setup;

    /**
     * Updates DB schema for Contact Forms extension
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $this->setup = $setup;
        $setup->startSetup();
        $this->increaseFormHtmlAndJSONFieldsLength();
        $this->addTranslationField();
        $setup->endSetup();
    }

    private function increaseFormHtmlAndJSONFieldsLength()
    {
        $this->setup->getConnection()
            ->modifyColumn(
                $this->setup->getTable('plugincompany_contactforms_form'),
                'contact_form_json',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'Contact Form JSON',
                    'length' => '2m'
                ]
            )
            ->modifyColumn(
                $this->setup->getTable('plugincompany_contactforms_form'),
                'contact_form_html',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'Contact Form HTML',
                    'length' => '2m'
                ]
            )
        ;
    }

    private function addTranslationField()
    {
        $this->setup->getConnection()
            ->addColumn(
                $this->setup->getTable('plugincompany_contactforms_form'),
                'translation',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'Fields Translation',
                    'length' => '2m'
                ]
            );
        $this->setup->getConnection()
            ->addColumn(
                $this->setup->getTable('plugincompany_contactforms_form'),
                'general_translation',
                [
                    'type' => Table::TYPE_TEXT,
                    'comment' => 'General Translation',
                    'length' => '2m'
                ]
            );
    }
}


