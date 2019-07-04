<?php

namespace Corp\Repositories;

use Corp\Slider;

class SlidersRepository extends Repository{


    public function __construct(Slider $slider){

       $this->model = $slider;

    }

    public function addSlider($request) {

        if(\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()){

                $str = \Str::random(8);

                $img_name = $str.'_slide.jpg';
                $dir_name = 'slider-cycle';

                $this->addImage($image, \Config::get('settings.slider_image')['width'], \Config::get('settings.slider_image')['height'], $dir_name.'/'.$img_name);


                $data['img'] = $img_name;

                $this->model->fill($data);

                if($this->model->save()) {
                    return ['status'=>'Slide is added'];
                }

            }
        }else{
            $request->flash();
            return array('error' => 'Select photo file');
        }



    }

    public function updateSlider($request, $slider) {

        if(\Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image', '_method');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');

            if($image->isValid()){

                $str = \Str::random(8);

                $img_name = $str.'_slide.jpg';
                $dir_name = 'slider-cycle';

                $this->addImage($image, \Config::get('settings.slider_image')['width'], \Config::get('settings.slider_image')['height'], $dir_name.'/'.$img_name);


                $data['img'] = $img_name;

                $slider_old_image = $slider->img;

                if($slider_old_image){

                    $this->deleteImage($slider_old_image, $dir_name);

                }

            }
        }

        $slider->fill($data);

        if($slider->save()) {
            return ['status'=>'Slide is udated'];
        }

    }

    public function deleteSlider($slider) {

        if(\Gate::denies('destroy', $slider)) {
            abort(403);
        }


        if($slider->delete()) {

            $slider_image = $slider->img;
            $dir_name = 'slider-cycle';

            if($slider_image){

                $this->deleteImage($slider_image, $dir_name);
            }

            return ['status'=>'Slide is deleted'];
        }
    }

}