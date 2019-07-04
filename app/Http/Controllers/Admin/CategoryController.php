<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Category;
use Corp\Http\Requests\CategoryRequest;
use Corp\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class CategoryController extends AdminController
{
    protected $categories_rep;

    public function __construct(CategoriesRepository $categories_rep) {

        parent::__construct();

        $this->categories_rep = $categories_rep;

        $this->template = config('settings.theme').'.admin.categories';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('EDIT_CATEGORY');

        $this->title = 'Category Table';

        $categories = $this->getCategories();

        $this->content = view(config('settings.theme').'.admin.category_content')->with('categories', $categories)->render();

        return $this->renderOutput();

    }

    protected function getCategories(){

        $categories = $this->categories_rep->get(['id', 'alias', 'parent_id', 'title']);

        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(\Gate::denies('save', new \Corp\Category())) {
            abort(403);
        }

        $this->title = 'New Category';

        $categories = $this->getCategories();

        $category_list = array();

        $category_list['0'] = 'Parent';

        foreach($categories as $category) {

            if($category->parent_id == 0){

                $category_list[$category->id] = $category->title;

            }

        }


        $this->content = view(config('settings.theme').'.admin.category_create_content')->with(['category_list'=>$category_list])->render();

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request) {

        $result = $this->categories_rep->addCategory($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/category')->with($result);

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
    public function edit(\Corp\Category $category) {

        if(\Gate::denies('edit', new \Corp\Category())){
            abort(403);
        }

        $this->title = 'Edit Category - '.$category->title;

        $categories = $this->getCategories();

        $category_list = array();

        $category_list['0'] = 'Parent';

        foreach($categories as $categoryItem) {

            if($categoryItem->parent_id == 0){

                $category_list[$categoryItem->id] = $categoryItem->title;

            }

        }


        $this->content = view(config('settings.theme').'.admin.category_create_content')->with(['category_list'=>$category_list, 'category'=>$category])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category) {

        $result = $this->categories_rep->updateCategory($request, $category);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/category')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {

        $result = $this->categories_rep->deleteCategory($category);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/category')->with($result);
    }
}
