<?php

namespace Domain\Entity;

class DeliveryCostRule
{
    /** @var int $minBasketPrice Minimum basket price */
    var $minBasketPrice;

    /** @var int $maxBasketPrice Maximum basket price */
    var $maxBasketPrice;

    /** @var int $deliveryCost Delivery cost in this rule */
    var $deliveryCost;

    /**
     * @param int $deliveryCost The cost of delivery in this rule
     * @param int $minBasketPrice The minimum basket price to qualify for this rule
     * @param int $maxBasketPrice The minimum basket price to qualify for this rule
     */
    public function __construct($deliveryCost, $minBasketPrice, $maxBasketPrice=null)
    {
        $this->deliveryCost = $deliveryCost;
        $this->minBasketPrice = $minBasketPrice;
        $this->maxBasketPrice = $maxBasketPrice;
    }

    /**
     * @param int $basketPrice The basket price check for qualification against this rule
     */
    public function matchesBasketCost($basketPrice) : bool
    {
        if($basketPrice < $this->minBasketPrice)
            return false;
        
        if(isset($this->maxBasketPrice) && $basketPrice > $this->maxBasketPrice)
            return false;
        
        return true;
            
    }

    public function getMaxBasketPrice() : int
    {
        return $this->maxBasketPrice;
    }

    public function getMinBasketPrice() : int
    {
        return $this->minBasketPrice;
    }

    public function getDeliveryCost() : int
    {
        return $this->deliveryCost;
    }

}
