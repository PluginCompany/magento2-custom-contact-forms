<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form view block
 *
 * @category    PluginCompany
 * @package     PluginCompany_ContactForms
 * @author      Milan Simek
 */

namespace PluginCompany\ContactForms\Block\Form;

use Magento\Framework\View\Element\Template;

class View
    extends Template {
    private $filterProvider;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context  $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    )
    {
        $this->filterProvider = $filterProvider;
        parent::__construct($context, $data);
    }

    public function toHtml()
    {
        $html = $this->filterProvider
            ->getBlockFilter()
            ->filter(
                '{{widget type="PluginCompany\ContactForms\Block\Form\Widget\View" form_id="' . $this->getFormId() . '" show_form_as="form" is_page="1"}}'
            );
        return $html;
    }

    public function getFormId()
    {
        return $this->_request->getParam('form_id');
    }

}
