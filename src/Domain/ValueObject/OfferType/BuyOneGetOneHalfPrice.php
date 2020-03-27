<?php

namespace Domain\ValueObject\OfferType;

class BuyOneGetOneHalfPrice extends OfferType
{
    /** @var string $name Offer type name */
    var $name = "Buy One, Get one Half Price";
    
    /**
     * @return int Discount in cents using this offer
     */
    public function calculateOfferDiscount() : int
    {
        $productPrice = array_pop($this->_productPrices);
        return (int) round($productPrice / 2);
    }
}