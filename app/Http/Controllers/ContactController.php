<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use \Corp\Contact;

class ContactController extends SiteController {

    public function __construct(){
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu()));

        $this->bar = 'left';

        $this->template = config('settings.theme').'.contacts';

    }


    public function index(Request $request) {

        if($request->isMethod('post')){

            $messages = [
                'required' => 'field :attribute is required',
                'email' => 'field :attribute is not correct email'
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            $data = $request->all();

            $is_send = Mail::send(config('settings.theme').'.email', ['data'=>$data], function($message) use ($data) {

                $mail_admin = env('MAIL_ADMIN');

                $message->from($data['email'], $data['name']);
                $message->to($mail_admin);
                $message->subject('Question');

            });

            if($is_send){
                return redirect()->route('contacts')->with('status', 'Email sent');
            }

        }

        $contacts = Contact::get(['name', 'value', 'icon']);

        $content = view(config('settings.theme').'.contact_content')->render();
        $this->vars['content'] = $content;

        $this->bar = 'left';

        $this->contentLeftBar = view(config('settings.theme').'.contactBar')->with(['contacts'=> $contacts])->render();


        $this->title = 'Contacts';
        $this->meta_desc = 'Contacts Page';
        $this->keywords = 'Contacts Page';


        return $this->renderOutput();

    }

}
