<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ReCaptchaPosition extends AbstractOption implements ArrayInterface
{

    /**
     * Get Options
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'bottomright' => __('Bottom Right'),
            'bottomleft' => __('Bottom Left'),
            'inline' => __('Inline')
        ];
    }
}