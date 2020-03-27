<?php

namespace Domain\Repository\DeliveryCostRule;

use Domain\Aggregate\DeliveryCostRuleList;
use Domain\Entity\DeliveryCostRule;

interface iDeliveryCostRuleRepository
{
    /**
     * @param DeliveryCostRule $DeliveryCostRule Rule being added
     * @return void
     */
    public function addRule(DeliveryCostRule $DeliveryCostRule);

    /**
     * @return array<DeliveryCostRule> Array of Offers in the database
     */
    public function allRules() : array;

    /**
     * @return DeliveryCostRuleList Delivery rules collection object
     */
    public function getDeliveryCostRuleList() : DeliveryCostRuleList;
}