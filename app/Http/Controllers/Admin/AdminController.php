<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Auth;
use Menu;
use Gate;

class AdminController extends Controller {


    protected $portfolio_rep;

    protected $articles_rep;

    protected $template;

    protected $user;

    protected $content = false;

    protected $title;

    protected $vars;


    public function __construct( ) {



    }


    protected function renderOutput() {

        $this->vars['title'] = $this->title;
        $menu = $this->getMenu();

        $sideBar = view(config('settings.theme').'.admin.sideBar')->with('menu', $menu)->render();
        $this->vars['sideBar'] = $sideBar;

        $header = view(config('settings.theme').'.admin.header')->render();
        $this->vars['header'] = $header;

        if($this->content) {
            $this->vars['content'] = $this->content;
        }

        $footer = view(config('settings.theme').'.admin.footer')->render();
        $this->vars['footer'] = $footer;

        return view($this->template)->with($this->vars);
    }


    protected function getMenu() {


        return Menu::make('AdminMenu', function($menu) {

            if(Gate::allows('VIEW_ADMIN')) {
                $menu->add('Dashboard', ['route' => 'dashboard'])->data(['icon'=> 'view-dashboard', 'path_name'=> 'dashboard', 'color'=>'cyan' ]);
            }
            if(Gate::allows('VIEW_ADMIN_ARTICLES')){
                $menu->add('Articles', ['route'=>'article.index'])->data(['icon'=> 'book-multiple', 'path_name'=> 'article', 'color'=>'success' ]);
            }
            if(Gate::allows('VIEW_ADMIN_PORTFOLIOS')){
                $menu->add('Portfolio', ['route'=>'portfolio.index'])->data(['icon'=> 'briefcase', 'path_name'=> 'portfolio', 'color'=>'warning']);
            }
            if(Gate::allows('VIEW_ADMIN_MENU')){
                $menu->add('Menu', ['route'=>'menu.index'])->data(['icon'=> 'menu', 'path_name'=> 'menu', 'color'=>'danger']);
            }
            if(Gate::allows('ADMIN_USERS')){
                $menu->add('Users', ['route'=>'users.index'])->data(['icon'=> 'account-multiple', 'path_name'=> 'users', 'color'=>'info']);
            }
            if(Gate::allows('EDIT_PERMISSIONS')){
                $menu->add('Permissions', ['route'=>'permissions.index'])->data(['icon'=> 'account-key', 'path_name'=> 'permissions', 'color'=>'danger']);
            }
            if(Gate::allows('VIEW_ADMIN_SLIDER')){
                $menu->add('Slider', ['route'=>'slider.index'])->data(['icon'=> 'image-area-close', 'path_name'=> 'slider', 'color'=>'info']);
            }
            if(Gate::allows('VIEW_ADMIN_CONTACTS')){
                $menu->add('Contacts', ['route'=>'contact.index'])->data(['icon'=> 'contacts', 'path_name'=> 'contact', 'color'=>'cyan']);
            }
            if(Gate::allows('ADD_CATEGORY')){
                $menu->add('Categories', ['route'=>'category.index'])->data(['icon'=> 'sitemap', 'path_name'=> 'category', 'color'=>'success']);
            }
            if(Gate::allows('ADD_FILTER')){
                $menu->add('Filters', ['route'=>'filter.index'])->data(['icon'=> 'filter-outline', 'path_name'=> 'filter', 'color'=>'warning']);
            }

        });


    }


    protected function hasPermission($permission) {

        if(Gate::denies($permission)) {
            abort(403);
        }

    }



}
