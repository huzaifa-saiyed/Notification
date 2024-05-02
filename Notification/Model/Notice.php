<?php

namespace Kitchen\Notification\Model;

class Notice extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Kitchen\Notification\Model\ResourceModel\Notice::class);
    }
}
