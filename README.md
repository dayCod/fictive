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
5. Returning string as a result.

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
