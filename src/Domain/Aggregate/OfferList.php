<?php

namespace Domain\Aggregate;

use Domain\Entity\Offer;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use Domain\Aggregate\BasketDiscountList;
use Domain\ValueObject\OfferType\iOfferType;
use Domain\ValueObject\BasketDiscount;

class OfferList
{
    /** @var array<Offer> $_offers Offers */
    var $_offers = [];

    /** @var array<int> $_productPrices Product prices */
    var $_productPrices = [];

    /** @var \Domain\Repository\ProductCatalogue\iProductCatalogueRepository $ProductCatalogueRepository Product catalogue repository */
    var $ProductCatalogueRepository;


    /**
     * @param iProductCatalogueRepository $ProductCatalogueRepository Product catalogue repository
     */
    function __construct(iProductCatalogueRepository $ProductCatalogueRepository)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
    }

    /**
     * @param array<int> $productPrices Array of product prices indexed by product code
     */
    public function setProductPrices(array $productPrices) : void
    {
        $this->_productPrices = $productPrices;
    }

    /**
     * @param string $type Offer type
     * @param array<int> $productCombinations Array of product combinations indexed by product code
     */
    public function addOffer(string $type,array $productCombinations) : void
    {
        $Offer = new Offer(Offer::getOfferTypeFromString($type));
        $Offer->setProductCombinations($productCombinations);
        foreach($productCombinations as $productCode=>$quantity)
        {
            $Product = $this->ProductCatalogueRepository->getProduct($productCode);
            $Offer->setProductPrice($productCode,$Product->priceCents);
        }

        $this->_offers[] = $Offer;
    }

    /**
     * @param array<Offer> $offerArray Offer array
     */
    public function setOfferArray(array $offerArray) : void
    {
         $this->_offers = $offerArray;
        
    }
    /**
     * @param array<int> $productCounts Array of product counts indexed by product code
     * @return BasketDiscountList Discount for these products 
     */
    public function getBasketDiscountListUsingProductItems(array $productCounts) : BasketDiscountList
    {
        $BasketDiscountList = new BasketDiscountList();

        foreach($this->_offers as $thisOffer)
        {
            foreach($this->getQualifyingBasketDiscounts($thisOffer,$productCounts) as $BasketDiscount)
                $BasketDiscountList->add($BasketDiscount);
        }
        return $BasketDiscountList;
    }


    /**
     * @param Offer $Offer The offer
     * @param array<int> $productCounts The product quantities indexed by product code
     * @return array<BasketDiscount> The qualifying discounts
     */
    function getQualifyingBasketDiscounts(Offer $Offer, array $productCounts) : array
    {
        $qualifyingBasketDiscounts = [];
        
        foreach($productCounts as $productCode=>$productCount)
        {
            $occurancesOfferMatchedResult = $Offer->productCombinationQualifyResult($productCode,$productCount);
            if($occurancesOfferMatchedResult["matches"]>0)
                $qualifyingBasketDiscounts[] = new BasketDiscount($occurancesOfferMatchedResult['matches'],$Offer->getDiscount());
               
        }
        return $qualifyingBasketDiscounts;
    }

    
}