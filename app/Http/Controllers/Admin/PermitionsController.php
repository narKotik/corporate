<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Repositories\PermitionRepository;
use Corp\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;

class PermitionsController extends AdminController
{

    protected $per_rep;
    protected $rol_rep;
    
    public function __construct(PermitionRepository $per_rep, RoleRepository $rol_rep)
    {
        $this->rol_rep = $rol_rep;
        $this->per_rep = $per_rep;
        
        $this->template = '.admin.permitions';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('EDIT_USERS')){
            abort(403);
        }

        $this->title = 'Менеджер прав пользователей';

        $roles = $this->getRoles();
        $permitions = $this->getPermitions();
        
        $this->content = view(config('settings.theme') . '.admin.permitions_content', compact('roles', 'permitions'))->render();
        
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
        //php artisan make:request ArticleRequest
        $result = $this->per_rep->changePermission($request);

        /*if ( is_array($result) && !empty($result['error']) ){
            return back()->with($result);
        }*/

        return back()->with($result);
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

    public function getRoles()
    {
        $roles = $this->rol_rep->get();

        return $roles;
    }

    public function getPermitions()
    {
        $permitions = $this->per_rep->get();

        return $permitions;
    }
}
