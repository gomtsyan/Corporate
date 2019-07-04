<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_CATEGORY');
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
            'alias' => 'required|max:255',
            'parent_id' => 'required|integer',
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:categories|max:255', function($input) {

            if($this->route()->hasParameter('category')) {

                $model = $this->route()->parameter('category');

                return ($model->alias !== $input->alias) && !empty($input->alias);

            }

            return !empty($input->alias);
        });

        return $validator;
    }
}
