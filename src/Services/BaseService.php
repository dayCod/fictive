<?php

declare(strict_types=1);

namespace Daycode\Fictive\Services;

use Daycode\Fictive\Exceptions\RateLimitExceeded;
use Daycode\Fictive\LLM\OpenRouter;
use Illuminate\Support\Str;

abstract class BaseService
{
    /**
     * Cache the generated data to avoid multiple API calls
     */
    protected ?array $data = null;

    /**
     * Constructor
     */
    public function __construct(
        /**
         * Number of items to generate
         */
        protected int $count = 1,
        /**
         * Store custom field requirements
         */
        protected array $customFields = []
    ) {}

    /**
     * Abstract method to get context class
     */
    abstract protected function getContextClass(): string;

    /**
     * Abstract method to get DTO class
     */
    abstract protected function getDTOClass(): string;

    /**
     * Abstract method to get entity name for prompt
     */
    abstract protected function getEntityName(): string;

    /**
     * Set custom fields for generation
     */
    public function setCustomFields(array $fields): self
    {
        $this->customFields = $fields;

        $this->data = null;

        return $this;
    }

    /**
     * Set the number of items to generate
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        $this->data = null;

        return $this;
    }

    /**
     * Generate data from API (cached)
     */
    public function generateData(): array
    {
        if ($this->data !== null) {
            return $this->data;
        }

        $this->data = $this->callOpenRouterAPI();

        return $this->data;
    }

    /**
     * Get items as DTO objects
     */
    public function getItems(): array
    {
        $data = $this->generateData();
        $dtoClass = $this->getDTOClass();

        return array_map(fn ($attributes): object => new $dtoClass($attributes), $data);
    }

    /**
     * Execute callback for each item
     */
    public function each(callable $callback): void
    {
        $data = $this->generateData();
        $dtoClass = $this->getDTOClass();

        foreach ($data as $attributes) {
            $callback(new $dtoClass($attributes));
        }
    }

    /**
     * Get item by index
     */
    public function get(int $index): mixed
    {
        $data = $this->generateData();
        $dtoClass = $this->getDTOClass();

        if (! isset($data[$index])) {
            return null;
        }

        return new $dtoClass($data[$index]);
    }

    /**
     * Get random item
     */
    public function random(): mixed
    {
        $data = $this->generateData();
        $dtoClass = $this->getDTOClass();

        if ($data === []) {
            return null;
        }

        $randomIndex = array_rand($data);

        return new $dtoClass($data[$randomIndex]);
    }

    /**
     * Call OpenRouter API to generate data
     */
    protected function callOpenRouterAPI(): array
    {
        try {
            $contextClass = $this->getContextClass();
            $entityName = $this->getEntityName();

            $response = (new OpenRouter)
                ->setSystemPrompt($contextClass::getContext($this->count, $this->customFields))
                ->setUserPrompt("Generate {$this->count} {$entityName} data sets.")
                ->execute();

            if (isset($response?->error) && $response?->error->code == 429) {
                throw new RateLimitExceeded;
            }

            $content = $response->choices[0]->message->content;

            if (Str::startsWith($content, '```json')) {
                $content = Str::between($content, '```json', '```');
            }

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }

            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to call OpenRouter API: '.$e->getMessage(), 0, $e);
        }
    }
}
