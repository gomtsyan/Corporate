<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Contact;
use Corp\Http\Requests\ContactRequest;
use Corp\Repositories\ContactsRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;

class ContactsController extends AdminController
{

    protected $contacts_rep;

    public function __construct(ContactsRepository $contacts_rep) {

        parent::__construct();

        $this->contacts_rep = $contacts_rep;

        $this->template = config('settings.theme').'.admin.contacts';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->hasPermission('VIEW_ADMIN_CONTACTS');

        $this->title = 'Contacts Table';

        $contacts = $this->getContacts();

        $this->content = view(config('settings.theme').'.admin.contacts_content')->with('contacts', $contacts)->render();

        return $this->renderOutput();

    }

    protected function getContacts(){

        $contacts = $this->contacts_rep->get(['id', 'name', 'value', 'icon']);

        return $contacts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(\Gate::denies('save', new \Corp\Contact())) {
            abort(403);
        }

        $this->title = 'New Contact';

        $fa_icons = config('settings.fa_icons');

        $this->content = view(config('settings.theme').'.admin.contact_create_content')->with('fa_icons', $fa_icons)->render();

        return $this->renderOutput();


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request) {

        $result = $this->contacts_rep->addContact($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/contact')->with($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact) {

        if(\Gate::denies('edit', new Contact())){
            abort(403);
        }

        $this->title = 'Edit Contact - '.$contact->name;

        $fa_icons = config('settings.fa_icons');

        $this->content = view(config('settings.theme').'.admin.contact_create_content')->with(['fa_icons'=> $fa_icons, 'contact'=>$contact])->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact) {

        $result = $this->contacts_rep->updateContact($request, $contact);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/contact')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact) {

        $result = $this->contacts_rep->deleteContact($contact);

        if(is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result);
        }

        return redirect('/admin/contact')->with($result);
    }
}
