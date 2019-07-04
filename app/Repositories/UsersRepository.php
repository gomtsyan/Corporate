<?php

namespace Corp\Repositories;

use Corp\User;
use Corp\Repositories\RolesRepository;
use Gate;

class UsersRepository extends Repository{

    protected $rol_rep;

    public function __construct(User $user, RolesRepository $rol_rep){

       $this->model = $user;
       $this->rol_rep = $rol_rep;

    }


    public function addUser($request) {

        if(Gate::denies('create', $this->model)) {
            abort(403);
        }

        $data = $request->all();

        $user = $this->model->create([
            'name'=>$data['name'],
            'login'=>$data['login'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);

        if($user){
            $user->roles()->attach($data['role_id']);
        }

        return ['status' => 'User added'];

    }


    public function updateUser($request, $user) {

        if(Gate::denies('update', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', '_method');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }

        if(isset($data['password'])) {

            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        if($user->roles()->sync([$data['role_id']])){
            unset($data['role_id']);

        }

        $user->fill($data);

        if($user->update()){
            return ['status' => 'User updated'];
        }


    }


    public function deleteUser($user) {

        if(Gate::denies('delete', $this->model)) {
            abort(403);
        }

        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => 'User deleted'];
        }


    }

}