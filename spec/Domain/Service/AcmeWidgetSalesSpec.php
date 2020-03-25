<?php

namespace spec\Domain\Service;

use Domain\Entity\Product;
use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use Domain\Service\AcmeWidgetSales;
use PhpSpec\ObjectBehavior;

class AcmeWidgetSalesSpec extends ObjectBehavior
{
    function let()
    {
        $producta = new Product("B01","Blue Widget",3785);
        $productb = new Product("G01","Green Widget",2495);
        $productc = new Product("R01","Red Widget",3295);
        $ProductCatalogueRepositoryMemory = new ProductCatalogueRepositoryMemory();
        $ProductCatalogueRepositoryMemory->addProduct($producta);
        $ProductCatalogueRepositoryMemory->addProduct($productb);
        $ProductCatalogueRepositoryMemory->addProduct($productc);
        $this->beConstructedWith($ProductCatalogueRepositoryMemory);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(AcmeWidgetSales::class);
    }

    function it_adds_to_a_basket()
    {
        $this->addToBasket("R01",1);
        $this->getBasketCount()->shouldReturn(1);

        $this->addToBasket("G01",2);
        $this->getBasketCount()->shouldReturn(3);
    }
    /*
    function it_gets_a_basket_total_price()
    {
        $this->addToBasket("RO1",1);
        $this->addToBasket("GO1",1);
        $this->getBasketTotalPrice()->shouldReturn(3785);
    }
    */
}
