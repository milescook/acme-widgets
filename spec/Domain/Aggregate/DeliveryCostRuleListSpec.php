<?php

namespace spec\Domain\Aggregate;

use Domain\Aggregate\DeliveryCostRuleList;
use Domain\Entity\DeliveryCostRule;
use PhpSpec\ObjectBehavior;

class DeliveryCostRuleListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeliveryCostRuleList::class);
    }

    function it_can_use_rules(
        DeliveryCostRule $DeliveryCostRuleA,
        DeliveryCostRule $DeliveryCostRuleB,
        DeliveryCostRule $DeliveryCostRuleC)
    {
        $basketCost = 121;

        $DeliveryCostRuleA->getMinBasketPrice()->willReturn(1);
        $DeliveryCostRuleA->matchesBasketCost($basketCost)->willReturn(true);
       
        $DeliveryCostRuleB->getMinBasketPrice()->willReturn(90);
        $DeliveryCostRuleB->matchesBasketCost($basketCost)->willReturn(true);
      
        $DeliveryCostRuleC->matchesBasketCost($basketCost)->willReturn(false);

        $DeliveryCostRuleB->getDeliveryCost()->willReturn(295);
        $this->beConstructedWith([$DeliveryCostRuleA,$DeliveryCostRuleB]);

        $this->getDeliveryCostOnBasketCost($basketCost)->shouldReturn(295);
    }
}
