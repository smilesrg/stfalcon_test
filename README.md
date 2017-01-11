Images API
========================


Installation
--------------
To run this application, you need to do following after cloning the repository
```bash
composer install
app/console doctrine:database:create
app/console doctrine:schema:create
app/console doctrine:fixtures:load --no-interaction
app/console server:run
```

Then you'll be able to read the docs of the API by accessing following url: http://localhost:8000/api/doc

Running functional and unit tests
--------------

To run functional and unit tests, you need to set up test database first
```bash
app/console doctrine:database:create -e test
app/console doctrine:schema:create -e test
app/console doctrine:fixtures:load -e test --no-interaction
```

You can do it only once, you don't have to do it each time before running the test. To execute tests, run following
```bash
bin/phpunit -c app
```
