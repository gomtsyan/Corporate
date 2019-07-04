<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Http\Requests\ArticleRequest;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Gate;


class ArticlesController extends AdminController
{

    public function __construct(ArticlesRepository $articles_rep, CategoriesRepository $categories_rep) {

        parent::__construct();

        $this->articles_rep = $articles_rep;

        $this->categories_rep = $categories_rep;

        $this->template = config('settings.theme').'.admin.articles';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('VIEW_ADMIN_ARTICLES');

        $this->title = 'Articles Table';

        $articles = $this->getArticles();

        $this->content = view(config('settings.theme').'.admin.articles_content')->with('articles', $articles)->render();

        return $this->renderOutput();

    }

    protected function getArticles(){

        $articles = $this->articles_rep->get(['id', 'title', 'img', 'created_at', 'alias', 'desc', 'user_id', 'category_id']);

        return $articles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(\Gate::denies('save', new \Corp\Article())) {
            abort(403);
        }

        $this->title = 'New Article';

        $categories = $this->getCategories();

        $lists = array();
        if($categories){
            foreach($categories as $category) {

                if($category->parent_id == 0) {
                    $lists[$category->title] = array();
                }else{
                    $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
                }
            }
        }


        $this->content = view(config('settings.theme').'.admin.articles_create_content')->with('categories', $lists)->render();

        return $this->renderOutput();
    }

    protected function getCategories(){

        return $this->categories_rep->get(['title', 'alias', 'parent_id', 'id']);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->articles_rep->addArticle($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/article')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article) {

        if(\Gate::denies('edit', new Article)){
            abort(403);
        }

        $this->title = 'Edit Article - '.$article->title;

        $article->img = json_decode($article->img);

        $categories = $this->getCategories();

        $lists = array();

        foreach($categories as $category) {

            if($category->parent_id == 0) {
                $lists[$category->title] = array();
            }else{
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(config('settings.theme').'.admin.articles_create_content')->with(['categories'=> $lists, 'article'=>$article])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request,Article $article) {

        $result = $this->articles_rep->updateArticle($request, $article);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/article')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article) {

        $result = $this->articles_rep->deleteArticle($article);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/article')->with($result);

    }
}
