<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @template TResource of BaseResource
 */
abstract class BaseResource extends JsonResource
{
    /** @var array<string> */
    private array $except = [];

    /** @var array<string> */
    private array $only = [];

    /**
     * @return array<string, mixed>
     */
    public function resolve($request = null): array
    {
        /** @var array<string, mixed> $data */
        $data = parent::resolve($request);

        return match (true) {
            !empty($this->only) => array_intersect_key($data, array_flip($this->only)),
            !empty($this->except) => array_diff_key($data, array_flip($this->except)),
            default => $data,
        };
    }

    /**
     * @param mixed $resource
     * @return BaseResourceCollection<TResource>
     */
    public static function collection($resource): BaseResourceCollection
    {
        /** @var class-string<static> $resourceClass */
        $resourceClass = static::class;

        /** @var BaseResourceCollection<TResource> $collection */
        $collection = new BaseResourceCollectionWrapper($resource, $resourceClass);

        return $collection;
    }

    /**
     * @param array<string> $keys
     * @return static
     */
    public function except(array $keys): static
    {
        $this->except = $keys;
        return $this;
    }

    /**
     * @param array<string> $keys
     * @return static
     */
    public function only(array $keys): static
    {
        $this->only = $keys;
        return $this;
    }
}
