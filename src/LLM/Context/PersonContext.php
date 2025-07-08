<?php

namespace Daycode\Fictive\LLM\Context;

class PersonContext
{
    /**
     * Store dynamic field specifications for current generation
     */
    protected static array $fieldSpecifications = [];

    /**
     * Get the context for a person data set.
     */
    public static function getContext(int $count): string
    {
        $baseFields = [
            'full_name' => 'complete realistic name',
            'phone_number' => 'valid phone number',
            'religion' => 'religion',
            'hobby' => 'hobby',
            'blood_group' => 'blood group (A, B, AB, O)',
            'job_title' => 'job title',
        ];

        foreach (self::$fieldSpecifications as $field => $specification) {
            if (isset($baseFields[$field])) {
                $baseFields[$field] = $specification;
            }
        }

        $fieldDescriptions = [];
        foreach ($baseFields as $field => $description) {
            $fieldDescriptions[] = "\"{$field}\": {$description}";
        }

        $fieldsString = implode(', ', $fieldDescriptions);

        return <<<"SYSTEM"
        You are an assistant that generates a specified number of complete and realistic user data sets.
        Your response must be a clean, valid JSON array of objects.
        Do not include any introductory text, explanations, or markdown formatting like ```json.
        Each object in the array must contain the following fields: {$fieldsString}.
        Generate exactly {$count} user data objects.
        SYSTEM;
    }

    /**
     * Set field specification for dynamic generation
     */
    public static function setFieldSpecification(string $field, string $specification): void
    {
        self::$fieldSpecifications[$field] = $specification;
    }
}
