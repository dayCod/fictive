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
     * Register a new service
     */
    public function registerService(string $name, string $serviceClass): self
    {
        if (! is_subclass_of($serviceClass, BaseService::class)) {
            throw new InvalidArgumentException('Service class must extend BaseService');
        }

        $this->services[$name] = $serviceClass;

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
     * Generate person data sets (backward compatibility)
     */
    public function handlePersons(): Closure
    {
        return $this->handle('person');
    }

    /**
     * Generic handle method for any registered service
     */
    public function handle(string $type): Closure
    {
        $service = $this->getService($type);

        return function (callable $callback) use ($service): void {
            $service->each($callback);
        };
    }

    /**
     * Get person service
     */
    public function persons(): PersonService
    {
        return $this->getService('person');
    }

    /**
     * Get service by type
     */
    public function service(string $type): BaseService
    {
        return $this->getService($type);
    }

    /**
     * Get all available service types
     */
    public function getAvailableServices(): array
    {
        return array_keys($this->services);
    }

    /**
     * Get all generated data as array (for debugging)
     */
    public function toArray(string $type): array
    {
        return $this->getService($type)->toArray();
    }

    /**
     * Reset cache for specific service
     */
    public function refresh(string $type): self
    {
        $this->getService($type)->refresh();

        return $this;
    }

    /**
     * Reset cache for all services
     */
    public function refreshAll(): self
    {
        foreach ($this->serviceInstances as $service) {
            $service->refresh();
        }

        return $this;
    }

    /**
     * Check if service data is cached
     */
    public function isCached(string $type): bool
    {
        return $this->getService($type)->isCached();
    }

    /**
     * Get items from specific service
     */
    public function getItems(string $type): array
    {
        return $this->getService($type)->getItems();
    }

    /**
     * Get first item from specific service
     */
    public function first(string $type): mixed
    {
        return $this->getService($type)->first();
    }

    /**
     * Get random item from specific service
     */
    public function random(string $type): mixed
    {
        return $this->getService($type)->random();
    }

    /**
     * Filter items from specific service
     */
    public function filter(string $type, callable $callback): array
    {
        return $this->getService($type)->filter($callback);
    }

    /**
     * Map items from specific service
     */
    public function map(string $type, callable $callback): array
    {
        return $this->getService($type)->map($callback);
    }

    /**
     * Paginate items from specific service
     */
    public function paginate(string $type, int $perPage, int $page = 1): array
    {
        return $this->getService($type)->paginate($perPage, $page);
    }

    /**
     * Execute callback for each item in specific service
     */
    public function each(string $type, callable $callback): void
    {
        $this->getService($type)->each($callback);
    }

    /**
     * Check if service has empty data
     */
    public function isEmpty(string $type): bool
    {
        return $this->getService($type)->isEmpty();
    }

    /**
     * Get count of items in specific service
     */
    public function countItems(string $type): int
    {
        return $this->getService($type)->count();
    }
}
