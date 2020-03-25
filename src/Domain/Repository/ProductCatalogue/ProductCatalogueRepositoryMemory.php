<?php 

namespace Domain\Repository\ProductCatalogue;

use Domain\Entity\Product;

class ProductCatalogueRepositoryMemory implements iProductCatalogueRepository
{
    /** @var array<Product> productArray */
    private $_productArray = [];
    
    public function addProduct(\Domain\Entity\Product $product)
    {
        $this->_productArray[$product->code] = $product;
    }

    /**
     * @return array<\Domain\Entity\Product> Array of Products in the database
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