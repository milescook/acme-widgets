<?php

namespace Domain\Entity;

class ProductBasket
{
    /** @var array<int> _productBasket The Product Basket array, with the key being the product code  */
    private $_productBasket;

    /** @var int _basketCount The Current basket count  */
    private $_basketCount = 0;

    /**
     * @param Product $product The product object
     * @param int $quantity Number of products
     */
    public function addProduct(Product $product, int $quantity) : void
    {
        $this->_basketCount += $quantity;

        if(!isset($this->_productBasket[$product->code]))
            $this->_productBasket[$product->code] = $quantity;
        else
            $this->_productBasket[$product->code] += $quantity;
    }

    /**
     * @return int Current Basket Quantity
     */
    public function getBasketCount() : int
    {
        return $this->_basketCount;
    }
}
