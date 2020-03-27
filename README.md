## Installing
Run:
`composer install`

## Running tests
Run:
`composer test`

...or, for a pretty layout:

`./tests.sh`

## Integrating this library
Ensure that only the service layer of this project is interacted with. You need a product catalogue repository that implements [Domain\Repository\ProductCatalogue\iProductCatalogueRepository](./src/Domain/Repository/ProductCatalogue/iProductCatalogueRepository.php). 