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
            'job_description' => 'job description',
        ];

        // Apply dynamic specifications
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

    /**
     * Clear all field specifications
     */
    public static function clearFieldSpecifications(): void
    {
        self::$fieldSpecifications = [];
    }

    /**
     * Get current field specifications
     */
    public static function getFieldSpecifications(): array
    {
        return self::$fieldSpecifications;
    }

    /**
     * Get specific field context for dynamic generation
     */
    public static function getSpecificFieldContext(string $field, string $specification): string
    {
        $fieldMap = [
            'full_name' => 'name',
            'phone_number' => 'phone number',
            'religion' => 'religion',
            'hobby' => 'hobby',
            'blood_group' => 'blood group',
            'job_description' => 'job description',
        ];

        $fieldType = $fieldMap[$field] ?? $field;

        return <<<"SYSTEM"
        You are an assistant that generates a single realistic {$fieldType} value.
        Your response must be only the value itself without any additional text, formatting, or explanation.
        Do not include quotes, JSON formatting, or markdown.
        
        Generate a {$fieldType} that matches this specification: {$specification}
        
        Examples:
        - If asked for "indonesian male name", return something like "Budi Santoso"
        - If asked for "brazilian female name", return something like "Maria Silva"
        - If asked for "american phone number", return something like "+1-555-123-4567"
        
        Just return the single value that matches the specification.
        SYSTEM;
    }
}
