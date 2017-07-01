<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Api\Data;

interface EntrySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Entry list.
     * @return \PluginCompany\ContactForms\Api\Data\EntryInterface[]
     */
    
    public function getItems();

    /**
     * Set form_id list.
     * @param \PluginCompany\ContactForms\Api\Data\EntryInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
