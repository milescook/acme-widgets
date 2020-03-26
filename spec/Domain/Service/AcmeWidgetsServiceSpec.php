<?php

namespace spec\Domain\Service;

use Domain\Entity\Product;
use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use Domain\Exceptions\InvalidProductException;
use Domain\Service\AcmeWidgetsService;
use PhpSpec\ObjectBehavior;

class AcmeWidgetsServiceSpec extends ObjectBehavior
{
    function let()
    {
        $producta = new Product("B01","Blue Widget",795);
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
        $this->shouldHaveType(AcmeWidgetsService::class);
    }

    function it_adds_to_a_basket()
    {
        $this->addToBasket("R01",1);
        $this->getBasketCount()->shouldReturn(1);

        $this->addToBasket("G01",2);
        $this->getBasketCount()->shouldReturn(3);
    }

    function it_throws_an_exception_if_a_product_code_is_added_to_basket_that_doesnt_exist()
    {
        $this->shouldThrow(new InvalidProductException("Could not find product Z01"))->duringaddToBasket("Z01",1);
    }
    
    // This doesn't include delivery and offers - see behat behavioural tests 
    function it_gets_a_basket_total_price()
    {
        $this->addToBasket("B01",1);
        $this->addToBasket("G01",1);
        $this->calculateTotalCost()->shouldReturn(3290);
    }
    
    
}
