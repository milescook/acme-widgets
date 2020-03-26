<?php

namespace Domain\ValueObject;

class OfferType implements iOfferType
{
    /** @var string $name Offer type name */
    var $name = "";

    /**
     * @return string Offer type name
     */
    public function getOfferTypeName() : string
    {
        return $this->name;
    }
}