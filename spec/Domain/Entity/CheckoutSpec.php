<?php

namespace spec\Domain\Entity;

use Domain\Entity\{Checkout,Product};
use Domain\Aggregate\DeliveryCostRuleList;
use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use PhpSpec\ObjectBehavior;

class CheckoutSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $producta = new Product("B01","Blue Widget",795);
        $productb = new Product("G01","Green Widget",2495);
        $productc = new Product("R01","Red Widget",3295);
        $ProductCatalogueRepositoryMemory = new ProductCatalogueRepositoryMemory();
        $ProductCatalogueRepositoryMemory->addProduct($producta);
        $ProductCatalogueRepositoryMemory->addProduct($productb);
        $ProductCatalogueRepositoryMemory->addProduct($productc);
        $this->beConstructedWith($ProductCatalogueRepositoryMemory);
        
        $this->shouldHaveType(Checkout::class);
    }

    function it_applies_delivery_cost_rules(DeliveryCostRuleList $DeliveryCostRuleList)
    {
        $DeliveryCostRuleList->getDeliveryCostOnBasketCost(3295)->willReturn(495);
        
    }
}
