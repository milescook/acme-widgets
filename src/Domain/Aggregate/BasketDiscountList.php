<?php

namespace Domain\Aggregate;
use Domain\ValueObject\BasketDiscount;

class BasketDiscountList
{

    /** @var array<BasketDiscount> $_basketDiscounts Array of BasketDiscounts held */
    private $_basketDiscounts = [];


    /**
     * @param int $offerCount Number of offers used
     * @param int $discountPerOffer The discount in the offer
     */
    public function addDiscountResult($offerCount, $discountPerOffer) : void
    {
        $this->_basketDiscounts[] = new BasketDiscount($offerCount,$discountPerOffer);
    }

    /**
     * @param BasketDiscount $BasketDiscount Basket Discount
     */
    public function add(BasketDiscount $BasketDiscount) : void
    {
        $this->_basketDiscounts[] = $BasketDiscount;
    }

    /**
     * @return int Total discount from all offers
     */
    public function getTotalDiscount() : int
    {
        $totalDiscountCents = 0;
        foreach($this->_basketDiscounts as $thisBasketDiscount)
        {
            $totalDiscountCents += $thisBasketDiscount->getDiscountTotal();
        }

        return $totalDiscountCents;
    }
}
