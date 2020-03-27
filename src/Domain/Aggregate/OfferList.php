<?php

namespace Domain\Aggregate;

use Domain\Entity\Offer;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;
use Domain\ValueObject\OfferType\iOfferType;

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
        $Offer = new Offer($this->getOfferTypeFromString($type));
        $Offer->setProductCombinations($productCombinations);
        foreach($productCombinations as $productCode=>$quantity)
        {
            $Product = $this->ProductCatalogueRepository->getProduct($productCode);
            $Offer->setProductPrice($productCode,$Product->priceCents);
        }

        $this->_offers[] = $Offer;
    }

    /**
     * @param array<int> $productCounts Array of product counts indexed by product code
     * @return int Discount for these products 
     */
    public function getOfferDiscountUsingProductItems(array $productCounts) : int
    {
        $discount = 0;
        
        foreach($this->_offers as $thisOffer)
        {
            $productCombinationsResult = $this->getQualifyingProductCombinations($thisOffer,$productCounts);
            foreach($productCombinationsResult as $thisResult)
            {
                if(isset($thisResult["offersMatchedCount"]) && $thisResult["offersMatchedCount"]>0)
                    $discount += $thisResult["offersMatchedCount"] * $thisResult["offerDiscount"];
            }
        }

        return $discount;
    }

    /**
     * @param Offer $Offer The offer
     * @param array<int> $productCounts The product quantities indexed by product code
     * @return array<int, array<int|string, int>> The qualifying product combinations
     */
    function getQualifyingProductCombinations(Offer $Offer, array $productCounts) : array
    {
        $qualifyingcombinations = [];
        $offerCombinations = $Offer->getProductCombinations();
        foreach($productCounts as $productCode=>$productCount)
        {
            $occurancesOfferMatchedResult = $Offer->productCombinationQualifyResult($productCode,$productCount);
            if($occurancesOfferMatchedResult["matches"]>0)
            {
                $qualifyingcombinations[] = 
                [
                    "productCode" => $productCode,
                    "productsUsedCount" => $occurancesOfferMatchedResult['productsUsed'],
                    "offersMatchedCount" => $occurancesOfferMatchedResult['matches'],
                    "offerDiscount" => $Offer->getDiscount()
                ];
            }
        }
        return $qualifyingcombinations;
    }

    private function getOfferTypeFromString(string $offerTypeName) : iOfferType
    {
        $offerTypeClass = 'Domain\ValueObject\OfferType\\'.$offerTypeName;
        $OfferType = new $offerTypeClass();

        return $OfferType;
    }
}