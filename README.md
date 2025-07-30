# Fictive

Fictive is a Laravel package designed to generate realistic dummy data for testing large-scale systems. Unlike traditional data generators, Fictive creates data that feels real, helping QA testers avoid confusion and enabling more effective testing scenarios.

## Features

- Generate millions of realistic records for testing
- Schema-based data generation
- Data validation and normalization
- Caching to avoid duplicate data
- Simple integration with Laravel

## How It Works

1. Setup and initialize Fictive functions
2. Parse your schema
3. Call the desired method to generate data
4. Validate and normalize the result
5. Cache the result for future use
6. Return the generated data as a string

## Installation

## Usage Example

You can use Fictive in your services, factories, or seeders. Example:

```php
use Daycode\Fictive\Fictive;

$handlePersons = app(Fictive::class)
    ->count(3)
    ->withFields([
        'full_name' => 'indonesian male name',
        'hobby' => 'indoor hobbies',
        'email' => 'using domain @gmail.com',
    ])
    ->handlePersons();

$handlePersons(function ($person) {
    User::create([
        'name' => $person->fullName(),
        'email' => $person->email(),
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'phone_number' => $person->phoneNumber(),
        'religion' => $person->religion(),
        'hobby' => $person->hobby(),
        'blood_group' => $person->bloodGroup(),
        'job_description' => $person->jobTitle(),
    ]);
});
```

Refer to the documentation in the `docs/` folder for more advanced usage and schema definitions.

## Project Structure

- `src/` — Main package source code
  - `DTO/` — Data Transfer Objects
  - `Exceptions/` — Custom exceptions
  - `LLM/` — Language Model Modules
  - `Services/` — Service classes
- `config/` — Package configuration
- `tests/` — Unit and feature tests
- `docs/` — Documentation and examples

## Available Data Classes
- [Person Class](https://github.com/dayCod/fictive/blob/master/docs/class/Person.md)

## Development & Contribution

Before pushing to the main branch, please run:

```sh
./vendor/bin/rector
./vendor/bin/pint
composer test
```

Feel free to open issues or pull requests. See `CONTRIBUTING.md` for more details.

## License

This package is open-sourced software licensed under the MIT license.

## Tips

> Keep it simple, and don't overthink it.
