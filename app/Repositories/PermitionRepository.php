<?php


namespace Corp\Repositories;


use Corp\Permission;
use Gate;

class PermitionRepository
    extends Repository
{
    protected $rol_rep;
    public function __construct(Permission $permission, RoleRepository $rol_rep)
    {
        $this->rol_rep = $rol_rep;
        $this->model = $permission;
    }

    public function changePermission($request)
    {
        if(Gate::denies('change', $this->model)){
            abort(403);
        }
        //php artisan make:policy PermitionPolicy

        $data = $request->except('_token');
        $roles = $this->rol_rep->get();

        foreach ($roles as $role) {
            if( isset($data[$role->id]) ){
                $role->savePermitions($data[$role->id]);
            }else{
                $role->savePermitions([]);
            }
        }

        return ['status' => 'Изменения сохранены'];
    }
}