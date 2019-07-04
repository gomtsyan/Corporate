<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title', 'path', 'parent_id', 'category_alias'
    ];

    public function category() {
        return $this->belongsTo('Corp\Category', 'category_alias', 'alias');

    }

    public function delete(array $options = []) {

        self::where('parent_id',$this->id)->delete();

        return parent::delete($options);


    }

}
