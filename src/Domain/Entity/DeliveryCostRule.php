<?php

namespace Domain\Entity;

class DeliveryCostRule
{
    /** @var int $minBasketPrice Minimum basket price */
    var $minBasketPrice;

    /** @var int $deliveryCost Delivery cost in this rule */
    var $deliveryCost;

    /**
     * @param int $minBasketPrice The minimum basket price to qualify for this rule
     * @param int $deliveryCost The cost of delivery in this rule
     */
    public function __construct($minBasketPrice, $deliveryCost)
    {
        $this->minBasketPrice = $minBasketPrice;
        $this->deliveryCost = $deliveryCost;
    }

    /**
     * @param int $basketPrice The basket price check for qualification against this rule
     */
    public function matchesBasketCost($basketPrice) : bool
    {
        return ($basketPrice >= $this->minBasketPrice);
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
