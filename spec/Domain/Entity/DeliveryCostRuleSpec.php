<?php

namespace spec\Domain\Entity;

use Domain\Entity\DeliveryCostRule;
use PhpSpec\ObjectBehavior;

class DeliveryCostRuleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(495,5000,8999);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(DeliveryCostRule::class);
    }

    function it_should_be_instantiated_with_params()
    {
        $this->matchesBasketCost(6532)->shouldReturn(true);
        $this->matchesBasketCost(200)->shouldReturn(false);
    }
}
