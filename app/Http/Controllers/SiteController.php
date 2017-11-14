<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Menu;

class SiteController extends Controller
{
    protected $p_rep;//portfolio_repository
    protected $s_rep;//slider
    protected $a_rep;//articles
    protected $m_rep;//menus

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template;
    protected $vars = [];

    protected $bar = 'no';
    protected $contentRightBar = false;
    protected $contentLeftBar = false;

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();
        $this->vars['menu'] = $menu;
        //dd($menu);

        $navigation = view(config('settings.theme').'.navigation', compact('menu'))->render();
        $this->vars['navigation'] = $navigation;
        
        if ($this->contentRightBar) {
            $rightBar = view(config('settings.theme') .'.rightbar', ['content_rightBar' => $this->contentRightBar])->render();
            $this->vars['rightBar'] = $rightBar;
        }
        if ($this->contentLeftBar) {
            $leftBar = view(config('settings.theme') .'.leftbar', ['content_leftBar' => $this->contentLeftBar])->render();
            $this->vars['leftBar'] = $leftBar;
        }

        $this->vars['bar'] = $this->bar;

        $this->vars['title'] = $this->title;
        $this->vars['keywords'] = $this->keywords;
        $this->vars['meta_desc'] = $this->meta_desc;

        $footer = view(config('settings.theme') .'.footer')->render();
        $this->vars['footer'] = $footer;

        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            foreach ($menu as $item) {
                if (!$item->parent_id) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent_id)) {
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        return $mBuilder;
    }

    
}
