<?php

namespace Domain\ValueObject\OfferType;

class OfferType implements iOfferType
{
    /** @var string $name Offer type name */
    var $name = "";

    /** @var array<int> $_productPrices Product prices */
    protected $_productPrices = [];

    /** @var array<int> $_productQuantities Product quantities */
    protected $_productQuantities = [];

    /**
     * @return string Offer type name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param array<int> $productPrices Product prices in cents, indexed by product code
     */
    public function setProductPrices(array $productPrices) : void
    {
        $this->_productPrices = $productPrices;
    }

    /**
     * @param array<int> $productQuantities Product quanitiy, indexed by product code
     */
    public function setProductQuantities(array $productQuantities) : void
    {
        $this->_productQuantities = $productQuantities;
    }

    /**
     * @return int Discount in cents using this offer
     */
    public function calculateOfferDiscount() : int
    {
        return 0;
    }
}