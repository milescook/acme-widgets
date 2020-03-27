## Installing
Run:
`composer install`

## Running tests
Run:
`composer test`

...or, for a pretty layout:

`./tests.sh`

## Integrating this library
Ensure that only the service layer of this project is interacted with. To initialise the AcmeWidgetsService, you need a product catalogue repository that implements [Domain\Repository\ProductCatalogue\iProductCatalogueRepository](./src/Domain/Repository/ProductCatalogue/iProductCatalogueRepository.php). Optional are Delivery Rules and Offer Rules (also both repositories). 

Then, simply call it's exposed addToBasket method, with product code and quantity parameters. Then call the calculateTotalCost to get the cost.

## Considerations
This implementation has followed Domain Driven Design principals, in order to abstract the business logic from any implementation using this bounded context. Arguably, Offers is such a potentially complicated area it could justifiably be it's own BC seperate from the Checkout, with more offer types. 

Offers follows the Strategy pattern in order to provide flexibility in the future for more offer types (e.g. buy 2a, get 1 b free), as the Offer logic sits in the class. The current offers logic doesn't cater for offers comprising of multiple product types. However, in the brief it says the "The company are experimenting with special offers", so following YAGNI principals, the inital offer of single product types is supported and the code can be extended with ease as it is de-coupled.

## Future
This codebase provides a way of providing the required business logic in a portable manner. It should be a library from which a shell application (e.g. an API) would include as a dependency, in  this case through composer.