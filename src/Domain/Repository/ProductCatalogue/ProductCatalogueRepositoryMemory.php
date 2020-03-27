<?php 

namespace Domain\Repository\ProductCatalogue;

use Domain\Exceptions\InvalidProductException;
use Domain\Entity\Product;

class ProductCatalogueRepositoryMemory implements iProductCatalogueRepository
{
    /** @var array<Product> productArray */
    private $_productArray = [];
    
    /**
     * @param Product $product Product to add
     */
    public function addProduct(\Domain\Entity\Product $product) : void
    {
        $this->_productArray[$product->code] = $product;
    }

    /**
     * @return array<Product> Array of Products in the database
     */
    public function allProducts(): array
    {
        return $this->_productArray;
    }

    /**
     * @return \Domain\Entity\Product Product by that code
     */
    public function getProduct(string $productCode) : \Domain\Entity\Product
    {
        if(isset($this->_productArray[$productCode]))
            return $this->_productArray[$productCode];
        
        throw new InvalidProductException("Could not find product " . $productCode);
    }

}