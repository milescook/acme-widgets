<?php

namespace spec\Domain\Entity;

use Domain\Entity\Offer;
use Domain\ValueObject\OfferType\iOfferType;
use PhpSpec\ObjectBehavior;

class OfferSpec extends ObjectBehavior
{
    function let(iOfferType $OfferType)
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

    function it_can_have_an_offer_strategy_set_at_runtime(iOfferType $OfferType)
    {
        $OfferType->getName()->willReturn("Buy one get one half price");
        $this->setOfferType($OfferType);
        $this->getOfferTypeName()->shouldReturn("Buy one get one half price");
    }

    function it_can_return_an_offer_discount(iOfferType $OfferType)
    {
        $OfferType->setProductPrices((["R01"=>3295]))->shouldbeCalled();
        $OfferType->setProductQuantities((["R01"=>2]))->shouldbeCalled();
        $OfferType->calculateOfferDiscount()->willReturn(1647);
        $this->setOfferType($OfferType);

        $this->setProductCombinations(["R01"=>2]);
        $this->setProductPrice("R01",3295);
        $this->productQualifies("R01")->shouldReturn(true);
        $this->getDiscount()->shouldReturn(1647);
    }

    function it_should_know_if_a_product_combination_qualifies()
    {
        $this->setProductCombinations(["R01"=>2]);

        $resultExpected =
        [
            "matches" => 0
        ];
        
        $this->productCombinationQualifyResult("R01",1)->shouldReturn($resultExpected);

        $resultExpected =
        [
            "matches" => 1,
            "productsUsed" => 2,
            "productsUnused" => 0
        ];
        $this->productCombinationQualifyResult("R01",2)->shouldReturn($resultExpected);
        
    }
}
