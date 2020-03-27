<?php

namespace spec\Domain\Aggregate;

use Domain\Aggregate\BasketDiscountList;
use PhpSpec\ObjectBehavior;

class BasketDiscountListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BasketDiscountList::class);
    }

    function it_can_store_a_basket_discount_result()
    {
        $this->addDiscountResult(1,1687);
        $this->getTotalDiscount()->shouldReturn(1687);
    }

    function it_can_store_multiple_basket_discount_results()
    {
        $this->addDiscountResult(2,2000);
        $this->addDiscountResult(1,1687);
        $this->getTotalDiscount()->shouldReturn(5687);
    }
}
