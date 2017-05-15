<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
        'title',
        'alias',
    ];

    public function portfolios()
    {
        $this->belongsToMany('Corp\Portfolio', 'alias', 'filter_alias');
    }
}
