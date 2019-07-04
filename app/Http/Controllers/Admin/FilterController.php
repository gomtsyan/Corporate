<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Filter;
use Corp\Http\Requests\FilterRequest;
use Corp\Repositories\FiltersRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class FilterController extends AdminController
{

    protected $filters_rep;

    public function __construct(FiltersRepository $filters_rep) {

        parent::__construct();

        $this->filters_rep = $filters_rep;

        $this->template = config('settings.theme').'.admin.filters';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('EDIT_CATEGORY');

        $this->title = 'Filter Table';

        $filters = $this->getFilters();

        $this->content = view(config('settings.theme').'.admin.filter_content')->with('filters', $filters)->render();

        return $this->renderOutput();

    }

    protected function getFilters(){

        $filters = $this->filters_rep->get(['id', 'alias', 'title']);

        return $filters;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(\Gate::denies('save', new \Corp\Filter())) {
            abort(403);
        }

        $this->title = 'New Filter';

        $this->content = view(config('settings.theme').'.admin.filter_create_content')->render();

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilterRequest $request) {

        $result = $this->filters_rep->addFilter($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/filter')->with($result);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter) {

        if(\Gate::denies('edit', new \Corp\Category())){
            abort(403);
        }

        $this->title = 'Edit Filter - '.$filter->title;

        $this->content = view(config('settings.theme').'.admin.filter_create_content')->with(['filter'=>$filter])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilterRequest $request, Filter $filter) {

        $result = $this->filters_rep->updateFilter($request, $filter);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/filter')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filter $filter) {

        $result = $this->filters_rep->deleteFilter($filter);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/filter')->with($result);

    }
}
