<?php

namespace Domain\Service;

use Domain\Entity\{ProductBasket,Checkout};
use Domain\Entity\Offers\OfferCollection;
use Domain\Aggregate\DeliveryCostRuleList;
use Domain\Repository\ProductCatalogue\iProductCatalogueRepository;

class AcmeWidgetSales
{
    /** @var ProductBasket $_productBasket The Current basket  */
    private $_productBasket;

    /** @var iProductCatalogueRepository ProductCatalogueRepository The Product Catalogue Repository the service will use  */
    var $ProductCatalogueRepository;

    /** @var Checkout Checkout The Checkout which will do the calculations  */
    var $Checkout;
    
    /**
     * @param iProductCatalogueRepository $ProductCatalogueRepository The Catalogue Repository to be injected in
     */
    public function __construct(
        iProductCatalogueRepository $ProductCatalogueRepository, 
        DeliveryCostRuleList $DeliveryCostRuleList=null, 
        OfferCollection $OfferCollection=null)
    {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
        $this->_productBasket = new ProductBasket;

        $this->Checkout = new Checkout($ProductCatalogueRepository, $DeliveryCostRuleList, $OfferCollection);
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
    public function calculateTotalCost()
    {
        return $this->Checkout->calculateTotalCost($this->_productBasket);
    }

    /**
     * @return void Empties current basket
     */
    public function emptyBasket() : void
    {
        $this->_productBasket->empty();
    }

    
}
