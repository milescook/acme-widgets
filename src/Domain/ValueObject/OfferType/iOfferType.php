<?php

namespace Domain\ValueObject\OfferType;

interface iOfferType
{
    /**
     * @return string Name of this offer type
     */
    public function getName() : string;

    /**
     * @param array<int> $productPrices Product prices in cents, indexed by product code
     */
    public function setProductPrices(array $productPrices) : void;

    /**
     * @param array<int> $productQuantities Product quanitiy, indexed by product code
     */
    public function setProductQuantities(array $productQuantities) : void;

    /**
     * @return int Discount in cents using this offer
     */
    public function calculateOfferDiscount() : int;
}