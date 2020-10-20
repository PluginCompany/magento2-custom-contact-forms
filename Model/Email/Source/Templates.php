<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */
namespace PluginCompany\ContactForms\Model\Email\Source;

use Magento\Email\Model\ResourceModel\Template\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Templates implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $templates = [
            [
                'label' => 'Default Templates',
                'value' => [
                    [
                        'label' => 'Notification Template (HTML)',
                        'value' => 'custom_contact_forms_notification'
                    ],
                    [
                        'label' => 'Notification Template (Plain Text)',
                        'value' => 'custom_contact_forms_notification_plain'
                    ]
                ]
            ]
        ];
        $customTemplates = $this->getCustomTemplates();
        if(!empty($customTemplates)) {
            $templates[] = [
                'label' => 'Custom Templates',
                'value' => $customTemplates
            ];
        }
        return $templates;
    }

    private function getCustomTemplates()
    {
        return $this->collectionFactory
            ->create()
            ->toOptionArray();
    }
}
