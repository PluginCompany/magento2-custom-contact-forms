<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface FormRepositoryInterface
{


    /**
     * Save Form
     * @param \PluginCompany\ContactForms\Api\Data\FormInterface $form
     * @return \PluginCompany\ContactForms\Api\Data\FormInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \PluginCompany\ContactForms\Api\Data\FormInterface $form
    );

    /**
     * Retrieve Form
     * @param string $formId
     * @return \PluginCompany\ContactForms\Api\Data\FormInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($formId);

    /**
     * Retrieve Form matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \PluginCompany\ContactForms\Api\Data\FormSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Form
     * @param \PluginCompany\ContactForms\Api\Data\FormInterface $form
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \PluginCompany\ContactForms\Api\Data\FormInterface $form
    );

    /**
     * Delete Form by ID
     * @param string $formId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($formId);
}
