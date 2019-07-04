<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
        'title', 'alias'
    ];

    public function portfolios() {
        return $this->hasMany('Corp\Portfolio', 'filter_alias', 'alias');
    }
}
