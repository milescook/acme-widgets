<?php

namespace spec\Domain\Service;

use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use Domain\Service\AcmeWidgetSales;
use PhpSpec\ObjectBehavior;

class AcmeWidgetSalesSpec extends ObjectBehavior
{
    function let(iProductCatalogueRepository $iProductCatalogueRepositoryTest)
    {
        $this->beConstructedWith($iProductCatalogueRepositoryTest);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(AcmeWidgetSales::class);
    }
}
