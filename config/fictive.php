<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP Referer
    |--------------------------------------------------------------------------
    |
    | The HTTP referer to use when making requests to the language model service.
    |
    */
    'http_referer' => 'https://github.com/dayCod/fictive',

    /*
    |--------------------------------------------------------------------------
    | X-Title
    |--------------------------------------------------------------------------
    |
    | The X-Title to use when making requests to the language model service.
    |
    */
    'x_title' => 'Fictive',

    /*
    |--------------------------------------------------------------------------
    | Large Language Model Configuration
    |--------------------------------------------------------------------------
    |
    | This section contains settings for the language model service. You can
    | specify the API endpoint, authentication key, and model parameters
    | like temperature which controls randomness of generated output.
    |
    */
    'llm' => [

        /*
        |--------------------------------------------------------------------------
        | Model
        |--------------------------------------------------------------------------
        |
        | The name of the model to use for generating text.
        |
        */
        'model' => 'google/gemini-2.0-flash-001',

        /*
        |--------------------------------------------------------------------------
        | API Endpoint
        |--------------------------------------------------------------------------
        |
        | The API endpoint for the language model service.
        |
        */
        'uri' => env('OPENROUTER_BASE_URI', 'https://openrouter.ai/api/v1'),

        /*
        |--------------------------------------------------------------------------
        | API Key
        |--------------------------------------------------------------------------
        |
        | The API key for the language model service.
        |
        */
        'key' => env('OPENROUTER_KEY_API', null),

        /*
        |--------------------------------------------------------------------------
        | Timeout
        |--------------------------------------------------------------------------
        |
        | The timeout for the language model service.
        |
        */
        'timeout' => 20,

        /*
        |--------------------------------------------------------------------------
        | Options
        |--------------------------------------------------------------------------
        |
        | Additional options for the language model service.
        |
        */
        'options' => [
            'temperature' => 0.3,
            'max_tokens' => 500,
        ],

    ],

];
