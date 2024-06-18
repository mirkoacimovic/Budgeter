<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MaxLengthRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length is not specified.");
        }

        $length = (int) $params[0];

        return strlen($field) < $length;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Exceeds maximum length of {$params[0]} characters.";
    }
}
