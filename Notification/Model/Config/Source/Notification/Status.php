<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\Notification\Model\Config\Source\Notification;

use Kitchen\Notification\Model\NotifyFactory;

/**
 * @api
 * @since 100.0.2
 */
class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */

    protected $customerFactory;

    public function __construct(
        NotifyFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
    }

    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'Disable'],
            ['value' => '1', 'label' => 'Enable']
        ];
        
        }
    }
