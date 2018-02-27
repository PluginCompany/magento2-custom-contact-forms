<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Plugin\View\Asset;

use Magento\Framework\View\Asset\Minification;

class MinificationPlugin
{
    private $result;

    public function aroundGetExcludes(
        Minification $subject,
        callable $proceed,
        $contentType
    ) {
        $this->result = $proceed($contentType);
        if ($contentType == 'js') {
            return $this->getJsExcludes();
        }
        return $this->getCssExcludes();
    }

    public function getJsExcludes()
    {
        $excludes = [
            '.*frontend.*PluginCompany_ContactForms.*lib.*',
            '.*frontend.*PluginCompany_ContactForms.*form.*',
            '.*backend.*PluginCompany_ContactForms.*CodeMirror.*',
        ];
        return array_merge($this->result, $excludes);
    }

    public function getCssExcludes()
    {
        $excludes = [
          '.*backend.*PluginCompany_ContactForms.*',
          '.*frontend.*PluginCompany_ContactForms.*'
        ];
        return array_merge($this->result, $excludes);
    }
}