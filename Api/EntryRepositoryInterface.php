<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface EntryRepositoryInterface
{


    /**
     * Save Entry
     * @param \PluginCompany\ContactForms\Api\Data\EntryInterface $entry
     * @return \PluginCompany\ContactForms\Api\Data\EntryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \PluginCompany\ContactForms\Api\Data\EntryInterface $entry
    );

    /**
     * Retrieve Entry
     * @param string $entryId
     * @return \PluginCompany\ContactForms\Api\Data\EntryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($entryId);

    /**
     * Retrieve Entry matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \PluginCompany\ContactForms\Api\Data\EntrySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Entry
     * @param \PluginCompany\ContactForms\Api\Data\EntryInterface $entry
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \PluginCompany\ContactForms\Api\Data\EntryInterface $entry
    );

    /**
     * Delete Entry by ID
     * @param string $entryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($entryId);
}
