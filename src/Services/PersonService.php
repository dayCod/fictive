<?php

declare(strict_types=1);

namespace Daycode\Fictive\Services;

use Daycode\Fictive\DTO\Person;
use Daycode\Fictive\LLM\Context\PersonContext;

class PersonService extends BaseService
{
    /**
     * Get context class for person generation
     */
    protected function getContextClass(): string
    {
        return PersonContext::class;
    }

    /**
     * Get DTO class for person
     */
    protected function getDTOClass(): string
    {
        return Person::class;
    }

    /**
     * Get entity name for prompt
     */
    protected function getEntityName(): string
    {
        return 'person';
    }

    /**
     * Get persons (alias for getItems)
     */
    public function getPersons(): array
    {
        return $this->getItems();
    }

    /**
     * Get person by index (alias for get)
     */
    public function getPerson(int $index): ?Person
    {
        return $this->get($index);
    }

    /**
     * Get random person (alias for random)
     */
    public function getRandomPerson(): ?Person
    {
        return $this->random();
    }

    /**
     * Filter persons by specific criteria
     */
    public function filterByReligion(string $religion): array
    {
        return $this->filter(fn (Person $person): bool => $person->religion() === $religion);
    }

    /**
     * Filter persons by blood group
     */
    public function filterByBloodGroup(string $bloodGroup): array
    {
        return $this->filter(fn (Person $person): bool => $person->bloodGroup() === $bloodGroup);
    }

    /**
     * Get persons with specific job title
     */
    public function filterByJobTitle(string $jobTitle): array
    {
        return $this->filter(fn (Person $person): bool => stripos($person->jobTitle(), $jobTitle) !== false);
    }
}
