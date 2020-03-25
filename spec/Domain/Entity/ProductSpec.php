<?php

namespace spec\Domain\Entity;

use Domain\Entity\Product;
use PhpSpec\ObjectBehavior;

class ProductSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("G01","Green Widget",2495);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_should_be_instantiated_with_minimum_fields()
    {
        $this->beConstructedWith("R01","Red Widget",3295);
        $this->name->shouldBe("Red Widget");
        $this->code->shouldBe("R01");
        $this->priceCents->shouldBe(3295);
    }
}
