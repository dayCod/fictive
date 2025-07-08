<?php

declare(strict_types=1);

namespace Daycode\Fictive;

use Daycode\Fictive\DataTransferObjects\Person;
use Daycode\Fictive\Exceptions\RateLimitExceeded;
use Daycode\Fictive\LLM\Context\PersonContext;
use Daycode\Fictive\LLM\OpenRouter;
use Illuminate\Support\Str;
use Closure;

class Fictive
{
    protected int $count = 1;

    public function count(int $count): self
    {
        $this->count = $count;
        return $this;
    }

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

        return function (callable $callback) use ($personsData) {
            foreach ($personsData as $attributes) {
                $callback(new Person($attributes));
            }
        };
    }
}
