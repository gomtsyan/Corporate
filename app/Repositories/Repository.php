<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 6/12/19
 * Time: 5:28 PM
 */

namespace Corp\Repositories;

use Config;
use Image;
use File;

abstract class Repository{

    protected $model = false;

    public function get($select = '*', $take = false, $pagination = false, $where = false, $orderBy=[]){

        $builder = $this->model->select($select);

        if($where) {
            $builder->where($where[0], $where[1]);
        }

        if($take) {
            $builder->take($take);
        }

        if($pagination) {

          return   $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        if(!empty($orderBy)) {
            $builder->orderBy($orderBy[0], $orderBy[1]);
        }


        return $this->check($builder->get());
    }

    public function one($select = '*', $alias, $attr = array()) {

        $builder = $this->model->select($select)->where('alias', $alias)->first();

        return $builder;

    }

    protected function check($result) {

        if($result->isEmpty()) {
            return false;
        }

        $result->transform(function($item, $key) {

            if(is_string($item->img) &&
                is_object(json_decode($item->img)) &&
                (json_last_error() == JSON_ERROR_NONE)
            )
            {
                $item->img = json_decode($item->img);
            }



            return $item;
        });

        return $result;

    }

    public function transliterate($string) {

        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );

        foreach($leter_array as $kyr=>$lat) {
            $str = str_replace($kyr, $lat, $str);
        }

        $str = preg_replace('/(\s|[^a-zA-Z0-9\-])+/', '-', $str);

        $str = trim($str, '-');

        return $str;

    }

    public function addImage($image, $width, $height, $path) {

        $img = Image::make($image);

        $img->fit($width, $height)->save(public_path().'/'.config('settings.theme').'/images/'.$path);
    }

    public function deleteImage($image, $dir_name) {

        $file = public_path().'/'.config('settings.theme').'/images/'.$dir_name.'/'.$image;

        if(File::isFile($file)) {

            File::delete($file);

        }

    }

}