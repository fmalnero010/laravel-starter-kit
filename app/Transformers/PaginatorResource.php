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
        $query = $request->except('page');
        $currentPage = $paginator->currentPage();
        $nextPageUrl = $paginator->nextPageUrl();
        $prevPageUrl = $paginator->previousPageUrl();

        return [
            'first' => $this->replacePageParam($paginator->url(1), $query, 1),
            'prev'  => $prevPageUrl
                ? $this->replacePageParam($prevPageUrl, $query, $currentPage - 1)
                : null,
            'next'  => $nextPageUrl
                ? $this->replacePageParam($nextPageUrl, $query, $currentPage + 1)
                : null,
        ];
    }

    protected function replacePageParam(string $url, array $query, int $page): string
    {
        // Remove 'page' and 'filter.page' to avoid conflicts
        unset($query['page'], $query['filter.page']);

        // Keep paginate[perPage] if it is in the request
        $perPage = $query['paginate']['perPage'] ?? null;

        // Overwrite paginate[page] with the correct value for the current page
        $query['paginate']['page'] = $page;

        // If paginate[perPage] was there before, add it again
        if ($perPage !== null) {
            $query['paginate']['perPage'] = $perPage;
        }

        // Generate query without encoding the brackets
        $queryString = http_build_query($query, '', '&', PHP_QUERY_RFC3986);

        // Replace brackets encoding
        $queryString = str_replace(['%5B', '%5D'], ['[', ']'], $queryString);

        // Decode special characters if any
        $queryString = urldecode($queryString);

        // Eliminate old pagination without dot-notation if exists
        $url = preg_replace('/\?page=\d+/', '', $url);

        return $url . '?' . $queryString;
    }
}
