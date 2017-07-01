<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * ContactForms default helper
 *
 * @category    PluginCompany
 * @package     PluginCompany_ContactForms
 * @author      Milan Simek
 */
namespace PluginCompany\ContactForms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data
    extends AbstractHelper {
    /**
     * convert array to options
     * @access public
     * @param $options
     * @return array
     * @author Milan Simek
     */
    public function convertOptions($options){
        $converted = [];
        foreach ($options as $option){
            if (isset($option['value']) && !is_array($option['value']) && isset($option['label']) && !is_array($option['label'])){
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
    
    public function formatArrayAsFormHtmlOptions($array)
    {
        if(!count($array)){
            return '';
        }
        return implode('||||', $array);
    }
}
