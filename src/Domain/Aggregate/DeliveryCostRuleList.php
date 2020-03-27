<?php

namespace Domain\Aggregate;

use Domain\Entity\DeliveryCostRule;

class DeliveryCostRuleList
{
    /** @var array<DeliveryCostRule> $_deliveryCostRules  */
    private $_deliveryCostRules = [];

    /**
     * @param array<DeliveryCostRule> $deliveryCostRules Array of DeliveryCostRules
     */
    function __construct(array $deliveryCostRules=null)
    {
        if(isset($deliveryCostRules))
            $this->_deliveryCostRules = $deliveryCostRules;

    }

    function getDeliveryCostOnBasketCost(int $basketCost) : int
    {
        $largestBasketCostRuleMatch = 0;
        $matchingDeliveryCostRule = null;
        foreach($this->_deliveryCostRules as $thisDeliveryCostRule)
        {
            $ruleMinBasketPrice = $thisDeliveryCostRule->getMinBasketPrice();
            if($ruleMinBasketPrice >= $largestBasketCostRuleMatch && $thisDeliveryCostRule->matchesBasketCost($basketCost))
            {
                $largestBasketCostRuleMatch = $ruleMinBasketPrice;
                $matchingDeliveryCostRule = $thisDeliveryCostRule;
            }
        }

        if(isset($matchingDeliveryCostRule)) 
            return $matchingDeliveryCostRule->getDeliveryCost();
        
        return 0;
    }
}