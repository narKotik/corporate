<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'text',
        'customer',
        'alias',
        'images',
        'filter_alias',
    ];

    public function filter()
    {
        return $this->belongsTo('Corp\Filter', 'filter_alias', 'alias');
    }
}
