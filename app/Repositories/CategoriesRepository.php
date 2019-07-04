<?php

namespace Corp\Repositories;

use Corp\Category;

class CategoriesRepository extends Repository{


    public function __construct(Category $category){

       $this->model = $category;

    }

    public function addCategory($request) {

        if(\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token');


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

        $this->model->fill($data);

        if($this->model->save()) {
            return ['status'=>'Category is added'];
        }


    }

    public function updateCategory($request, $category) {

        if(\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->only('title', 'alias', 'parent_id');


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


        if(isset($category->menu) && is_object($category->menu)){

            $menu = array();
            $menu_path_arr = explode('/',$category->menu->path);

            $last_key = count($menu_path_arr)-1;
            \Arr::set($menu_path_arr, $last_key, $data['alias']);
            $menu_path = implode('/', $menu_path_arr);
            $menu['path'] = $menu_path;
            $menu['category_alias'] = $data['alias'];

            $category->menu()->update($menu);
        }


        $category->fill($data);

        if($category->update()) {

            return ['status'=>'Category is updated'];
        }


    }

    public function deleteCategory($category) {

        if(\Gate::denies('destroy', $this->model)) {
            abort(403);
        }

        if(isset($category->menu) && is_object($category->menu)){
            $category->menu()->delete();
        }

        if(isset($category->articles) && is_object($category->articles)){
            $category->articles()->delete();
        }

        if($category->delete()) {
            return ['status'=>'Category is deleted'];
        }


    }

}