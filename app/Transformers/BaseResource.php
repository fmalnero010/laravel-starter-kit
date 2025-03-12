<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    private array $except = [];
    private array $only = [];

    public function resolve($request = null): array
    {
        $data = parent::resolve($request);

        return match (true) {
            filled($this->only)   => array_intersect_key($data, array_flip($this->only)),
            filled($this->except) => array_diff_key($data, array_flip($this->except)),
            default               => $data,
        };
    }

    public static function collection($resource): BaseResourceCollection
    {
        $resourceClass = static::class;

        return new class($resource, $resourceClass) extends BaseResourceCollection {
            public $collects;

            public function __construct($resource, $resourceClass)
            {
                parent::__construct($resource);
                $this->collects = $resourceClass;
            }
        };
    }

    /**
     * @param array<string> $keys
     * @return self
     */
    public function except(array $keys): self
    {
        $this->except = $keys;
        return $this;
    }

    /**
     * @param array<string> $keys
     * @return self
     */
    public function only(array $keys): self
    {
        $this->only = $keys;
        return $this;
    }
}
