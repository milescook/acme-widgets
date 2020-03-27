<?php

namespace Domain\Repository\Offer;

use Domain\Entity\Offer;
use Domain\Aggregate\OfferList;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

class OfferRepositoryMemory implements iOfferRepository
{
    /** @var array<Offer> offerArray */
    private $_offerArray = [];
    
    public function addOffer(Offer $offer) : void
    {
        $this->_offerArray[] = $offer;
    }

    /**
     * @return array<Offer> Array of Offers in the database
     */
    public function allOffers(): array
    {
        return $this->_offerArray;
    }

    /**
     * @return OfferList Offers list collection object
     */
    public function getOfferList(iProductCatalogueRepository $ProductCatalogueRepository) : OfferList
    {
        $OfferList = new OfferList($ProductCatalogueRepository);
        $OfferList->setOfferArray($this->allOffers());

        return $OfferList;
    }

}