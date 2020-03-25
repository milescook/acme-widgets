<?php 

namespace Domain\Repository\ProductCatalogue;

use Domain\Entity\Product;

class ProductCatalogueRepositoryMemory implements iProductCatalogueRepository
{
    /** @var array<Product> productArray */
    private $productArray = [];
    
    public function addProduct(\Domain\Entity\Product $product)
    {
        $this->productArray[$product->code] = $product;
    }

    /**
     * @return array<\Domain\Entity\Product> Array of Products in the database
     */
    public function allProducts(): array
    {
        return $this->productArray;
    }
    
}