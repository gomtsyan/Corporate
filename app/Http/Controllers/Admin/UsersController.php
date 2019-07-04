<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\UserRequest;
use Corp\Repositories\RolesRepository;
use Corp\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Gate;
use Corp\User;

class UsersController extends AdminController
{
    protected $users_rep;

    protected $roles_rep;

    public function __construct(UsersRepository $users_rep, RolesRepository $roles_rep) {

        parent::__construct();

        $this->users_rep = $users_rep;

        $this->roles_rep = $roles_rep;

        $this->template = config('settings.theme').'.admin.users';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('EDIT_USERS');

        $this->title = 'Users';

        $users = $this->getUsers();

        $this->content = view(config('settings.theme').'.admin.users_content')->with(['users'=> $users])->render();

        return $this->renderOutput();

    }

    public function getUsers() {

        return $this->users_rep->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create', new User())) {
            abort(403);
        }

        $this->title = 'New User';

        $roles = $this->getRoles()->reduce(function($returnRoles, $role) {

            $returnRoles[$role->id] = $role->name;

            return $returnRoles;

        }, []);


        $this->content = view(config('settings.theme').'.admin.users_create_content')->with('roles', $roles)->render();

        return $this->renderOutput();
    }

    public function getRoles() {

        return $this->roles_rep->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request) {

        $result = $this->users_rep->addUser($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);

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
    public function edit(User $user) {

        if(Gate::denies('create', new User())) {
            abort(403);
        }

        $this->title = 'Edit User - '.$user->name;

        $roles = $this->getRoles()->reduce(function($returnRoles, $role) {

            $returnRoles[$role->id] = $role->name;

            return $returnRoles;

        }, []);


        $this->content = view(config('settings.theme').'.admin.users_create_content')->with(['roles'=> $roles, 'user'=> $user])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user) {

        $result = $this->users_rep->updateUser($request, $user);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {

        $result = $this->users_rep->deleteUser($user);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);

    }
}
