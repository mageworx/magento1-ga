<?php
/**
 * MageWorx
 * GA Fixer
 *
 * @category   MageWorx
 * @package    MageWorx_GA
 * @copyright  Copyright (c) 2016 MageWorx (http://www.mageworx.com/)
 */
class MageWorx_GA_Model_Observer
{
    /**
     * Save order ids to registry
     * @param Varien_Event_Observer $observer
     * @return MageWorx_GA_Model_Observer
     */
    public function setGoogleAnalyticsOrders(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return $this;
        }
        Mage::register('order_success_page_order_ids', $orderIds, true);

        return $this;
    }

    /**
     * Pass order ids to google_analytics block
     * @param Varien_Event_Observer $observer
     * @return MageWorx_GA_Model_Observer
     */
    public function addGoogleAnalyticsOrdersToBlock(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block->getNameInLayout() != 'google_analytics') {
            return $this;
        }

        $orderIds = Mage::registry('order_success_page_order_ids');
        if (empty($orderIds) || !is_array($orderIds)) {
            return $this;
        }

        if ($block) {
            $block->setOrderIds($orderIds);
        }

        return $this;
    }
}
