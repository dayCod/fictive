<?php

namespace Daycode\Fictive\LLM\Context;

class PersonContext
{
    /**
     * The available fields for a person data set.
     */
    public array $availableFields = [
        '"full_name"',
        '"phone_number"',
        '"religion"',
        '"hobby"',
        '"blood_group"',
        '"job_title"',
        '"gender"',
        '"birth_date"',
        '"address"',
        '"national_id_number"',
        '"marital_status"',
        '"education"',
        '"company"',
        '"salary"',
        '"email"',
    ];

    /**
     * Get the context for a person data set.
     */
    public static function getContext(int $count, array $customFields = []): string
    {
        $instance = new self;

        if ($customFields !== []) {
            $fieldsToUse = [];
            foreach ($customFields as $field => $description) {
                $fieldsToUse[] = is_numeric($field) ? "\"{$description}\"" : "\"{$field}: {$description}\"";
            }
            $availableFields = implode(', ', ($fieldsToUse + $instance->availableFields));
        } else {
            $availableFields = implode(', ', $instance->availableFields);
        }

        return <<<"SYSTEM"
        You are an assistant that generates a specified number of complete and realistic user data sets.
        Your response must be a clean, valid JSON array of objects.
        Do not include any introductory text, explanations, or markdown formatting like ```json.
        Each object in the array must contain the following fields: {$availableFields}. Generate exactly {$count} user data objects.
        SYSTEM;
    }
}
