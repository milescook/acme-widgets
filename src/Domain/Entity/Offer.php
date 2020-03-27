<?php

namespace Domain\Entity;

use Domain\ValueObject\OfferType\iOfferType;

class Offer
{
    /** @var array<int> $_productPrices Product prices, needed to detect which is the cheapest item etc */
    private $_productPrices = [];
    
    /** @var array<int> $_productCombinations Product combinations, as an array of quantities needed indexed by their product code */
    private $_productCombinations = [];

    /** @var iOfferType $OfferType The type for this offer */
    var $OfferType;



    /** @param iOfferType $OfferType The type for this offer */
    function __construct(iOfferType $OfferType=null) 
    {
        $this->setOfferType($OfferType);
    }

    /** @param iOfferType $OfferType The type for this offer */
    public function setOfferType(iOfferType $OfferType) : void
    {
        $this->OfferType = $OfferType;
    }

    /**
     * @param array<int> $productCombinations 
     * Array of Product quantities index by their code, that qualify this offer
     */
    public function setProductCombinations(array $productCombinations) : void
    {
        $this->_productCombinations = $productCombinations;
    }

    /**
     * @param string $productCode Product code to search this offer for
     * @return bool Whether the product is in this offer
     * Array of Product quantities index by their code, that qualify this offer, for the given product code
     */
    public function productQualifies($productCode) : bool
    {
        foreach($this->_productCombinations as $productCombinationCode=>$quantity)
        {
            if($productCombinationCode==$productCode)
                return true;
        }
        return false;
    }

    /**
     * @param string $productCode Product code to search this offer for
     * @param int $quantity Quantity
     * @return array<int> Occurance results of the offer qualify
     */
    public function productCombinationQualifyResult(string $productCode, int $quantity) : array
    {
        $resultArray =
        [
            "matches" => 0
        ];

        if(!$this->productQualifies($productCode))
            return $resultArray;

        $requiredQuantity = $this->_productCombinations[$productCode];
        if($quantity>=$requiredQuantity)
        {
            $resultArray =
            [
                "matches" => (int) round($quantity / $requiredQuantity,0,PHP_ROUND_HALF_DOWN),
                "productsUsed" => (int) $quantity - ($quantity % $requiredQuantity),
                "productsUnused" => (int) $quantity % $requiredQuantity
            ];
            
            
        }

        return $resultArray;
    }

    /**
     * @return array<string> Array of Product codes to qualify this order
     */
    public function getProductsToQualify() : array
    {
        return array_keys($this->_productCombinations);
    }

     /**
     * @return array<int> Array of Product quantities index by product code, to qualify this order
     */
    public function getProductCombinations()
    {
        return $this->_productCombinations;
    }

    /**
     * @param string $productCode Product code
     * @param int $productPrice Product price
     */
    public function setProductPrice(string $productCode, int $productPrice) : void
    {
        $this->_productPrices[$productCode] = $productPrice;
    }

    /**
     * @param string $productCode Product code
     * @return int Product price
     */
    public function getProductPrice(string $productCode) : int
    {
        if(isset($this->_productPrices[$productCode]))
            return $this->_productPrices[$productCode];
        else
            throw new \Domain\Exceptions\InvalidProductException();
    }
    
    /**
     * @return string Offer type name
     */
    public function getOfferTypeName() : string
    {
        return $this->OfferType->getName();
    }

    /**
     * @return int Discount in cents
     */
    public function getDiscount()
    {
        $this->OfferType->setProductPrices($this->_productPrices);
        $this->OfferType->setProductQuantities($this->_productCombinations);
        return $this->OfferType->calculateOfferDiscount();
    }
}
