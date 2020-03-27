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


    function it_is_initializable()
    {
        $this->shouldHaveType(OfferList::class);
    }
}
