<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Category;
use Corp\Http\Requests\ArticleRequest;
use Corp\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;
use Form;

class ArticlesController extends AdminController
{
    public function __construct(ArticleRepository $a_rep)
    {
        $this->a_rep = $a_rep;
        $this->template = '.admin.articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( Gate::denies('VIEW_ADMIN_ARTICLES') ) {
            abort(403);
        }

        $this->title = 'Менеджер статей';

        $articles = $this->getArticles();
        $this->content = view(config('settings.theme') . '.admin.articles_content', compact('articles'))->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Gate::denies('save', new Article()) ) {
            abort(403);
        }//ArticlePolicy

        $this->title = 'Добавить новую статью';
        $lists = $this->getCategoriesLists();
        $this->content = view(config('settings.theme') . '.admin.articles_create_content', compact('lists'))->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //php artisan make:request ArticleRequest
        $result = $this->a_rep->addArticle($request);

        if ( is_array($result) && !empty($result['error']) ){
            return back()->with($result);
        }
        
        return redirect()->route('articles.index')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        // для того что бы получить заполненную модель можно внедрить ее в вызов, но заполнена она будет только в случае если мы передаем id
        // для того что бы получить модель по alias, описываем правила в RouteServiceProvider в методе boot
        if ( Gate::denies('edit', new Article) ){ // ArticlePolicy
            abort(403);
        }

        $article->images = json_decode($article->images);

        $lists = $this->getCategoriesLists();
        $this->title = 'Редактирование материла ' . $article->title;
        $this->content = view(config('settings.theme') . '.admin.articles_create_content', compact('lists', 'article'))->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->a_rep->updateArticle($request, $article);

        if ( is_array($result) && !empty($result['error']) ){
            return back()->with($result);
        }

        return redirect()->route('articles.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $result = $this->a_rep->deleteArticle($article);

        
        if ( is_array($result) && !empty($result['error']) ){
            return back()->with($result);
        }

        return redirect()->route('articles.index')->with($result);
    }

    public function getArticles()
    {
        return $this->a_rep->get();
    }

    protected function getCategoriesLists()
    {
        $categories = Category::select(['id', 'title', 'alias', 'parent_id'])->get();
        $lists = [];
        foreach ($categories as $category){
            if($category->parent_id == 0){
                $lists[$category->title] = [];
            } else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        return $lists;
    }
}