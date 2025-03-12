<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseResourceCollection extends ResourceCollection
{
    private array $except = [];
    private array $only = [];


    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($resource) use ($request) {
            if (! method_exists($resource, 'resolve')) {
                $resource = new $this->collects($resource);
            }

            $data = $resource->resolve($request);

            return match (true) {
                filled($this->only)   => array_intersect_key($data, array_flip($this->only)),
                filled($this->except) => array_diff_key($data, array_flip($this->except)),
                default               => $data,
            };
        })->toArray();
    }

    public function except(array $keys): static
    {
        $this->except = $keys;
        return $this;
    }

    public function only(array $keys): static
    {
        $this->only = $keys;
        return $this;
    }
}
