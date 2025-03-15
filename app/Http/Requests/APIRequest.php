<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->failedValidation(
                $validator->errors()->toArray()
            )
        );
    }

    /**
     * Removes exact duplicate inputs from the request
     */
    public function removeExactDuplicateInputs(): void
    {
        $this->replace(
            array_intersect_key(
                $this->all(),
                array_unique(
                    $this->all(),
                    SORT_REGULAR
                )
            )
        );
    }

    /**
     * Extracts values from a dot notation array and merges them into the main request
     */
    public function extractDotNotationFor(string $key): void
    {
        $conditions = $this->input($key, []);
        $this->merge($conditions);
    }

    /**
     * Prevents a parameter from being present both inside the dot notation array
     * and as a separate top-level parameter
     */
    public function removeConflictingKeys(array $keys): void
    {
        foreach ($keys as $key) {
            if ($this->has($key)) {
                $this->offsetUnset($key);
            }
        }
    }
}
