<?php

namespace spec\Domain\Aggregate;

use Domain\Aggregate\OfferList;
use Domain\Entity\Offer;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use PhpSpec\ObjectBehavior;

class OfferListSpec extends ObjectBehavior
{
    function let(iProductCatalogueRepository $ProductCatalogueRepository)
    {
        $this->beConstructedWith($ProductCatalogueRepository);
    }

    function it_can_return_qualifying_product_combinations_from_offers(Offer $Offer)
    {
        $combinationResult =
        [
            "matches" => 1,
            "productsUsed" => 2,
            "productsUnused" => 0
        ];

        $Offer->productQualifies("R01")->willReturn(true);
        $Offer->productCombinationQualifyResult("R01",2)->willReturn($combinationResult);
        $Offer->getProductCombinations()->willReturn(["R01"=>2]);
        $Offer->getDiscount()->willReturn(50);
        $productCounts = ["R01"=>2];

        $expectedResult = 
        [
            [
                "offersMatchedCount" => 1,
                "offerDiscount" => 50
            ]
        ];
        $this->getQualifyingDiscounts($Offer,$productCounts)->shouldReturn($expectedResult);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OfferList::class);
    }
}
