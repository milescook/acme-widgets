<?php

namespace Domain\Repository\Offer;

use Domain\Aggregate\OfferList;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

interface iOfferRepository
{
    /**
     * @param \Domain\Entity\Offer $offer Offer being added
     * @return void
     */
    public function addOffer(\Domain\Entity\Offer $offer);

    /**
     * @return array<\Domain\Entity\Offer> Array of Offers in the database
     */
    public function allOffers() : array;

    public function getOfferList(iProductCatalogueRepository $ProductCatalogueRepository) : OfferList;
}