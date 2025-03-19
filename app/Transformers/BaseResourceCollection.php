<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @template TResource of object
 */
abstract class BaseResourceCollection extends ResourceCollection
{
    /** @var array<string> */
    private array $except = [];

    /** @var array<string> */
    private array $only = [];

    /**
     * @return array<int, array<string, mixed>>|array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array<int, array<string, mixed>>|array<string, mixed> $result */
        $result = $this->collection->map(function (mixed $resource) use ($request): array {
            if (is_object($resource) && ! method_exists($resource, 'resolve')) {
                /** @var class-string<TResource> $collects */
                $collects = $this->collects;
                $resource = new $collects($resource);
            }

            if (! is_object($resource) || ! method_exists($resource, 'resolve')) {
                throw new \LogicException('Resource must be an object with a resolve method.');
            }

            /** @var array<string, mixed> $data */
            $data = $resource->resolve($request);

            return match (true) {
                ! empty($this->only) => array_intersect_key($data, array_flip($this->only)),
                ! empty($this->except) => array_diff_key($data, array_flip($this->except)),
                default => $data,
            };
        })->toArray();

        return array_values($result);
    }

    /**
     * @param  array<string> $keys
     * @return static
     */
    public function except(array $keys): static
    {
        $this->except = $keys;

        return $this;
    }

    /**
     * @param  array<string> $keys
     * @return static
     */
    public function only(array $keys): static
    {
        $this->only = $keys;

        return $this;
    }
}
