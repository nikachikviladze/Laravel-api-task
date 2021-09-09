<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'view_count' => rand(1, 10000),
            'comment_count' => $this->comments->count(),
            'tags' => $this->tags,
        ];
    }
}
