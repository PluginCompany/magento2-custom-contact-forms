<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Controller\Adminhtml\Form;

class Formbuilder extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory

    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);

    }

    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__(' heading '));

        $block = $resultPage->getLayout()
            ->createBlock('PluginCompany\ContactForms\Block\Adminhtml\Form\Edit\Tab\Formbuilder')
            ->setTemplate('PluginCompany_ContactForms::form/Formbuilder.phtml')
            ->toHtml();
        $this->getResponse()->setBody($block);
    }
}
