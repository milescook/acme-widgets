Feature: Acme Widgets Basket Calculator
  In order to process customer orders
  As a commerce system
  I need to be able to calculate basket totals

Scenario: Get simple basket - Test 1
  Given I have the service initialised with test data "standard"
  And my basket contains 1 of the product "B01"
  And my basket contains 1 of the product "G01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "3785"

Scenario: Get a basket with a buy 2, get one half price - Test 2
  Given I have the service initialised with test data "standard"
  And my basket contains 2 of the product "R01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "5437"

Scenario: Get a basket with one of each product - Test 3
  Given I have the service initialised with test data "standard"
  And my basket contains 1 of the product "R01"
  And my basket contains 1 of the product "G01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "6085"

Scenario: Get a basket with several products, one on offer - Test 4
  Given I have the service initialised with test data "standard"
  And my basket contains 3 of the product "R01"
  And my basket contains 2 of the product "B01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "9827"

Scenario: Get a basket with multiple buy 2, get one half price deals
  Given I have the service initialised with test data "standard"
  And my basket contains 4 of the product "R01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "9884"


