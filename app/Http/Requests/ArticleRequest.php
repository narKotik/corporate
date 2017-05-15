<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

//php artisan make:request ArticleRequest
class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo('ADD_ARTICLES');
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
            'full_text' => 'required',
            'category_id' => 'required|integer',
            'image' => 'image',
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:articles|max:255', function($input){
            if ( $this->route()->hasParameter('article') ){
                $model = $this->route()->parameter('article');
                return $model->alias != $input->alias && !empty($input->alias);
            }

            return !empty($input->alias);
        });

        $validator->sometimes('image', 'required', function($input){
            if ( $this->route()->hasParameter('article') ){
                return false;
            }
            return true;
        });
        
        return $validator;
    }
}
