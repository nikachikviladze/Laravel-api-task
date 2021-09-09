<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Http\Resources\CommentResource;
use App\Http\Resources\TagResource;
use Facades\App\Repository\ArticleRepository;

class ArticleController extends Controller
{
    public function index(Article $article)
    {

        $order =(request()->order)? request()->order : 'desc';
        $limit =(request()->limit)? request()->limit : 10;
        $sort = (request()->sort)? request()->sort : null;
        $paginate = (request()->paginate)? request()->paginate : null;


        $articles = ArticleRepository::article($article, $sort, $limit,$order, $paginate);

        return $articles;
    }

    public function article_comments($id)
    {
        $article = Article::findOrFail($id);


        if(request()->order){
            $article = $article->with(['comments' => function($query) {
                $query->orderBy('id', request()->order);
            }])->find($id);

        }
        if(request()->sort){
            $article = $article->with(['comments' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])->find($id);

        }

        return CommentResource::collection($article->comments);

    }

    public function tags(Tag $tags)
    {


        $order =(request()->order)? request()->order : 'desc';

        // ტაგებს created_at ველი არ აქვს და შესაბამისად ეგ პარამეტრი ვერ განვსაზღვრე აქ
         
        if(request()->sort=='article_count'){
            $tags = $tags->withCount('article')->orderBy('article_count', 'desc');

        }

        if(request()->order){
            $tags = $tags->orderBy('id', $order);
        }

        return TagResource::collection($tags->get());
    }
    public function tags_articles($id, Article $article)
    {
        $tag = Tag::findOrFail($id);
        $ids = $tag->article->pluck('id')->toArray();

        $order =(request()->order)? request()->order : 'desc';
        $limit =(request()->limit)? request()->limit : 10;
        $sort = (request()->sort)? request()->sort : null;
        $paginate = (request()->paginate)? request()->paginate : null;


        $articles = ArticleRepository::article($article, $sort, $limit,$order, $paginate, $ids );

        return $articles;
    }

}
