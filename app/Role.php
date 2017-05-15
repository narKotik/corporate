<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany('Corp\User', 'user_role');
    }

    public function permissions()
    {
        return $this->belongsToMany('Corp\Permission', 'permission_role');
    }

    public function hasPermition($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $permitionName) {
                $hasPermition = $this->hasPermition($permitionName);

                if ($hasPermition && !$require) {
                    return true;
                } elseif (!$hasPermition && $require) {
                    return false;
                }
            }
            //return $require;
        } else {
            foreach ($this->permissions as $permition) {
                if ($permition->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function savePermitions($arrPermissions)
    {
        if(!empty($arrPermissions)){
            $this->permissions()->sync($arrPermissions); // для заполнения и удалениия ячеек связной таблицы role_permissions
        }else{
            $this->permissions()->detach(); // удаление привилегий если они были
        }
    }
}
