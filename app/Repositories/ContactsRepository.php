<?php

namespace Corp\Repositories;

use Corp\Contact;
use Gate;
use Image;
use Str;
use Config;
use File;

class ContactsRepository extends Repository{


    public function __construct(Contact $contact){

       $this->model = $contact;

    }


    public function addContact($request) {

        if(\Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token');


        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }


        $this->model->fill($data);

        if($this->model->save()) {
            return ['status'=>'Contact is added'];
        }


    }

    public function updateContact($request, $contact) {

        if(\Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', '_method');

        if(empty($data)) {
            return array('error' => 'Empty Data!');
        }


        $contact->fill($data);

        if($contact->update()) {
            return ['status'=>'Contact is updated'];
        }

    }

    public function deleteContact($contact) {

        if(\Gate::denies('destroy', $contact)) {
            abort(403);
        }


        if($contact->delete()) {

            return ['status'=>'Contact is deleted'];
        }


    }


}