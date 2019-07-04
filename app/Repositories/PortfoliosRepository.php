<?php

namespace Corp\Repositories;

use Corp\Portfolio;
use Config;

class PortfoliosRepository extends Repository{


    public function __construct(Portfolio $portfolio){

       $this->model = $portfolio;

    }

    public function one($select = '*', $alias, $attr = array()) {

        $portfolio = parent::one($select, $alias, $attr);

        if($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }

        return $portfolio;

    }

    public function addPortfolio($request) {

        if(\Gate::denies('save', $this->model)) {
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

                $str = \Str::random(8);

                $img_obj = new \stdClass();

                $img_obj->mini = $str.'_mini.jpg';
                $img_obj->max = $str.'_max.jpg';
                $img_obj->path = $str.'_path.jpg';

                $this->addImage($image, Config::get('settings.image')['width'], Config::get('settings.image')['height'], 'projects/'.$img_obj->path);
                $this->addImage($image, Config::get('settings.portfolios_img')['max']['width'], Config::get('settings.portfolios_img')['max']['height'], 'projects/'.$img_obj->max);
                $this->addImage($image, Config::get('settings.portfolios_img')['mini']['width'], Config::get('settings.portfolios_img')['mini']['height'], 'projects/'.$img_obj->mini);

                $data['img'] = json_encode($img_obj);

                $this->model->fill($data);

                if($this->model->save()) {
                    return ['status'=>'Portfolio is added'];
                }

            }
        }else{
            $request->flash();
            return array('error' => 'Select photo file');
        }

    }

    public function updatePortfolio($request, $portfolio) {

        if(\Gate::denies('edit', $this->model)) {
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

        if(isset($result->id) && $result->id !== $portfolio->id) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Alias already exists'];
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()){

                $str = \Str::random(8);

                $img_obj = new \stdClass();

                $img_obj->mini = $str.'_mini.jpg';
                $img_obj->max = $str.'_max.jpg';
                $img_obj->path = $str.'_path.jpg';

                $this->addImage($image, Config::get('settings.image')['width'], Config::get('settings.image')['height'], 'projects/'.$img_obj->path);
                $this->addImage($image, Config::get('settings.portfolios_img')['max']['width'], Config::get('settings.portfolios_img')['max']['height'], 'projects/'.$img_obj->max);
                $this->addImage($image, Config::get('settings.portfolios_img')['mini']['width'], Config::get('settings.portfolios_img')['mini']['height'], 'projects/'.$img_obj->mini);

                $data['img'] = json_encode($img_obj);

                $portfolio_old_images = json_decode($portfolio->img);

                if($portfolio_old_images){
                    foreach($portfolio_old_images as $portfolio_image){

                        $this->deleteImage($portfolio_image, 'projects');

                    }
                }

            }

        }


        $portfolio->fill($data);

        if($portfolio->update()) {
            return ['status'=>'Portfolio is updated'];
        }

    }

    public function deletePortfolio($portfolio) {

        if(\Gate::denies('destroy', $portfolio)) {
            abort(403);
        }

        if($portfolio->delete()) {

            $portfolio_images = json_decode($portfolio->img);

            if($portfolio_images){
                foreach($portfolio_images as $portfolio_image){

                    $this->deleteImage($portfolio_image, 'projects');

                }
            }

            return ['status'=>'Portfolio is deleted'];
        }
    }

}