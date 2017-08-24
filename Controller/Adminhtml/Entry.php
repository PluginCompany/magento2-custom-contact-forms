<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Controller\Adminhtml;

abstract class Entry extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'PluginCompany_ContactForms::manage_entry';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \PluginCompany\ContactForms\Model\EntryRepository
     */
    protected $entryRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \PluginCompany\ContactForms\Model\EntryRepository $entryRepository
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->entryRepository = $entryRepository;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('PluginCompany'), __('PluginCompany'))
            ->addBreadcrumb(__('Entry'), __('Entry'));
        return $resultPage;
    }
}
