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
}
