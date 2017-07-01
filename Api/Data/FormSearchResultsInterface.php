<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Api\Data;

interface FormSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Form list.
     * @return \PluginCompany\ContactForms\Api\Data\FormInterface[]
     */
    
    public function getItems();

    /**
     * Set title list.
     * @param \PluginCompany\ContactForms\Api\Data\FormInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
