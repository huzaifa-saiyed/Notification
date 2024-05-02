<?php

namespace Kitchen\Notification\Model\ResourceModel\Notify;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idName = 'entity_id';
    protected function _construct()
    {
        $this->_init(
            \Kitchen\Notification\Model\Notify::class,
            \Kitchen\Notification\Model\ResourceModel\Notify::class
        );
    }
}
