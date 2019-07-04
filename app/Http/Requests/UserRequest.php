<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('EDIT_USERS');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('password', 'required|min:8|confirmed', function($input) {

            if(!empty($input->password) || (empty($input->password) && $this->route()->getName() != 'users.update') ) {

                return true;

            }

            return false;
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = ($this->route()->parameters()['user']->id) ? $this->route()->parameters()['user']->id : '';

        return [
            'name'=>'required|max:255',
            'login'=>'required|max:255',
            'role_id'=>'required|integer',
            'email'=>'required|email|max:255|unique:users,email,'.$id,

        ];
    }
}
