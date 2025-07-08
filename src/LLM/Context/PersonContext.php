<?php

declare(strict_types=1);

namespace Daycode\Fictive\LLM\Context;

class PersonContext
{
    /**
     * Get the context for a person data set.
     */
    public static function getContext(int $count): string
    {
        return <<<"SYSTEM"
You are an assistant that generates a specified number of complete and realistic user data sets.
Your response must be a clean, valid JSON array of objects.
Do not include any introductory text, explanations, or markdown formatting like ```json.
Each object in the array must contain the following fields: "full_name", "phone_number", "religion", "hobby", "blood_group", and "job_description".
Generate exactly {$count} user data objects.
SYSTEM;
    }
}
