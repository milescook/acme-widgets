<?php

namespace Domain\Entity;

use Domain\Valueobject\OfferType;

class Offer
{
    /** @var array<int> $_productPrices Product prices, needed to detect which is the cheapest item etc */
    private $_productPrices = [];
    
    /** @var array<int> $_productCombinations Product combinations, as an array of quantities needed indexed by their product code */
    private $_productCombinations = [];

    /** @var OfferType $OfferType The type for this offer */
    var $OfferType;

    /** @param OfferType $OfferType The type for this offer */
    function __construct(OfferType $OfferType)
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
}
