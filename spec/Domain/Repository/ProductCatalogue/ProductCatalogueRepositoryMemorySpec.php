<?php

namespace spec\Domain\Repository\ProductCatalogue;

use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use PhpSpec\ObjectBehavior;

class ProductCatalogueRepositoryMemorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductCatalogueRepositoryMemory::class);
    }
}
