<?php

namespace spec\Domain\Entity;

use Domain\Entity\ProductBasket;
use PhpSpec\ObjectBehavior;

class ProductBasketSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductBasket::class);
    }
}
