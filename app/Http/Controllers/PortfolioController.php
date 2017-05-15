<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Config;

class PortfolioController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));
        $this->p_rep = $p_rep;

        $this->template = config('settings.theme') . '.portfolios';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';
        
        $portfolios = $this->getPortfolios([
            'revert' => 'id',
            'pagination' => Config::get('settings.portfolios_paginate'),
        ]);

       // dd($portfolios);
        $content = view(config('settings.theme') . '.portfolios_content', compact('portfolios'))->render();
        $this->vars['content'] = $content;

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
        $portfolio = $this->p_rep->one($alias);

        $this->title = $portfolio->title;
        //$this->keywords = $portfolio->keywords;
        //$this->meta_desc = $portfolio->meta_desc;

        $portfolios = $this->getPortfolios([
            'take' => Config::get('settings.other_portfolios'),
        ]);

        $content = view(config('settings.theme') . '.portfolio_content', compact('portfolio', 'portfolios'))->render();

        $this->vars['content'] = $content;

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

    private function getPortfolios($arr)
    {
        $portfolios = $this->p_rep->get($arr);
        if ($portfolios) {
            $portfolios->load('filter');
        }
        return $portfolios;
    }
}
