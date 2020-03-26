<?php

namespace Domain\ValueObject;

interface iOfferType
{
    /**
     * @return string Name of this offer type
     */
    public function getOfferTypeName() : string;

    
}