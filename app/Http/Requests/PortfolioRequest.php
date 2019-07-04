<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_PORTFOLIOS');
    }

    protected function getValidatorInstance() {

        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:portfolios|max:255', function($input) {

            if($this->route()->hasParameter('portfolio')) {

                $model = $this->route()->parameter('portfolio');

                return ($model->alias !== $input->alias) && !empty($input->alias);

            }

            return !empty($input->alias);
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
        return [
            'title' => 'required|max:255',
            'text' => 'required',
            'customer' => 'required|max:255',
            'filter_alias' => 'required',
        ];
    }
}
