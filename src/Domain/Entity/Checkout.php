<?php

namespace Domain\Entity;

use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use Domain\Aggregate\{DeliveryCostRuleList,OfferList};

class Checkout
{
    /** @var iProductCatalogueRepository $ProductCatalogueRepository The Product Catalogue Repository the service will use  */
    var $ProductCatalogueRepository;

    /** @var DeliveryCostRuleList $DeliveryCostRuleList The delivery pricing rules  */
    var $DeliveryCostRuleList;

    /** @var OfferList OfferList The offers list  */
    var $OfferList;

    function __construct(
        iProductCatalogueRepository $ProductCatalogueRepository, 
        DeliveryCostRuleList $DeliveryCostRuleList = null,
        OfferList $OfferList=null)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
        $this->DeliveryCostRuleList = $DeliveryCostRuleList;
        $this->OfferList = $OfferList;
    }


    /**
     * @return int Current Basket Cost in cents
     * This is the entry point for all logic
     */
    public function calculateTotalCost(ProductBasket $ProductBasket)
    {
        $totalCost = $this->calculateBasketCost($ProductBasket);
        $totalCost -= $this->getOffersDiscount($ProductBasket);
        $totalCost += $this->getDeliveryCost($totalCost);
        
        return $totalCost;
    }

    /**
     * @param ProductBasket $ProductBasket The basket
     * @return int Total cost
     */
    private function calculateBasketCost(ProductBasket $ProductBasket) : int
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

    /**
     * @param ProductBasket $ProductBasket The basket
     * @return int Total discount
     */
    private function getOffersDiscount($ProductBasket) : int
    {
        if(isset($this->OfferList))
            return $this->OfferList->getOfferDiscountUsingProductItems($ProductBasket->getProductCounts());

        return 0;
    }

    /**
     * @param int $totalCost The basket cost in cents
     * @return int Total discount
     */
    private function getDeliveryCost($totalCost) : int
    {
        if(isset($this->DeliveryCostRuleList))
            return $this->DeliveryCostRuleList->getDeliveryCostOnBasketCost($totalCost);
        
        return 0;
    }
}
