<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

/**
 * Form helper
 *
 * @category    PluginCompany
 * @package     PluginCompany_ContactForms
 * @author      Milan Simek
 */
namespace PluginCompany\ContactForms\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Form
    extends AbstractHelper {
    /**
     * @var ScopeConfigInterface
     */
    protected $_configScopeConfigInterface;

    public function __construct(Context $context, 
        ScopeConfigInterface $configScopeConfigInterface)
    {
        $this->_configScopeConfigInterface = $configScopeConfigInterface;

        parent::__construct($context);
    }

    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     * @author Milan Simek
     */
    public function getUseBreadcrumbs(){
        return $this->_configScopeConfigInterface->isSetFlag('plugincompany_contactforms/form/breadcrumbs', ScopeInterface::SCOPE_STORE);
    }
}
