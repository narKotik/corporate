<?php


namespace Corp\Repositories;


use Corp\Role;

class RoleRepository
    extends Repository
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }
}