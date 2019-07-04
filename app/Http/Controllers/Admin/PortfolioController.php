<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\PortfolioRequest;
use Corp\Portfolio;
use Corp\Repositories\FiltersRepository;
use Corp\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class PortfolioController extends AdminController
{

    protected $filters_rep;

    public function __construct(PortfoliosRepository $portfolio_rep, FiltersRepository $filters_rep) {

        parent::__construct();

        $this->portfolio_rep = $portfolio_rep;

        $this->filters_rep = $filters_rep;

        $this->template = config('settings.theme').'.admin.portfolios';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('VIEW_ADMIN_PORTFOLIOS');

        $this->title = 'Portfolios Table';

        $portfolios = $this->getPortfolios();

        $this->content = view(config('settings.theme').'.admin.portfolios_content')->with('portfolios', $portfolios)->render();

        return $this->renderOutput();

    }

    protected function getPortfolios(){

        $portfolios = $this->portfolio_rep->get(['id', 'title', 'img', 'alias', 'text', 'customer', 'filter_alias']);

        return $portfolios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(\Gate::denies('save', new \Corp\Portfolio())) {
            abort(403);
        }

        $this->title = 'New Portfolio';

        $filters = $this->getFilters();

        $lists = array();

        foreach($filters as $filter) {
            $lists[$filter->alias] = $filter->title;
        }

        $this->content = view(config('settings.theme').'.admin.portfolio_create_content')->with('filters', $lists)->render();

        return $this->renderOutput();

    }

    protected function getFilters(){

        return $this->filters_rep->get(['title', 'alias', 'id']);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request) {

        $result = $this->portfolio_rep->addPortfolio($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/portfolio')->with($result);

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
    public function edit(Portfolio $portfolio) {

        if(\Gate::denies('edit', new Portfolio)){
            abort(403);
        }

        $this->title = 'Edit Portfolio - '.$portfolio->title;

        $portfolio->img = json_decode($portfolio->img);

        $filters = $this->getFilters();

        $lists = array();

        foreach($filters as $filter) {
            $lists[$filter->alias] = $filter->title;

        }

        $this->content = view(config('settings.theme').'.admin.portfolio_create_content')->with(['filters'=> $lists, 'portfolio'=>$portfolio])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfolioRequest $request, Portfolio $portfolio) {

        $result = $this->portfolio_rep->updatePortfolio($request, $portfolio);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/portfolio')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio) {

        $result = $this->portfolio_rep->deletePortfolio($portfolio);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/portfolio')->with($result);

    }
}
