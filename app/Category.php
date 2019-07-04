<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'alias', 'parent_id'
    ];

    public function articles() {
        return $this->hasMany('Corp\Article');
    }

    public function menu() {
        return $this->belongsTo('Corp\Menu', 'alias', 'category_alias');
    }

    public function delete(array $options = []) {

        self::where('parent_id',$this->id)->delete();

        return parent::delete($options);


    }
}
