<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @template TResource of JsonResource
 *
 * @extends BaseResourceCollection<TResource>
 */
abstract class PaginatorResource extends BaseResourceCollection
{
    /**
     * @return class-string<TResource>
     */
    abstract protected function resourceClass(): string;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Paginator<TResource> $paginator */
        $paginator = $this->resource;

        /** @var class-string<TResource> $resourceClass */
        $resourceClass = $this->resourceClass();

        /** @var mixed $collectionData */
        $collectionData = $resourceClass::collection($this->collection)->toArray($request);

        /** @var array<int, array<string, mixed>> $data */
        $data = match (true) {
            is_array($collectionData) => array_values($collectionData),
            $collectionData instanceof \Traversable => array_values(iterator_to_array($collectionData)),
            default => throw new \UnexpectedValueException('Expected collection to be iterable or array.'),
        };

        return [
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => $this->transformLinks($paginator, $request),
        ];
    }

    /**
     * @param  Paginator<TResource>  $paginator
     * @return array{first: string, prev: string|null, next: string|null}
     */
    protected function transformLinks(Paginator $paginator, Request $request): array
    {
        /** @var array<string, mixed> $query */
        $query = $request->except('page');
        $currentPage = $paginator->currentPage();
        $nextPageUrl = $paginator->nextPageUrl();
        $prevPageUrl = $paginator->previousPageUrl();

        return [
            'first' => $this->replacePageParam($paginator->url(1), $query, 1),
            'prev' => $prevPageUrl
                ? $this->replacePageParam($prevPageUrl, $query, $currentPage - 1)
                : null,
            'next' => $nextPageUrl
                ? $this->replacePageParam($nextPageUrl, $query, $currentPage + 1)
                : null,
        ];
    }

    /**
     * @param  array<string, mixed>  $query
     */
    protected function replacePageParam(string $url, array $query, int $page): string
    {
        if (! isset($query['paginate']) || ! is_array($query['paginate'])) {
            $query['paginate'] = [];
        }

        unset($query['page'], $query['filter.page']);
        $query['paginate']['page'] = $page;

        $queryString = http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        $queryString = urldecode(str_replace(['%5B', '%5D'], ['[', ']'], $queryString));

        return preg_replace('/\?page=\d+/', '', $url).'?'.$queryString;
    }
}
