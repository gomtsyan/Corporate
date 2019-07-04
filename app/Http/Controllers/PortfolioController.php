<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;

class PortfolioController extends SiteController {


    public function __construct(PortfoliosRepository $portfolio_rep){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu()));

        $this->portfolio_rep = $portfolio_rep;


        $this->template = config('settings.theme').'.portfolios';

    }

    public function index() {

        $portfolios = $this->getPortfolios();

        $content = view(config('settings.theme').'.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars['content'] = $content;


        $this->title = 'Portfolio';
        $this->meta_desc = 'Portfolios Page';
        $this->keywords = 'Portfolios Page';

        return $this->renderOutput();

    }

    protected function getPortfolios($take = false, $paginate = true){

        $portfolios = $this->portfolio_rep->get('*', $take, $paginate);

        if($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }

    public function show($alias = false) {

        $portfolio = $this->portfolio_rep->one('*', $alias);

        if($portfolio && is_object($portfolio)){
            $this->title = $portfolio->title;
            $this->keywords = $portfolio->keywords;
            $this->meta_desc = $portfolio->meta_desc;
        }



        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);

        $content = view(config('settings.theme').'.portfolio_content')->with(['portfolio'=> $portfolio, 'portfolios'=> $portfolios])->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }


}
