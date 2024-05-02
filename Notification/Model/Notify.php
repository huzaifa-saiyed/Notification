<?php

namespace Kitchen\Notification\Model;

class Notify extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Kitchen\Notification\Model\ResourceModel\Notify::class);
    }
}
