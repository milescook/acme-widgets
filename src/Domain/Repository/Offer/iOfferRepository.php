<?php

namespace Domain\Repository\Offer;

use Domain\Aggregate\OfferList;
use Domain\Entity\Offer;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

interface iOfferRepository
{
    /**
     * @param Offer $Offer Offer being added
     * @return void
     */
    public function addOffer(Offer $Offer);

    /**
     * @return array<Offer> Array of Offers in the database
     */
    public function allOffers() : array;

    /**
     * @return OfferList Offers list collection object
     */
    public function getOfferList(iProductCatalogueRepository $ProductCatalogueRepository) : OfferList;
}