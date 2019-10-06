<?php
namespace PluginCompany\ContactForms\Model\Template;

use Magento\Customer\Model\Url;

/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
class FormHtmlFilter
{
    private $html;
    /**
     * @var Url
     */
    private $customerUrl;

    /**
     * FormHtmlFilter constructor.
     * @param Url $customerUrl
     */
    public function __construct
    (
        Url $customerUrl
    ) {
        $this->customerUrl = $customerUrl;
    }

    public function prepareFormHtmlForDisplay($html)
    {
        $this->html = $html;
        $this
            ->rewriteDataBindAttributes()
            ->replaceLoginLink()
        ;
        return $this->html;
    }

    private function rewriteDataBindAttributes()
    {
        $this->html = str_replace('pc-data-bind', 'data-bind', $this->html);
        return $this;
    }

    private function replaceLoginLink()
    {
        $this->html =
            str_replace(
                [
                    '<log_in_link>',
                    '</log_in_link>'
                ],
                [
                    "<a href='{$this->getLoginLink()}'>",
                    '</a>'
                ],
                $this->html
            );
        return $this;
    }

    private function getLoginLink()
    {
        return $this->customerUrl->getLoginUrl();
    }

}
