<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AlphaNumSpaces implements ValidationRule
{
    protected static string $extraChars = '';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[a-zA-Z0-9 ' . self::$extraChars . ']+$/';

        if (preg_match($pattern, $value)) {
            return;
        }

        $fail('The :attribute can not contain special characters.');
    }

    public static function withAllowedCharacters(string $chars): self
    {
        $class = new self;
        $class->allowCharacters($chars);
        return $class;
    }

    public function allowCharacters(string $characters): void
    {
        self::$extraChars = preg_quote($characters, '/');
    }
}
