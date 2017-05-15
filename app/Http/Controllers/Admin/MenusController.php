<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Category;
use Corp\Menu as MenuModel;
use Corp\Http\Requests\MenuRequest;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;
use Menu;

class MenusController extends AdminController
{
    protected $m_rep;

    public function __construct(MenusRepository $m_rep, ArticleRepository $a_rep, PortfolioRepository $p_rep)
    {
        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->template = '.admin.menus';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('VIEW_ADMIN_MENU')) { // AuthServiceProvider
            abort(403);
        }
        $menu = $this->getMenus();

        $this->title = 'Редактирование пунктов меню';

        $this->content = view(config('settings.theme') . '.admin.menus_content', compact('menu'))->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Новый пункт меню';
        $type = 'customLink'; //1=customLink, 2=blogLink, 3=portfolio;

        $menus = $this->getMenus()->roots()->reduce(function ($returnMenus, $menu) {
            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;
        }, ['0' => 'Родительский пункт меню']);

        $categories_tmp = Category::select(['id', 'title', 'alias', 'parent_id'])->get();

        $categories = ['0' => 'Не используется'];
        $categories['parent'] = 'Раздел блог';
        foreach ($categories_tmp as $category) {
            if ($category->parent_id == 0) {
                $categories[$category->title] = [];
            } else {
                $categories[$categories_tmp->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->getArticles()->reduce(function ($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $filters = \Corp\Filter::select('id', 'title', 'alias')->get()->reduce(function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->getPortfolios()->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.menus_create_content', compact('menus', 'categories', 'articles', 'filters', 'portfolios', 'type'))->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $result = $this->m_rep->addMenu($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect()->route('menus.index')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuModel $menu)
    {
        // для того что бы исползовать модель вместо id нужно в routeServiceProvider описать

        $this->title = 'Редактирование - ' . $menu->title;
        $type = false;
        $option = false;
        $aliasRoute = false;
        $parameters = [];


        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));
        $aliasRoute = $route->getName();
        $parameters = $route->parameters();

        if ($aliasRoute == 'articles.main.index' || $aliasRoute == 'articlesCat') {
            $type = 'blogLink';
            $option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
        } elseif ($aliasRoute == 'articles.main.show') {
            $type = 'blogLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        } elseif ($aliasRoute == 'portfolios.index') {
            $type = 'portfolioLink';
            $option = 'parent';
        } elseif ($aliasRoute == 'portfolios.show') {
            $type = 'portfolioLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        } else {
            $type = 'customLink';
        }


        $menus = $this->getMenus()->roots()->reduce(function ($returnMenus, $menu) {
            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;
        }, ['0' => 'Родительский пункт меню']);

        $categories_tmp = Category::select(['id', 'title', 'alias', 'parent_id'])->get();

        $categories = ['0' => 'Не используется'];
        $categories['parent'] = 'Раздел блог';
        foreach ($categories_tmp as $category) {
            if ($category->parent_id == 0) {
                $categories[$category->title] = [];
            } else {
                $categories[$categories_tmp->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->getArticles()->reduce(function ($returnArticles, $article) {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);

        $filters = \Corp\Filter::select('id', 'title', 'alias')->get()->reduce(function ($returnFilters, $filter) {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->getPortfolios()->reduce(function ($returnPortfolios, $portfolio) {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme') . '.admin.menus_create_content', compact('menus', 'categories', 'articles', 'filters', 'portfolios', 'option', 'type', 'menu'))->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuModel $menu)
    {
        $result = $this->m_rep->updateMenu($request, $menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect()->route('menus.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuModel $menu)
    {
        $result = $this->m_rep->deleteMenu($menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect()->route('menus.index')->with($result);
    }

    public function getMenus()
    {
        $menus = $this->m_rep->get();
        if ($menus->isEmpty()) {
            return false;
        }

        return Menu::make('forMenuPart', function ($m) use ($menus) {
            foreach ($menus as $menu) {
                if ($menu->parent_id == 0) {
                    $m->add($menu->title, $menu->path)->id($menu->id);
                } else {
                    if ($m->find($menu->parent_id)) {
                        $m->find($menu->parent_id)->add($menu->title, $menu->path)->id($menu->id);
                    }
                }
            }
        });
    }

    public function getArticles()
    {
        $articles = $this->a_rep->get([
            'select' => ['id', 'title', 'alias'],
        ]);
        return $articles;
    }

    public function getPortfolios()
    {
        $portfolios = $this->p_rep->get([
            ['select' => ['id', 'alias', 'title']]
        ]);
        return $portfolios;
    }
}




