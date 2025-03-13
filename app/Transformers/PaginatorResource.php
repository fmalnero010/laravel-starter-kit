<?php

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class PaginatorResource extends BaseResourceCollection
{
    abstract protected function resourceClass(): string;

    public function toArray(Request $request): array
    {
        /** @var Paginator $paginator */
        $paginator = $this->resource;
        /** @var ResourceCollection|JsonResource $resourceClass */
        $resourceClass = $this->resourceClass();

        return [
            'data' => $resourceClass::collection($this->collection),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
            'links' => $this->transformLinks($paginator, $request),
        ];
    }

    protected function transformLinks(Paginator $paginator, Request $request): array
    {
        $query = $request->except('page'); // Remove page to avoid conflicts
        $query['filter.page'] = '{page}';  // Define pagination with dot-notation

        return [
            'first' => $this->replacePageParam($paginator->url(1), $query),
            'prev'  => $paginator->previousPageUrl()
                ? $this->replacePageParam($paginator->previousPageUrl(), $query)
                : null,
            'next'  => $paginator->nextPageUrl()
                ? $this->replacePageParam($paginator->nextPageUrl(), $query)
                : null,
        ];
    }

    protected function replacePageParam(string $url, array $query): string
    {
        // Remove old 'page', 'per_page' y 'filter.page' to avoid conflicts
        unset($query['page'], $query['per_page'], $query['filter.page']);

        // Overwrite paginate[page] to 1
        $query = array_merge($query, ['paginate' => ['page' => 1]]);

        // Generate query without encoding brackets
        $queryString = http_build_query($query, '', '&', PHP_QUERY_RFC3986);

        // Replace brackets encoding
        $queryString = str_replace(['%5B', '%5D'], ['[', ']'], $queryString);

        // Decode special characters if there are any
        $queryString = urldecode($queryString);

        // Eliminate the old not-dot-notation pagination
        $url = preg_replace('/\?page=\d+/', '', $url);

        return $url . '?' . $queryString;
    }
}
