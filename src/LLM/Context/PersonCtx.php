<?php

declare(strict_types=1);

namespace Daycode\Fictive\LLM\Context;

class PersonCtx
{
    /**
     * Get the validation context.
     */
    public static function validationContext(string $method, string $prompt): string
    {
        return "Analyze whether the word or phrase {$prompt} {$method} makes sense and is contextually relevant when paired with the {$method}. Determine if the combination is logically coherent and related to the concept implied by {$method}. Return '1' if the combination is relevant and makes sense, or '0' if it does not. The output must be strictly '0' or '1', with no additional text.";
    }

    /**
     * Get the processing context.
     */
    public static function processContext(string $method, string $prompt, ?string $samples): string
    {
        return "Given the method name '{$method}' and the input '{$prompt}', generate a single, concise string output that is contextually appropriate and aligns with the concept implied by '{$method}', Ensure the output is a single string with no additional explanation or formatting. To ensure variety, randomly select a valid output from the possible options each time this is called, avoiding repetition of the same output. and ensure the output is not inside this array: [{$samples}]";
    }
}
