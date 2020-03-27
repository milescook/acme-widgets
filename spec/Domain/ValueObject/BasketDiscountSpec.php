<?php

namespace spec\Domain\ValueObject;

use Domain\ValueObject\BasketDiscount;
use PhpSpec\ObjectBehavior;

class BasketDiscountSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1,1687);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BasketDiscount::class);
    }
}
