<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;



Route::get('articles',  [ArticleController::class, 'index']);
Route::get('articles/{id}/comments',  [ArticleController::class, 'article_comments']);
Route::get('tags',  [ArticleController::class, 'tags']);
Route::get('tags/{id}/articles',  [ArticleController::class, 'tags_articles']);

