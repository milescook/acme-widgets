<?php

use Domain\Entity\Product;

namespace Domain\Repository\ProductCatalogue;

interface iProductCatalogueRepository
{
    public function addProduct(\Domain\Entity\Product $product);
    public function allProducts() : array;
}