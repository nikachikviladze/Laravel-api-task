<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::withCount('comments')
                            ->orderBy('comments_count', 'desc')
                            ->orderBy('created_at','desc')
                            ->take(10)
                            ->paginate(5);

        return ArticleResource::collection($articles);
    }


}
