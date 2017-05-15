<?php

namespace Corp\Http\Controllers;

use Corp\Category;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\CommentRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Menu;
use Config;

class ArticlesController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep, ArticleRepository $a_rep, CommentRepository $c_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));


        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;
        $this->bar = 'right';

        $this->template = config('settings.theme') . '.articles';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cat_alias = false)
    {
        $articles = $this->getArticles($cat_alias);
        $content = view(config('settings.theme') . '.articles_content', compact('articles'))->render();
        $this->vars['content'] = $content;

        $comments = $this->getComments(Config::get('settings.resent_comments'));
        $portfolios = $this->getPortfolios(Config::get('settings.resent_portfolios'));
        $this->contentRightBar = view(config('settings.theme') . '.articles_bar', compact('comments', 'portfolios'))->render();
        

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        $article = $this->a_rep->one($alias, ['comments' => true]);
        if(!isset($article->id)) {
            abort(404);
        }

        $this->title = $article->title;
        $this->keywords = $article->keywords;
        $this->meta_desc = $article->meta_desc;

        $com = $article->comments->groupBy('parent_id');
        $content = view(config('settings.theme') . '.article_content', compact('article', 'com'))->render();
        $this->vars['content'] = $content;


        $comments = $this->getComments(Config::get('settings.resent_comments'));
        $portfolios = $this->getPortfolios(Config::get('settings.resent_portfolios'));
        $this->contentRightBar = view(config('settings.theme') . '.articles_bar', compact('comments', 'portfolios'))->render();


        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getArticles($alias = false)
    {
        $where = false;

        if ( $alias ){
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get([
            'select' => [
                'id',
                'title',
                'alias',
                'created_at',
                'images',
                'desc',
                'user_id',
                'category_id',
                'keywords',
                'meta_desc',

            ],
            'revert' => 'id',
            'pagination' => Config::get('settings.articles_paginate'),
            'where' => $where,
        ]);

        if ($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    public function getComments($take)
    {
        $comments = $this->c_rep->get([
            'select' => ['name','text', 'email', 'article_id', 'user_id'],
            'take' => $take,
            'revert' => 'id',
        ]);

        if($comments){
            $comments->load('article', 'user');
        }

        return $comments;
    }

    public function getPortfolios($take)
    {
        $portfolios = $this->p_rep->get([
            'select' => ['title','text', 'alias', 'customer', 'images', 'filter_alias'],
            'take' => $take,
            'revert' => 'id',
        ]);
        return $portfolios;
    }

}
