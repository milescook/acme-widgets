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
        if(isset($this->DeliveryCostRuleList))
            $totalCost += $this->DeliveryCostRuleList->getDeliveryCostOnBasketCost($totalCost);
            
        return $totalCost;
    }
}
