## Available Fields

| Field | Type | Description |
| --- | --- | --- |
| full_name | string | The name of the person | fullName() |
| phone_number | string | The phone number of the person | phoneNumber() |
| religion | string | The religion of the person | religion() |
| hobby | string | The hobby of the person | hobby() |
| blood_group | string | The blood group of the person | bloodGroup() |
| job_title | string | The job description of the person | jobTitle() |
| gender | string | The gender of the person | gender() |
| birth_date | string | The birth date of the person | birthDate() |
| address | string | The address of the person | address() |
| national_id_number | string | The national ID number of the person | nationalIdNumber() |
| marital_status | string | The marital status of the person | maritalStatus() |
| education | string | The education of the person | education() |
| company | string | The company of the person | company() |
| salary | string | The salary of the person | salary() |
| email | string | The email address of the person | email() |

## Usage Example

Always import the Fictive class:
```php
use Daycode\Fictive\Fictive;
```

### Basic Usage

```php
$initFictive = app(Fictive::class)
    ->count(3)
    ->withFields([
        'full_name' => 'indonesian male name',
        'hobby' => 'indoor hobbies',
        'email' => 'using domain @gmail.com',
        // You can add more fields here
    ])
    ->handlePersons();

$initFictive(function ($person) {
    User::create([
        'name' => $person->fullName(),
        'email' => $person->email(),
        'password' => bcrypt('password'),
        // You can add more fields here
    ]);
})
```

### Advanced Usage

```php
$initFictive = app(Fictive::class)
    ->count(3)
    ->withFields([
        'full_name' => 'indonesian male name',
        'hobby' => 'indoor hobbies',
        'email' => 'using domain @gmail.com',
        // You can add more fields here
    ])
    ->handlePersons();

$initFictive(function ($person) {
    User::create([
        'name' => $person->fullName(
            'title', // kebab, title, uppercase, slug, etc case.
            function ($name) {
                return 'Mr. ' . $name;
            }
        ),
        'email' => $person->email(),
        'password' => bcrypt('password'),
        // You can add more fields here
    ]);
})
```

## Available String Manipulations
```php
return match ($manipulation) {
    'uppercase', 'upper' => strtoupper((string) $value),
    'lowercase', 'lower' => strtolower((string) $value),
    'title' => Str::title($value),
    'slug' => Str::slug($value),
    'studly' => Str::studly($value),
    'camel' => Str::camel($value),
    'snake' => Str::snake($value),
    'kebab' => Str::kebab($value),
    'trim' => trim((string) $value),
    'reverse' => strrev((string) $value),
    default => $value
};
```

## Available Array Manipulations
```php
protected function applyArrayManipulation(mixed $value, array $manipulation): mixed
{
    if (isset($manipulation['replace'])) {
        $value = str_replace(
            $manipulation['replace']['search'] ?? '',
            $manipulation['replace']['replace'] ?? '',
            $value
        );
    }

    if (isset($manipulation['prefix'])) {
        $value = $manipulation['prefix'].$value;
    }

    if (isset($manipulation['suffix'])) {
        $value .= $manipulation['suffix'];
    }

    if (isset($manipulation['limit'])) {
        return Str::limit($value, $manipulation['limit']);
    }

    return $value;
}
```





