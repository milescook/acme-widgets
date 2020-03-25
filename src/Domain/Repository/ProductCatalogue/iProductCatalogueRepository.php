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
     * @return array<\Domain\Entity\Product> Array of Products in the database
     */
    public function allProducts() : array;
}