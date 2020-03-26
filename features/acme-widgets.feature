Feature: Acme Widgets Basket Calculator
  In order to process customer orders
  As a commerce system
  I need to be able to calculate basket totals

Scenario: Get simple basket
  Given I have the service initialised with test data "standard"
  And my basket contains 1 of the product "B01"
  And my basket contains 1 of the product "G01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "3785"

Scenario: Get another simple basket
  Given I have the service initialised with test data "standard"
  And my basket contains 1 of the product "R01"
  And my basket contains 1 of the product "G01"
  When I request the total basket total including delivery and offer discounts
  Then I should get the price in cents "6085"

