<?php

namespace App\Repository;
use App\Http\Resources\ArticleResource;

class ArticleRepository{

    public static function article($article, $sort, $limit, $order, $paginate, $ids =null)
    {

        $articles = ($ids)? $article->whereIn('id', $ids)->take($limit) :  $article->take($limit);

        if($sort=='created_at'){            
            $articles = $articles->orderBy('created_at', $order);
        }elseif($sort=='comment_count'){
            $articles = $articles->withCount('comments')->orderBy('comments_count', $order);
        }elseif($sort=='view_count'){
            $articles = $articles->orderBy('view_count', $order);
        } 
        
        $articles = ($paginate)? $articles->orderBy('created_at', $order)->paginate($paginate) : $articles->orderBy('created_at', $order)->get();        

        return ArticleResource::collection($articles);
    }
}
