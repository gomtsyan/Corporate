<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model {

    protected $fillable = [
        'title', 'img', 'alias', 'text', 'customer', 'keywords', 'meta_desc', 'filter_alias'
    ];

    public function filter() {
        return $this->belongsTo('Corp\Filter', 'filter_alias', 'alias');

    }

}
