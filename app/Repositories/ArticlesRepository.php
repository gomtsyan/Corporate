<?php

namespace Corp\Repositories;

use Corp\Article;
use Gate;
use Image;
use Str;
use Config;
use File;

class ArticlesRepository extends Repository{


    public function __construct(Article $article){

       $this->model = $article;

    }

    public function one($select = '*', $alias, $attr = array()) {

        $article = parent::one($select, $alias, $attr);

        if($article && !empty($attr)) {

            $article->load('comments');
            $article->comments->load('user');

        }

        return $article;

    }

    public function addArticle($request) {

        if(Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }

        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        if($this->one('*', $data['alias'])) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Alias already exists'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()){

                $str = Str::random(8);

                $img_obj = new \stdClass();

                $img_obj->mini = $str.'_mini.jpg';
                $img_obj->max = $str.'_max.jpg';
                $img_obj->path = $str.'_path.jpg';

                $this->addImage($image, Config::get('settings.image')['width'], Config::get('settings.image')['height'], 'articles/'.$img_obj->path);
                $this->addImage($image, Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['height'], 'articles/'.$img_obj->max);
                $this->addImage($image, Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'], 'articles/'.$img_obj->mini);

                $data['img'] = json_encode($img_obj);

                $this->model->fill($data);

                if($request->user()->articles()->save($this->model)) {
                    return ['status'=>'Article is added'];
                }

            }
        }else{
            $request->flash();
            return array('error' => 'Select photo file');
        }



    }

    public function updateArticle($request, $article) {

        if(Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image', '_method');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }

        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one('*', $data['alias']);

        if(isset($result->id) && $result->id !== $article->id) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Alias already exists'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()){

                $str = Str::random(8);

                $img_obj = new \stdClass();

                $img_obj->mini = $str.'_mini.jpg';
                $img_obj->max = $str.'_max.jpg';
                $img_obj->path = $str.'_path.jpg';

                $this->addImage($image, Config::get('settings.image')['width'], Config::get('settings.image')['height'], 'articles/'.$img_obj->path);
                $this->addImage($image, Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['height'], 'articles/'.$img_obj->max);
                $this->addImage($image, Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['height'], 'articles/'.$img_obj->mini);

                $data['img'] = json_encode($img_obj);

                $aricle_old_images = json_decode($article->img);

                if($aricle_old_images){
                    foreach($aricle_old_images as $aricle_image){

                        $this->deleteImage($aricle_image, 'articles');

                    }
                }

            }

        }


        $article->fill($data);

        if($article->update()) {
            return ['status'=>'Article is updated'];
        }

    }

    public function deleteArticle($article) {

        if(Gate::denies('destroy', $article)) {
            abort(403);
        }

        $article->comments()->delete();

        if($article->delete()) {

            $aricle_images = json_decode($article->img);

            if($aricle_images){
                foreach($aricle_images as $aricle_image){

                    $this->deleteImage($aricle_image, 'articles');

                }
            }

            return ['status'=>'Article is deleted'];
        }


    }


}