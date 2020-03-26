<?php

namespace spec\Domain\Entity;

use Domain\Entity\Offer;
use Domain\ValueObject\OfferType;
use PhpSpec\ObjectBehavior;

class OfferSpec extends ObjectBehavior
{
    function let(OfferType $OfferType)
    {
        $this->beConstructedWith($OfferType);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Offer::class);
    }

    function it_can_set_product_combinations()
    {
        $this->setProductCombinations(["R01"=>2,"B01"=>1]);
        $this->productQualifies("R01")->shouldReturn(true);
        $this->productQualifies("B01")->shouldReturn(true);
        $this->productQualifies("G01")->shouldReturn(false);
    }

    function it_reports_which_products_are_required_in_this_offer()
    {
        $this->setProductCombinations(["R01"=>1,"G01"=>1]);
        $this->getProductsToQualify()->shouldReturn(["R01","G01"]);
    }

    function it_can_determine_what_product_combinations_qualify()
    {
        $this->setProductCombinations(["R01"=>1,"G01"=>2]);
        $this->getProductCombinations()->shouldReturn(["R01"=>1,"G01"=>2]);
    }

    function it_can_set_product_prices()
    {
        $this->setProductPrice("R01",3295);
        $this->getProductPrice("R01")->shouldReturn(3295);
    }

    
}
