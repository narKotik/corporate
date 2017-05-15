<?php

namespace Corp\Http\Controllers;

use Corp\Article;
use Corp\Menu;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfolioRepository;
use Corp\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Config;

class IndexController extends SiteController
{

    public function __construct(SliderRepository $s_rep, PortfolioRepository $p_rep, ArticleRepository $a_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->template = config('settings.theme') . '.index';
        $this->bar = 'right';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = $this->getPortfolio();
        $content = view(config('settings.theme') .'.content', compact('portfolios'))->render();
        $this->vars['content'] = $content;
        
        $sliderItems = $this->getSliders();
        $sliders = view(config('settings.theme') .'.slider', compact('sliderItems'))->render();
        $this->vars['sliders'] = $sliders;

        $articles = $this->getArticles();
        $this->contentRightBar = view(config('settings.theme') .'.indexbar', compact('articles'))->render();

        $this->keywords = 'Home page';
        $this->meta_desc = 'Home page';
        $this->title = 'Home page';

        return $this->renderOutput();
    }

    public function getSliders()
    {
        $sliders = $this->s_rep->get();

        if($sliders->isEmpty()){
            return false;
        }

        $sliders->transform(function($item, $key){
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });

        
        return $sliders;
    }

    public function getPortfolio()
    {
        $portfolio = $this->p_rep->get([
            'take' => Config::get('settings.home_port_count'),
            'revert' => 'id',
        ]);
        return $portfolio;
    }

    public function getArticles()
    {
        $articles = $this->a_rep->get([
            'select' => ['title', 'created_at', 'images', 'alias'],
            'take' => Config::get('settings.home_articles_count'),
            'revert' => 'id'
        ]);
        return $articles;
    }
}
