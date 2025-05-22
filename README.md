# Fictive

Have you ever wanted to test a running system to see if it can handle millions of records, but found that the large amount of data often confuses QA testers because it doesn’t look realistic? That’s exactly why Fictive is here — a solution to generate dummy data that actually feels real.

After you clone this repo, run the following command:
```
composer install && composer test
```

## How it Works

```
1. Setup and Initialize Fictive Functions
2. Parse schema
3. Call the method based on your needs
4. Validate and Normalize the Result of the Method.
5. Caching the result for future use and avoid duplicated data
6. Returning string as a result.

```

## How to Install

1. Install fresh laravel ">10" project as usual
2. Create packages/daycode directory
3. Jump inside packages/daycode directory and clone this repository
4. Run composer install
5. Run composer test
6. Open the root composer.json file
7. And add the following line:

```php
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/",
        "Daycode\\Fictive\\": "packages/daycode/fictive/src/"
    }
},
```

8. Move to your providers file and add the following line:

```php
return [
    App\Providers\AppServiceProvider::class,
    Daycode\Fictive\FictiveServiceProvider::class,
];
```

9. Final step run this following command inside the base of your project:

```
composer dump:autoload
```

## Notes

Before pushing to the main branch, make sure to run these commands:

```
./vendor/bin/rector

./vendor/bin/pint

composer test
```

## Gotchas
```
Keep it simple stupid and don't overthink it.
```
