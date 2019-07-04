<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Menu;

class SiteController extends Controller
{
    protected $portfolio_rep;
    protected $slider_rep;
    protected $articles_rep;
    protected $menu_rep;

    protected $template;

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $vars = array();

    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;

    protected $bar = 'no';

    public function __construct(MenusRepository $menu_rep){
        $this->menu_rep = $menu_rep;
    }

    protected function renderOutput() {

        $menu = $this->getMenu();

        $navigation = view(config('settings.theme').'.navigation')->with('menu', $menu)->render();

        $this->vars['navigation'] = $navigation;

        if($this->contentRightBar) {
            $rightBar = view(config('settings.theme').'.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars['rightBar'] = $rightBar;
        }

        if($this->contentLeftBar) {
            $leftBar = view(config('settings.theme').'.leftBar')->with('content_leftBar', $this->contentLeftBar)->render();
            $this->vars['leftBar'] = $leftBar;
        }

        $this->vars['bar'] = $this->bar;

        $footer = view(config('settings.theme').'.footer')->render();
        $this->vars['footer'] = $footer;

        $this->vars['keywords'] = $this->keywords;
        $this->vars['meta_desc'] = $this->meta_desc;
        $this->vars['title'] = $this->title;

        return view($this->template)->with($this->vars);

    }

    public function getMenu() {

        $menu = $this->menu_rep->get();

        $menuBuilder = Menu::make('TopMenu', function($m) use ($menu) {

            foreach($menu as $item) {
                if($item->parent_id == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                }else{

                    if($m->find($item->parent_id)){
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }

                }
            }

        });

        return $menuBuilder;
    }

}
