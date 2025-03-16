<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AlphaNumSpaces implements ValidationRule
{
    protected string $extraChars = '';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('The :attribute must be a string.');
            return;
        }

        $pattern = '/^[a-zA-Z0-9 ' . preg_quote($this->extraChars, '/') . ']+$/';

        if (preg_match($pattern, $value)) {
            return;
        }

        $fail('The :attribute can not contain special characters.');
    }

    public static function withAllowedCharacters(string $chars): self
    {
        $class = new self;
        $class->extraChars = $chars;
        return $class;
    }
}
