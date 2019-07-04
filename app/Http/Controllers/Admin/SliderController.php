<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\SliderRequest;
use Corp\Repositories\SlidersRepository;
use Corp\Slider;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class SliderController extends AdminController
{

    protected $slider_rep;

    public function __construct(SlidersRepository $slider_rep) {

        parent::__construct();

        $this->slider_rep = $slider_rep;

        $this->template = config('settings.theme').'.admin.sliders';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('VIEW_ADMIN_SLIDER');

        $this->title = 'Slider Table';

        $slider = $this->getSlider();

        $this->content = view(config('settings.theme').'.admin.slider_content')->with('slider', $slider)->render();

        return $this->renderOutput();

    }

    protected function getSlider(){

        $slider = $this->slider_rep->get(['id', 'img', 'desc', 'title']);

        return $slider;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(\Gate::denies('save', new \Corp\Slider())) {
            abort(403);
        }

        $this->title = 'New Slide';

        $this->content = view(config('settings.theme').'.admin.slider_create_content')->render();

        return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request) {

        $result = $this->slider_rep->addSlider($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/slider')->with($result);

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
    public function edit(Slider $slider) {

        if(\Gate::denies('edit', new Slider())){
            abort(403);
        }

        $this->title = 'Edit Slide';

        $this->content = view(config('settings.theme').'.admin.slider_create_content')->with(['slider'=> $slider])->render();

        return $this->renderOutput();


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, Slider $slider) {

        $result = $this->slider_rep->updateSlider($request, $slider);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/slider')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider) {

        $result = $this->slider_rep->deleteSlider($slider);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/slider')->with($result);

    }
}
