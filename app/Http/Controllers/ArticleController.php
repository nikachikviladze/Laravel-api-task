<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Http\Resources\CommentResource;
use App\Http\Resources\TagResource;
use Facades\App\Repository\ArticleRepository;

class ArticleController extends Controller
{
    public $order;
    public $limit;
    public $sort;
    public $paginate;

    public function __construct()
    {
        $this->order = (request()->order=='asc')? 'asc' : 'desc';
        $this->limit =(is_numeric(request()->limit))? request()->limit : 10;
        $this->sort = (request()->sort)? request()->sort : null;
        $this->paginate = (is_numeric(request()->paginate))? request()->paginate : null;
    }
    public function index(Article $article)
    {
        return ArticleRepository::article($article, $this->sort, $this->limit,$this->order, $this->paginate);
    }
    public function article_comments($id)
    {
        $article = Article::findOrFail($id);

        if($this->order){
            $article = $article->with(['comments' => function($query) {
                $query->orderBy('id', $this->order);
            }])->find($id);

        }
        if($this->sort){
            $article = $article->with(['comments' => function($query) {
                $query->orderBy('created_at', $this->order);
            }])->find($id);
        }

        return CommentResource::collection($article->comments);

    }

    public function tags(Tag $tags)
    {

        if($this->sort){
            $tags = $tags->withCount('article')->orderBy('article_count', $this->order);
        }

        if($this->order){
            $tags = $tags->orderBy('id', $this->order);
        }

        return TagResource::collection($tags->get());
    }
    public function tags_articles($id, Article $article)
    {
        $tag = Tag::findOrFail($id);
        $ids = $tag->article->pluck('id')->toArray();

        return ArticleRepository::article($article, $this->sort, $this->limit,$this->order, $this->paginate, $ids);
    }

}
