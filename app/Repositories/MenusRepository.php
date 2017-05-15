<?php


namespace Corp\Repositories;

use Corp\Menu;
use Gate;

class MenusRepository
    extends Repository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function addMenu($request)
    {
        if (Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->only('type', 'title', 'parent_id');

        switch ($data['type']) {
            case 'customLink':

                $data['path'] = $request->input('custom_link');
                break;

            case 'blogLink':

                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.main.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } elseif ($request->input('article_alias')) {
                    $data['path'] = route('articles.main.show', ['alias' => $request->input('article_alias')]);
                }
                break;

            case 'portfolioLink':

                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }

                break;
            default:
                $data['path'] = '/';
        }

        unset($data['type']);

        if ($this->model->fill($data)->save()) {
            return ['status' => 'Новый меню пункт добавлен'];
        }
    }

    public function updateMenu($request, $menu)
    {
        if (Gate::denies('update', $this->model)) {
            abort(403);
        }

        $data = $request->only('type', 'title', 'parent_id');

        switch ($data['type']) {
            case 'customLink':

                $data['path'] = $request->input('custom_link');
                break;

            case 'blogLink':

                if ($request->input('category_alias')) {
                    if ($request->input('category_alias') == 'parent') {
                        $data['path'] = route('articles.main.index');
                    } else {
                        $data['path'] = route('articlesCat', ['cat_alias' => $request->input('category_alias')]);
                    }
                } elseif ($request->input('article_alias')) {
                    $data['path'] = route('articles.main.show', ['alias' => $request->input('article_alias')]);
                }
                break;

            case 'portfolioLink':

                if ($request->input('filter_alias')) {
                    if ($request->input('filter_alias') == 'parent') {
                        $data['path'] = route('portfolios.index');
                    }
                } elseif ($request->input('portfolio_alias')) {
                    $data['path'] = route('portfolios.show', ['alias' => $request->input('portfolio_alias')]);
                }

                break;
            default:
                $data['path'] = '/';
        }

        unset($data['type']);

        if ($menu->fill($data)->update()) {
            return ['status' => 'Пункт меню обновлен.'];
        }
    }

    public function deleteMenu($menu)
    {
        if (Gate::denies('delete', $this->model)) {
            abort(403);
        }

        if ($menu->delete()) {
            return ['status' => 'Пункт меню удален.'];
        }
    }
}