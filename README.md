# Teamleader Test, Problem 1

## Usage

You need to have composer installed to run this application

Built using PHP 8.3+. It requires composer to work.

First, install the dependencies needed via composer:

    composer install

Then, run the console debugger in the root of the project to check that the route to the API endpoint (GET /api/discounts/calculate) is properly set:

    php bin/console debug:router

You should be able to run all of its tests after that, with:

    php bin/phpunit

After that, first let's create the database (sqlite):

    php bin/console doctrine:database:create

And then execute the migrations:

    php bin/console doctrine:migrations:migrate

Finally, you can load the fixtures with all the initial products data:

    php bin/console doctrine:fixtures:load

Now you can run the Symfony local server to check it out

    symfony server:start

Using curl, send a GET request to http://127.0.0.1:8000/api/discounts/calculate, with a JSON request body with the order you want to check the discounts, as given in https://github.com/teamleadercrm/coding-test/tree/master/example-orders. Be sure to include the Content-type and Accept headers with the application/json value. For example:

		curl --location --request GET http://127.0.0.1:8000/api/discounts/calculate --header 'Content-Type: application/json' --header 'Accept: application/json' --data-raw '{"id": "1", "customer-id": "1", "items": [{"product-id": "B102", "quantity": "10", "unit-price": "4.99", "total": "49.90"}], "total": "49.90"}'

And that's it! Enjoy tinkering and sending different orders to check the different discounts.