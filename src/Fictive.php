<?php

declare(strict_types=1);

namespace Daycode\Fictive;

use Closure;
use Daycode\Fictive\DTO\Person;
use Daycode\Fictive\Exceptions\RateLimitExceeded;
use Daycode\Fictive\LLM\Context\PersonContext;
use Daycode\Fictive\LLM\OpenRouter;
use Illuminate\Support\Str;

class Fictive
{
    /**
     * set the default number of persons to generate.
     */
    protected int $count = 1;

    /**
     * Set the number of persons to generate.
     */
    public function count(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Generate person data sets.
     */
    public function handlePersons(): Closure
    {
        $response = (new OpenRouter)
            ->setSystemPrompt(PersonContext::getContext($this->count))
            ->setUserPrompt("Generate {$this->count} person data sets.")
            ->execute();

        if (isset($response?->error) && $response?->error->code == 429) {
            throw new RateLimitExceeded;
        }

        $content = $response->choices[0]->message->content;

        if (Str::startsWith($content, '```json')) {
            $content = Str::between($content, '```json', '```');
        }

        $personsData = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $personsData = [];
        }

        return function (callable $callback) use ($personsData): void {
            foreach ($personsData as $attributes) {
                $callback(new Person($attributes));
            }
        };
    }
}
