<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model\Widget;

class SchemaLocatorPlugin
{
    public function afterGetSchema(\Magento\Widget\Model\Config\SchemaLocator $subject, $result)
    {
        $fileName = $this->getEtcDir() . '/widget.xsd';
        return $fileName;
    }

    public function afterGetPerFileSchema(\Magento\Widget\Model\Config\SchemaLocator $subject, $result)
    {
        $fileName = $this->getEtcDir() . '/widget_file.xsd';
        return $fileName;
    }

    private function getEtcDir()
    {
        /** @var \Magento\Framework\ObjectManagerInterface $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\Module\Dir\Reader $reader */
        $reader = $om->get('Magento\Framework\Module\Dir\Reader');
        $etcDir = $reader->getModuleDir('etc', 'PluginCompany_ContactForms');
        return $etcDir;
    }
}