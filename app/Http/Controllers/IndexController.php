<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\SlidersRepository;
use Corp\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Config;

class IndexController extends SiteController
{

    public function __construct(SlidersRepository $slider_rep,
                                PortfoliosRepository $portfolio_rep,
                                ArticlesRepository $articles_rep
                                ){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu()) );

        $this->portfolio_rep = $portfolio_rep;
        $this->slider_rep = $slider_rep;
        $this->articles_rep = $articles_rep;
        $this->bar = 'right';
        $this->template = config('settings.theme').'.index';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $portfolios = $this->getPortfolios();
        $content = view(config('settings.theme').'.content')->with('portfolios', $portfolios)->render();
        $this->vars['content'] = $content;

        $sliderData = $this->getSliders();
        $sliders = view(config('settings.theme').'.slider')->with('sliders', $sliderData)->render();
        $this->vars['sliders'] = $sliders;

        $articles = $this->getArticles();
        $this->contentRightBar = view(config('settings.theme').'.indexPageBar')->with('articles', $articles)->render();

        $this->title = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->keywords = 'Home Page';

        return $this->renderOutput();

    }

    protected function getPortfolios(){
        $portfolios = $this->portfolio_rep->get('*', Config::get('settings.home_port_count'));

        return $portfolios;
    }

    protected function getArticles(){
        $articles = $this->articles_rep->get(['title', 'img', 'created_at', 'alias'], Config::get('settings.home_articles_count'));

        return $articles;
    }

    public function getSliders(){
        $sliders = $this->slider_rep->get();

        if($sliders->isEmpty()){
            return false;
        }

        $sliders->transform(function($item) {
            $item->img = Config::get('settings.slider_path').'/'.$item->img;
            return $item;
        });

        return $sliders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
