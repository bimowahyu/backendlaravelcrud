<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => 'List Data Posts',
            'data' => $this->collection,
        ];
    }
}
