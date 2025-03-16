<?php

declare(strict_types=1);

namespace App\Transformers;

/**
 * @template TResource of BaseResource
 * @extends BaseResourceCollection<TResource>
 */
class BaseResourceCollectionWrapper extends BaseResourceCollection
{
    /** @var class-string<TResource> */
    public $collects;

    /**
     * @param mixed $resource
     * @param class-string<TResource> $resourceClass
     */
    public function __construct($resource, string $resourceClass)
    {
        parent::__construct($resource);
        $this->collects = $resourceClass;
    }
}
