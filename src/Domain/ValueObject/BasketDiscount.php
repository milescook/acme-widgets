<?php

namespace Domain\ValueObject;

class BasketDiscount
{
    /** @var int $_offerCount How many times an offer was used for this discount */
    private $_offerCount;

     /** @var int $_discount The individual offer discount in cents */
    private $_discount;

    /**
     * @param int $offerCount How many times an offer was used
     * @param int $discount The individual offer discount in cents
     */
    function __construct(int $offerCount,int $discount)
    {
        $this->_offerCount = $offerCount;
        $this->_discount = $discount;
    }

    /**
     * @return int Total offer worth in cents
     */
    function getDiscountTotal() : int
    {
        return $this->_offerCount * $this->_discount;
    }
}
