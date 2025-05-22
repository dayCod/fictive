<?php

declare(strict_types=1);

namespace Daycode\Fictive\LLM;

use Illuminate\Support\Facades\Http;

class OpenRouter
{
    /**
     * This variable will hold the base URL for the OpenRouter API.
     */
    protected ?string $baseUri = null;

    /**
     * This variable will hold the API key for the OpenRouter API.
     */
    protected ?string $apiKey = null;

    /**
     * This variable will hold the system prompt for the OpenRouter API.
     */
    protected ?string $systemPrompt = null;

    /**
     * This variable will hold the user prompt for the OpenRouter API.
     */
    protected ?string $userPrompt = null;

    /**
     * Construct a new OpenRouter object.
     */
    public function __construct()
    {
        $this->baseUri = config('fictive.llm.uri');
        $this->apiKey = config('fictive.llm.key');
    }

    /**
     * Set the system prompt for the OpenRouter API.
     */
    public function setSystemPrompt(?string $systemPrompt): self
    {
        $this->systemPrompt = $systemPrompt;

        return $this;
    }

    /**
     * Set the user prompt for the OpenRouter API.
     */
    public function setUserPrompt(?string $userPrompt): self
    {
        $this->userPrompt = $userPrompt;

        return $this;
    }

    /**
     * Execute the OpenRouter API.
     */
    public function execute(): object
    {
        return Http::withToken($this->apiKey)
            ->withBody(json_encode($this->createBodyStructure()))
            ->retry(3, 500)
            ->post($this->baseUri.'/chat/completions')
            ->object();
    }

    /**
     * Create the body structure for the OpenRouter API.
     */
    private function createBodyStructure(): array
    {
        $body = [
            'model' => config('fictive.llm.model'),
            'messages' => [
                ['role' => 'user', 'content' => $this->userPrompt],
            ],
            'temperature' => config('fictive.llm.options.temperature'),
        ];

        if ($this->systemPrompt !== null && $this->systemPrompt !== '' && $this->systemPrompt !== '0') {
            $body['messages'][] = ['role' => 'system', 'content' => $this->systemPrompt];
        }

        return $body;
    }
}
