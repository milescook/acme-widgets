<?php

namespace Domain\Repository\ProductCatalogue;

interface iProductCatalogueRepository
{
    /**
     * @param \Domain\Entity\Product $product Product being added
     * @return void
     */
    public function addProduct(\Domain\Entity\Product $product);

    /**
     * @param string $productCode The code to get the product by
     * @return \Domain\Entity\Product
     */
    public function getProduct(string $productCode) : \Domain\Entity\Product;

    /**
     * @return array<\Domain\Entity\Product> Array of Products in the database
     */
    public function allProducts() : array;
}