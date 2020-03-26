<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Aggregate\DeliveryCostRuleList;
use Domain\Entity\DeliveryCostRule;
use Domain\Entity\Product;
use Domain\Entity\ProductBasket;
use Domain\Repository\ProductCatalogue\ProductCatalogueRepositoryMemory;
use Domain\Service\AcmeWidgetSales;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    var $ProductCatalogueRepository;
    var $AcmeWidgetsService;
    var $ProductBasket;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        
    }

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

    /**
     * @Given I have the service initialised with test data :testName
     */
    public function iHaveTheServiceInitialisedWithTestData($testName)
    {
        $ProductCatalogueRepository = $this->getProductCatalogueRepository($testName);
        $DeliveryCostRuleList = $this->getDeliveryRuleList($testName);
        $this->AcmeWidgetsService = new AcmeWidgetSales($ProductCatalogueRepository,$DeliveryCostRuleList);
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
