<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Block\Adminhtml\Entry\Edit\Field;

class ParentFormLink extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @var \PluginCompany\ContactForms\Model\EntryRepository
     */
    private $entryRepository;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \PluginCompany\ContactForms\Model\EntryRepository $entryRepository,
        array $data = []
    ){
        $this->request = $request;
        $this->entryRepository = $entryRepository;
        parent::__construct(
            $context,
            $data
        );
        $this->setTemplate('PluginCompany_ContactForms::entry/parentFormLink.phtml');
    }

    private function getFormId()
    {
        return $this->request->getParam('form_id');
    }

}