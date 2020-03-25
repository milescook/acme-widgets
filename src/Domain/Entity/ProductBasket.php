<?php

namespace Domain\Entity;

class ProductBasket
{
    /** @var array<int> _productQuantityArray The Product Basket array, with the key being the product code  */
    private $_productQuantityArray = [];

    /** @var array<Product> _basketProducts An array of basket Product contents  */
    private $_basketProducts = [];


    /** @var int _basketCount The Current basket count  */
    private $_basketCount = 0;

    /**
     * @param Product $product The product object
     * @param int $quantity Number of products
     */
    public function addProduct(Product $product, int $quantity) : void
    {
        $this->_basketCount += $quantity;
        
            
        if(!isset($this->_productQuantityArray[$product->code]))
        {
            $this->_productQuantityArray[$product->code] = $quantity;
            $this->_basketProducts[$product->code] = $product; 
        }
        else
            $this->_productQuantityArray[$product->code] += $quantity;
    }

    /**
     * @return array<Product> Get basket contents
     */
    public function getBasketContents() : array
    {
        return $this->_basketProducts;
    }

    /**
     * @param string $productCode Product code
     * @return int Product quantity
     */
    public function getProductQuantityByCode($productCode) : int
    {
        return $this->_productQuantityArray[$productCode];
    }

    /**
     * @return int Current Basket Quantity
     */
    public function getBasketCount() : int
    {
        return $this->_basketCount;
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
