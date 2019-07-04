<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;


class IndexController extends AdminController {


    public function __construct() {

        parent::__construct();

        $this->template = config('settings.theme').'.admin.index';

    }


    public function index() {

        $this->hasPermission('VIEW_ADMIN');

        $this->title = 'Admin Dashboard';

        $menus = $this->getMenu()->all();

        $content = view(config('settings.theme').'.admin.index_content')->with('menus', $menus)->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }



}
