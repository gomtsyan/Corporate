<?php

Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact', route('contact'));
});

Breadcrumbs::register('article', function($breadcrumbs)
{
    //$breadcrumbs->parent('home');
    $breadcrumbs->push('Article', route('article'));
});