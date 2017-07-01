<?php
/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms for Magento 2, released under the MIT License.
 * See the LICENSE file in the project root.
 */

namespace PluginCompany\ContactForms\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use \Magento\Framework\Model\AbstractModel;

class Entry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTimeDateTime;

    public function __construct(
        Context $context,
        DateTime $dateTimeDateTime,
        $connectionName = null
    )
    {
        $this->dateTimeDateTime = $dateTimeDateTime;
        parent::__construct($context, $connectionName);
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('plugincompany_contactforms_entry', 'entity_id');
    }

    protected function _beforeSave(AbstractModel $object)
    {
        $now = $this->dateTimeDateTime->gmtDate();
        if ($object->isObjectNew()){
            $object->setCreatedAt($now);

        }
        return parent::_beforeSave($object);
    }

    protected function _afterSave(AbstractModel $object)
    {
        if($object->isObjectNew()){
            $object->getForm()
                ->increaseEntryIncrementIdCounter()
                ->save()
            ;
        }
        return $this;
    }

}
