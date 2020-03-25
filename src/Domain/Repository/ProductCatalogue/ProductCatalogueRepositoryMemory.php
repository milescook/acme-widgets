<?php

namespace Domain\Repository\ProductCatalogue;

class ProductCatalogueRepositoryMemory implements iProductCatalogueRepository
{
    private $productArray = [];
    
    public function addProduct(\Domain\Entity\Product $product)
    {
        $this->productArray[$product->code] = $product;
    }

    public function allProducts(): array
    {
        return $this->productArray;
    }
    
}
