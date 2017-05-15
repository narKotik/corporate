<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Auth;
use Menu;
use Gate;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = false;
    protected $title = '';
    protected $vars = [];
    
    public function renderOutput()
    {
        $this->user = Auth::user();
        if (!$this->user) {
            abort(403);
        }
        
        $this->vars['title'] = $this->title;

        $menu = $this->getMemu();

        $navigation = view(config('settings.theme') . '.admin.navigation', compact('menu'))->render();
        $this->vars['navigation'] = $navigation;

        if ( $this->content ){
            $this->vars['content'] = $this->content;
        }

        $footer = view(config('settings.theme') . '.admin.footer')->render();
        $this->vars['footer'] = $footer;
        
        return view(config('settings.theme') . $this->template, $this->vars);
    }

    public function getMemu()
    {
        return Menu::make('adminMenu', function ($menu) {

            if(Gate::allows('VIEW_ADMIN_ARTICLES')){
                $menu->add('Статьи', ['route' => 'articles.index']);
            }

            $menu->add('Портфолио', ['route' => 'articles.index']);

            if(Gate::allows('VIEW_ADMIN_MENU')){
                $menu->add('Меню', ['route' => 'menus.index']);
            }
            if(Gate::allows('VIEW_ADMIN_USERS')){
                $menu->add('Пользователи', ['route' => 'users.index']);
            }
            if(Gate::allows('VIEW_ADMIN_PERMITION')) {
                $menu->add('Привилегии', ['route' => 'permitions.index']);
            }
        });
    }
}
