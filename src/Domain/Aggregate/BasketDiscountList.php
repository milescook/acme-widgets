<?php

namespace Domain\Aggregate;

class BasketDiscountList
{

    /** @var array<array <int>> $_discounts Discounts held */
    private $_discounts = [];

    /**
     * @param int $offerCount Number of offers used
     * @param int $discountPerOffer The discount in the offer
     */
    public function addDiscountResult($offerCount, $discountPerOffer) : void
    {
        $this->_discounts[] =
        [
            "offersMatchedCount" => $offerCount,
            "offerDiscount" => $discountPerOffer
        ];
    }

    /**
     * @return int Total discount from all offers
     */
    public function getTotalDiscount() : int
    {
        $totalDiscountCents = 0;
        foreach($this->_discounts as $thisDiscount)
        {
            $totalDiscountCents += $thisDiscount["offersMatchedCount"] * $thisDiscount["offerDiscount"]; 
        }

        return $totalDiscountCents;
    }
}
