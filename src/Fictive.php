<?php

declare(strict_types=1);

namespace Daycode\Fictive;

use Closure;
use Daycode\Fictive\Services\BaseService;
use Daycode\Fictive\Services\PersonService;
use InvalidArgumentException;

class Fictive
{
    /**
     * Set the default number of items to generate.
     */
    protected int $count = 1;

    /**
     * Store custom field requirements
     */
    protected array $customFields = [];

    /**
     * Available services mapping
     */
    protected array $services = [
        'person' => PersonService::class,
    ];

    /**
     * Cache for service instances
     */
    protected array $serviceInstances = [];

    /**
     * Set the number of items to generate.
     */
    public function count(int $count): self
    {
        $this->count = $count;

        $this->serviceInstances = [];

        return $this;
    }

    /**
     * Set custom fields for generation
     */
    public function withFields(array $fields): self
    {
        $this->customFields = $fields;

        $this->serviceInstances = [];

        return $this;
    }

    /**
     * Get service instance
     */
    protected function getService(string $type): BaseService
    {
        if (! isset($this->services[$type])) {
            throw new InvalidArgumentException("Unknown service type: {$type}");
        }

        if (! isset($this->serviceInstances[$type])) {
            $serviceClass = $this->services[$type];
            $this->serviceInstances[$type] = new $serviceClass($this->count, $this->customFields);
        }

        return $this->serviceInstances[$type];
    }

    /**
     * Generic handle method for any registered service
     */
    public function handle(string $type): Closure
    {
        $service = $this->getService($type);

        if (! is_subclass_of($service::class, BaseService::class)) {
            throw new InvalidArgumentException('Service class must extend BaseService');
        }

        return function (callable $callback) use ($service): void {
            $service->each($callback);
        };
    }

    /**
     * Generate person data sets (backward compatibility)
     */
    public function handlePersons(): Closure
    {
        return $this->handle('person');
    }
}
