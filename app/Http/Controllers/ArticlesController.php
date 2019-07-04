<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\CommentsRepository;
use Illuminate\Http\Request;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\PortfoliosRepository;

class ArticlesController extends SiteController
{

    public function __construct(PortfoliosRepository $portfolio_rep, ArticlesRepository $articles_rep, CommentsRepository $comments_rep){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu()));

        $this->portfolio_rep = $portfolio_rep;
        $this->articles_rep = $articles_rep;
        $this->comments_rep = $comments_rep;
        $this->bar = 'right';
        $this->template = config('settings.theme').'.articles';

    }

    public function index($cat_alias = false) {


        $articles = $this->getArticles($cat_alias);
        $content = view(config('settings.theme').'.articles_content')->with('articles', $articles)->render();
        $this->vars['content'] = $content;

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('settings.theme').'.articlesBar')->with(['comments'=> $comments, 'portfolios'=> $portfolios])->render();

        $this->title = 'Blog';
        $this->meta_desc = 'Articles Page';
        $this->keywords = 'Articles Page';

        return $this->renderOutput();

    }

    protected function getPortfolios($take){

        $portfolios = $this->portfolio_rep->get('*', $take);

        return $portfolios;
    }

    protected function getComments($take){

        $comments = $this->comments_rep->get('*', $take);

        if($comments) {
            $comments->load('user', 'article');
        }

        return $comments;
    }

    protected function getArticles($alias = false){

        $where = false;

        if($alias) {
            $category_select = \Corp\Category::select('id')->where('alias', $alias)->first();
            if($category_select){
                $id = $category_select->id;
                $where = ['category_id', $id];
            }


        }

        $articles = $this->articles_rep->get(['id', 'title', 'img', 'created_at', 'alias', 'desc', 'user_id', 'category_id'], false, true, $where);

        if($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    public function show($alias = false) {

        $article = $this->articles_rep->one('*', $alias, ['comments' => true]);

        if($article) {
            $article->img = json_decode($article->img);
        }

        if($article){
            $this->title = $article->title;
            $this->keywords = $article->keywords;
            $this->meta_desc = $article->meta_desc;
        }


        $content = view(config('settings.theme').'.article_content')->with('article', $article)->render();
        $this->vars['content'] = $content;

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(config('settings.theme').'.articlesBar')->with(['comments'=> $comments, 'portfolios'=> $portfolios])->render();

        return $this->renderOutput();
    }

}
