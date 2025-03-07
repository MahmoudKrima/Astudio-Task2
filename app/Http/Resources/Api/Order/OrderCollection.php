<?php

namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\Order\OrderResoruce;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $meta = [
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
        ];
        $links = [
            'first' => $this->url(1),
            'last' => $this->url($this->lastPage()),
            'prev' => $this->previousPageUrl(),
            'next' => $this->nextPageUrl(),
        ];
        $existingPages = [];
        $existingPages[] = $links['first'];
        if ($links['prev']) {
            $existingPages[] = $links['prev'];
        }
        if ($links['next']) {
            $existingPages[] = $links['next'];
        }
        $existingPages[] = $links['last'];
        for ($page = $meta['current_page'] + 1; $page < $meta['last_page']; $page++) {
            $existingPages[] = $this->url($page);
        }
        sort($existingPages);
        $pages = array_unique($existingPages);
        return [
            'projects' => OrderResoruce::collection($this->collection),
            'meta' => $meta,
            'links' => $links,
            'pages' => $pages
        ];
    }
}
