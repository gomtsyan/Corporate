<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_FILTER');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:filters|max:255', function($input) {

            if($this->route()->hasParameter('filter')) {

                $model = $this->route()->parameter('filter');

                return ($model->alias !== $input->alias) && !empty($input->alias);

            }

            return !empty($input->alias);
        });

        return $validator;
    }
}
