<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Category;
use Corp\Http\Requests\MenuRequest;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;
use Menu;

class MenuController extends AdminController
{

    protected $menu_rep;

    public function __construct(MenusRepository $menu_rep, ArticlesRepository $articles_rep, PortfoliosRepository $portfolios_rep) {

        parent::__construct();

        $this->menu_rep = $menu_rep;

        $this->articles_rep = $articles_rep;

        $this->portfolios_rep = $portfolios_rep;

        $this->template = config('settings.theme').'.admin.menu';

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->hasPermission('VIEW_ADMIN_MENU');

        $this->title = 'Menu Items';

        $menu = $this->getMenus();

        $this->content = view(config('settings.theme').'.admin.menu_content')->with(['menu'=> $menu])->render();

        return $this->renderOutput();
    }

    public function getMenus()
    {
        $menu = $this->menu_rep->get();

        if($menu->isEmpty()) {
            return false;
        }

        return Menu::make('forMenuPart', function($m) use ($menu) {

            foreach($menu as $menu_item) {
                if($menu_item->parent_id == 0){
                    $m->add($menu_item->title, $menu_item->path)->id($menu_item->id);
                }else{

                    if($m->find($menu_item->parent_id)) {
                        $m->find($menu_item->parent_id)->add($menu_item->title, $menu_item->path)->id($menu_item->id);
                    }
                }
            }

        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $this->title = 'New menu item';

        $tmp_menu = $this->getMenus()->roots();

        $menus = $tmp_menu->reduce(function($returnMenus, $menu) {

            $returnMenus[$menu->id] = $menu->title;

            return $returnMenus;

        }, ['0'=>'Parent item menu']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        $category_list = array();
        $category_list['0'] = 'not used';
        $category_list['parent'] = 'Blog section';

        foreach($categories as $category) {

            if($category->parent_id == 0){

                $category_list[$category->title] = array();

            }else{
                if(!$category->menu){

                    $category_list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
                }

            }

        }

        $aricles = $this->articles_rep->get(['id', 'title', 'alias']);


        $aricles = $aricles->reduce(function($returnArticles, $article) {

            $returnArticles[$article->alias] = $article->title;

            return $returnArticles;

        }, ['0'=>'not used']);

        $filers = \Corp\Filter::select(['id', 'title', 'alias'])->get()->reduce(function($returnFilters, $filter) {

            $returnFilters[$filter->alias] = $filter->title;

            return $returnFilters;

        }, ['0'=>'not used','parent'=>'Portfolio section']);

        $portfolios = \Corp\Portfolio::select(['id', 'title', 'alias'])->get()->reduce(function($returnPortfolios, $portfolio) {

            $returnPortfolios[$portfolio->alias] = $portfolio->title;

            return $returnPortfolios;

        }, ['0'=>'not used']);

        $this->content = view(config('settings.theme').'.admin.menu_create_content')
                        ->with([
                                    'menus'=> $menus,
                                    'categories'=> $category_list,
                                    'articles'=> $aricles,
                                    'filers'=> $filers,
                                    'portfolios'=> $portfolios
                                ])->render();

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request) {

        $result = $this->menu_rep->addMenu($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/menu')->with($result);

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
    public function edit(\Corp\Menu $menu) {

        $this->title = 'Edit menu - '.$menu->title;

        $type = false;
        $option = false;

        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));

        $aliasRoute = $route->getName();
        $parameters = $route->parameters();

        if($aliasRoute == 'articles.index' || $aliasRoute == 'articlesCat') {
            $type = 'blogLink';
            $option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
        }elseif ($aliasRoute == 'articles.show'){
            $type = 'blogLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        }elseif ($aliasRoute == 'portfolios.index'){
            $type = 'portfolioLink';
            $option = 'parent';
        }
        elseif ($aliasRoute == 'portfolios.show'){
            $type = 'portfolioLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        }else{
            $type = 'customLink';
        }


        $tmp_menu = $this->getMenus()->roots();

        $menus = $tmp_menu->reduce(function($returnMenus, $menu) {

            $returnMenus[$menu->id] = $menu->title;

            return $returnMenus;

        }, ['0'=>'Parent item menu']);

        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();

        $category_list = array();
        $category_list['0'] = 'not used';
        $category_list['parent'] = 'Blog section';

        foreach($categories as $category) {

            if($category->parent_id == 0){

                $category_list[$category->title] = array();

            }else{
                if(!$category->menu || $menu->category_alias == $category->alias){

                    $category_list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
                }

            }

        }

        $aricles = $this->articles_rep->get(['id', 'title', 'alias']);


        $aricles = $aricles->reduce(function($returnArticles, $article) {

            $returnArticles[$article->alias] = $article->title;

            return $returnArticles;

        }, ['0'=>'not used']);

        $filers = \Corp\Filter::select(['id', 'title', 'alias'])->get()->reduce(function($returnFilters, $filter) {

            $returnFilters[$filter->alias] = $filter->title;

            return $returnFilters;

        }, ['0'=>'not used','parent'=>'Portfolio section']);

        $portfolios = \Corp\Portfolio::select(['id', 'title', 'alias'])->get()->reduce(function($returnPortfolios, $portfolio) {

            $returnPortfolios[$portfolio->alias] = $portfolio->title;

            return $returnPortfolios;

        }, ['0'=>'not used']);

        $this->content = view(config('settings.theme').'.admin.menu_create_content')
            ->with([
                'type'=> $type,
                'option'=> $option,
                'menus'=> $menus,
                'menu'=> $menu,
                'categories'=> $category_list,
                'articles'=> $aricles,
                'filers'=> $filers,
                'portfolios'=> $portfolios
            ])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \Corp\Menu $menu) {

        $result = $this->menu_rep->updateMenu($request, $menu);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/menu')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Corp\Menu $menu) {

        $result = $this->menu_rep->deleteMenu($menu);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/menu')->with($result);

    }


}
