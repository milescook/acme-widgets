<?php

namespace Domain\Entity;

use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use Domain\Entity\DeliveryRules\DeliveryRuleCollection;
use Domain\Entity\Offers\OfferCollection;

class Checkout
{
    /** @var iProductCatalogueRepository $ProductCatalogueRepository The Product Catalogue Repository the service will use  */
    var $ProductCatalogueRepository;

    /** @var DeliveryRuleCollection $DeliveryRuleCollection The delivery pricing rules  */
    var $DeliveryRuleCollection;

    /** @var OfferCollection OfferCollection The offer collection  */
    var $OfferCollection;

    function __construct(
        iProductCatalogueRepository $ProductCatalogueRepository, 
        DeliveryRuleCollection $DeliveryRuleCollection = null,
        OfferCollection $OfferCollection=null)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
        $this->DeliveryRuleCollection = $DeliveryRuleCollection;
        $this->OfferCollection = $OfferCollection;
    }


    /**
     * @return int Current Basket Cost in cents
     */
    public function calculateTotalCost(ProductBasket $ProductBasket)
    {
        $totalCost = 0;
        foreach($ProductBasket->getBasketContents() as $thisProduct)
        {
            $quantity = $ProductBasket->getProductQuantityByCode($thisProduct->code);
            $totalCost += 
                $quantity * $thisProduct->priceCents;
        }

        return $totalCost;
    }
}
