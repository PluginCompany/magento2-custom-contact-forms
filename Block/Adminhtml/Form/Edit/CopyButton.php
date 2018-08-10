<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Block\Adminhtml\Form\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class CopyButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getModelId()) {
            $data = [
                'label' => __('Copy Form'),
                'class' => '',
                'sort_order' => 100,
                'on_click' => 'window.location.href = "' . $this->getCopyUrl() . '"'
            ];
        }
        return $data;
    }

    /**
     * Get URL for copy button
     *
     * @return string
     */
    public function getCopyUrl()
    {
        return $this->getUrl('*/*/edit', ['copy_form_id' => $this->getModelId()]);
    }
}
