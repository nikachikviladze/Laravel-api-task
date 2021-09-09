<?php

namespace App\Repository;
use App\Http\Resources\ArticleResource;

class ArticleRepository{

    public function article($article, $sort, $limit, $order, $paginate, $ids =null)
    {


        $articles = ($ids)? $article->whereIn('id', $ids)->take($limit) :  $article->take($limit);

        // dd($articles->get());
        if($sort=='created_at'){
            
            $articles = $articles->orderBy('created_at', 'desc');
        }elseif($sort=='comment_count'){
            $articles = $articles->withCount('comments')->orderBy('comments_count', 'desc');
        }elseif($sort=='view_count'){
            $articles = $articles->orderBy('view_count', 'desc');
        } 
        
        $articles = $articles->orderBy('id', $order);        

        if($paginate){

            $articles = $articles->paginate($paginate);

        }else{

            $articles = $articles->get();
        }

        return ArticleResource::collection($articles);
    }
}
