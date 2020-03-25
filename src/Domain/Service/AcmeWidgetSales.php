<?php

namespace Domain\Service;

use Domain\Entity\ProductBasket;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

class AcmeWidgetSales
{
    /** @var ProductBasket $_productBasket The Current basket  */
    private $_productBasket;

    /** @var iProductCatalogueRepository ProductCatalogueRepository The Product Catalogue Repository the service will use  */
    var $ProductCatalogueRepository;

    /**
     * @param iProductCatalogueRepository $ProductCatalogueRepository The Catalogue Repository to be injected in
     */
    public function __construct(iProductCatalogueRepository $ProductCatalogueRepository)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
        $this->_productBasket = new ProductBasket;
    }

    /**
     * @param string $productCode The Product Code to add
     * @param int $quantity The Product Code to add
     */
    public function addToBasket(string $productCode, int $quantity) : void
    {
        $Product = $this->ProductCatalogueRepository->getProduct($productCode);
        $this->_productBasket->addProduct($Product, $quantity);
        
    }

    /**
     * @return int Current Basket Quantity
     */
    public function getBasketCount() : int
    {
        return $this->_productBasket->getBasketCount();
    }

    /**
     * @return int Current Basket Price in cents
     */
    public function getBasketTotalPrice()
    {
        return $this->calculateBasketPrice();
    }

    /**
     * @return int Current Basket Price in cents
     */
    private function calculateBasketPrice()
    {
        $basketPrice = 0;

        return $basketPrice;
    }
}
