<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaNumSpaces implements ValidationRule
{
    protected string $extraChars = '';
    protected bool $allowNumbers = true;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('The :attribute must be a string.');

            return;
        }

        if (! $this->allowNumbers && preg_match('/\d/', $value)) {
            $fail('The :attribute can not contain numbers.');
            return;
        }

        $pattern = $this->allowNumbers
            ? '/^[a-zA-Z0-9 ' . preg_quote($this->extraChars, '/') . ']+$/'
            : '/^[a-zA-Z ' . preg_quote($this->extraChars, '/') . ']+$/';

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

    public static function withoutNumbers(): self
    {
        $class = new self;
        $class->allowNumbers = false;

        return $class;
    }
}
