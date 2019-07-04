<?php

namespace Corp\Repositories;

use Corp\Filter;

class FiltersRepository extends Repository{


    public function __construct(Filter $filter){

       $this->model = $filter;

    }

    public function addFilter($request) {

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
            return ['status'=>'Filter is added'];
        }

    }

    public function updateFilter($request, $filter) {

        if(\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->only('title', 'alias');


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



        $filter->fill($data);

        if($filter->update()) {

            if(isset($filter->portfolios) && is_object($filter->portfolios)){

                $portfolio_filter_arr = array();

                $portfolio_filter_arr['filter_alias'] = $data['alias'];

                $filter->portfolios()->update($portfolio_filter_arr);

            }

            return ['status'=>'Filter is updated'];
        }


    }

    public function deleteFilter($filter) {

        if(\Gate::denies('destroy', $this->model)) {
            abort(403);
        }

        if(isset($filter->portfolios) && is_object($filter->portfolios)){

            $filter->portfolios()->delete();

        }

        if($filter->delete()) {
            return ['status'=>'Filter is deleted'];
        }


    }

}