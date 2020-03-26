<?php

namespace spec\Domain\ValueObject;

use Domain\ValueObject\OfferType;
use PhpSpec\ObjectBehavior;

class OfferTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OfferType::class);
    }
    
}
