<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Controller\Adminhtml\Entry;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'PluginCompany_ContactForms::manage_entry';
    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');
        
            $model = $this->_objectManager->create('PluginCompany\ContactForms\Model\Entry')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Entry no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData('status', $data['status']);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Entry.'));
                $this->dataPersistor->clear('plugincompany_contactforms_entry');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entry_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Entry.'));
            }
        
            $this->dataPersistor->set('plugincompany_contactforms_entry', $data);
            return $resultRedirect->setPath('*/*/edit', ['entry_id' => $this->getRequest()->getParam('entry_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
