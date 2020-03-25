<?php

namespace Domain\Entity;

class ProductBasket
{
    /** @var array<int> _productQuantityArray The Product Basket array, with the key being the product code  */
    private $_productQuantityArray = [];

    /** @var int _basketCount The Current basket count  */
    private $_basketCount = 0;

    /** @var array<int> _productPrices All added producxt prices  */
    private $_productPrices = [];

    /**
     * @param Product $product The product object
     * @param int $quantity Number of products
     */
    public function addProduct(Product $product, int $quantity) : void
    {
        $this->_basketCount += $quantity;
        $this->_productPrices[$product->code] = $product->priceCents;

        if(!isset($this->_productQuantityArray[$product->code]))
            $this->_productQuantityArray[$product->code] = $quantity;
        else
            $this->_productQuantityArray[$product->code] += $quantity;
    }

    /**
     * @return int Current Basket Quantity
     */
    public function getBasketCount() : int
    {
        return $this->_basketCount;
    }

    /**
     * @return int Current Basket Cost in cents
     */
    public function calculateTotalCost()
    {
        $totalCost = 0;
        foreach($this->_productQuantityArray as $productCode => $quantity)
        {
            $totalCost += $this->_productPrices[$productCode];
        }

        return $totalCost;
    }

    /**
     * @return void Empties itself
     */
    public function empty()
    {
        $this->_basketCount = 0;
        $this->_productQuantityArray = [];
    }
}
