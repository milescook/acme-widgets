<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Aggregate\{DeliveryCostRuleList,Offerlist};
use Domain\Entity\{DeliveryCostRule,Offer};
use Domain\Entity\Product;
use Domain\Entity\ProductBasket;
use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use Domain\Service\AcmeWidgetsService;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    var $ProductCatalogueRepository;
    var $AcmeWidgetsService;
    var $ProductBasket;


    private function getProductCatalogueRepository($catalogue)
    {
        $ProductCatalogueRepository = new ProductCatalogueRepositoryMemory(); 
        $testProductCatalogueString = file_get_contents("features/bootstrap/product-catalogue.json");
        $testProductCatalogueObject = json_decode($testProductCatalogueString);

        foreach($testProductCatalogueObject->{$catalogue} as $productObject)
        {
            $ProductCatalogueRepository->addProduct(
                new Product(
                $productObject->code,
                $productObject->name,
                $productObject->priceCents));
        }

        return $ProductCatalogueRepository;
    }

    private function getDeliveryRuleList($testName)
    {
        $testDeliveryCostRulesString = file_get_contents("features/bootstrap/delivery-cost-rules.json");
        $testDeliveryCostRulesObject = json_decode($testDeliveryCostRulesString);
      
        $deliveryCostRulesArray = [];
        foreach($testDeliveryCostRulesObject->{$testName} as $deliveryRuleObject)
        {
            $deliveryCostRulesArray[] = new DeliveryCostRule(
                $deliveryRuleObject->deliveryCost,
                $deliveryRuleObject->minBasket,
                (isset($deliveryRuleObject->maxBasket)?$deliveryRuleObject->maxBasket:null));
        }
        $DeliveryCostRuleList = new DeliveryCostRuleList($deliveryCostRulesArray);

        return $DeliveryCostRuleList;
    }

    function getOfferList($testName,$ProductCatalogueRepository)
    {
        $offerListString = file_get_contents("features/bootstrap/offers.json");
        $offerListObject = json_decode($offerListString);
        $Offerlist = new OfferList($ProductCatalogueRepository);
        foreach($offerListObject->{$testName} as $offerObject)
        {
            $productCombinationsArray = [];
            foreach($offerObject->productCombinations as $thisCombinationObject)
                $productCombinationsArray[$thisCombinationObject->code] = $thisCombinationObject->quantity;
            $Offerlist->addOffer($offerObject->type,$productCombinationsArray);
        }

        return $Offerlist;
    }
    /**
     * @Given I have the service initialised with test data :testName
     */
    public function iHaveTheServiceInitialisedWithTestData($testName)
    {
        $ProductCatalogueRepository = $this->getProductCatalogueRepository($testName);
        $DeliveryCostRuleList = $this->getDeliveryRuleList($testName);
        $OfferList = $this->getOfferList($testName,$ProductCatalogueRepository);
        $this->AcmeWidgetsService = new AcmeWidgetsService($ProductCatalogueRepository,$DeliveryCostRuleList,$OfferList);
    }

    /**
     * @Given my basket contains :quantity of the product :productCode
     */
    public function myBasketContainsOfTheProduct($productCode, $quantity)
    {
        $this->AcmeWidgetsService->addToBasket($productCode,$quantity);
    }

    /**
     * @When I request the total basket total including delivery and offer discounts
     */
    public function iRequestTheTotalBasketTotalIncludingDeliveryAndOfferDiscounts()
    {
        $this->basketPrice = $this->AcmeWidgetsService->calculateTotalCost();
    }

    /**
     * @Then I should get the price in cents :priceCents
     */
    public function iShouldGetThePriceInCents($priceCents)
    {
        if($this->basketPrice != $priceCents)
            throw new \Exception("Expected ".$priceCents." but got ".$this->basketPrice);
    }
    
}
