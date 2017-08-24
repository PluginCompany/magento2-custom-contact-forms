<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Block\Adminhtml\Form\Edit\Tab;

class Dependentfields extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @var \PluginCompany\ContactForms\Model\FormRepository
     */
    private $formRepository;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \PluginCompany\ContactForms\Model\FormRepository $formRepository,
        array $data = []
    ){
        $this->request = $request;
        $this->formRepository = $formRepository;
        parent::__construct(
            $context,
            $data
        );
        $this->setTemplate('PluginCompany_ContactForms::form/Dependentfields.phtml');
    }

    private function getFormId()
    {
        return $this->request->getParam('form_id');
    }

    /**
     * Get dependent fields in JSON format
     *
     * @return string
     */
    public function getDfieldsJSON()
    {
        if (!$id = $this->getFormId()) {
            //default content for new form
            $json = '[]';
        }else{
            //form contents of existing form
            $json = $this->formRepository->getByIdOrNew($id)->getDependentFields();
            if(!$json){
                $json = '[]';
            }
        }
        return $json;
    }

}