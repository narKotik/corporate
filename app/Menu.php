<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'path',
        'parent_id',
    ];

    public function delete($options = [])
    {
        self::where('parent_id', $this->id)->delete(); // удаление всех подпунктов меню если они есть
        return parent::delete($options);
    }
}
