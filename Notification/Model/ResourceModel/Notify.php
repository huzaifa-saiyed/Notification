<?php

namespace Kitchen\Notification\Model\ResourceModel;

class Notify extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('kitchen_notice', 'entity_id');
    }
}
