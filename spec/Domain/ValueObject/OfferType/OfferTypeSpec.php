<?php

namespace spec\Domain\ValueObject\OfferType;

use Domain\ValueObject\OfferType\iOfferType;
use PhpSpec\ObjectBehavior;

class OfferTypeSpec extends ObjectBehavior
{
    

    function it_is_initializable()
    {
        $this->shouldHaveType(iOfferType::class);
    }
    
}
