<?php

namespace Domain\Service;

use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

class AcmeWidgetSales
{
    /** @var iProductCatalogueRepository ProductCatalogueRepository The Product Catalogue Repository the service will use  */
    var $ProductCatalogueRepository;

    /**
     * @param iProductCatalogueRepository $ProductCatalogueRepository The Catalogue Repository to be injected in
     */
    public function __construct(iProductCatalogueRepository $ProductCatalogueRepository)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
    }
}
