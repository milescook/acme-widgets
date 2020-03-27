<?php

namespace Domain\Repository\DeliveryCostRule;

use Domain\Entity\DeliveryCostRule;
use Domain\Aggregate\DeliveryCostRuleList;

class DeliveryCostRuleRepositoryMemory implements iDeliveryCostRuleRepository
{
    /** @var array<DeliveryCostRule> _deliveryCostRuleArray */
    private $_deliveryCostRuleArray = [];

    /**
     * @param DeliveryCostRule $DeliveryCostRule Rule being added
     * @return void
     */
    public function addRule(DeliveryCostRule $DeliveryCostRule)
    {
        $this->_deliveryCostRuleArray[]=$DeliveryCostRule;
    }

    /**
     * @return array<DeliveryCostRule> Array of Offers in the database
     */
    public function allRules() : array
    {
        return $this->_deliveryCostRuleArray;
    }

    /**
     * @return DeliveryCostRuleList Delivery rules collection object
     */
    public function getDeliveryCostRuleList() : DeliveryCostRuleList
    {
        return new DeliveryCostRuleList($this->allRules());
    }
}