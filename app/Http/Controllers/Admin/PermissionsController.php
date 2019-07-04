<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Repositories\PermissionsRepository;
use Corp\Repositories\RolesRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;

class PermissionsController extends AdminController
{

    protected $permissions_rep;

    protected $roles_rep;

    public function __construct(PermissionsRepository $permissions_rep, RolesRepository $roles_rep) {

        parent::__construct();

        $this->permissions_rep = $permissions_rep;

        $this->roles_rep = $roles_rep;

        $this->template = config('settings.theme').'.admin.permissions';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('EDIT_USERS');

        $this->title = 'Permissions & Roles';

        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $this->content = view(config('settings.theme').'.admin.permissions_content')->with(['roles'=> $roles, 'permissions'=> $permissions])->render();

        return $this->renderOutput();
    }

    public function getRoles() {
        $roles = $this->roles_rep->get();

        return $roles;
    }

    public function getPermissions() {
        $permissions = $this->permissions_rep->get();

        return $permissions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $result = $this->permissions_rep->changePermissions($request);

        return back()->with($result);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
