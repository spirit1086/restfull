<?php

namespace App\Modules\Post\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRules(\request());
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ];
    }

    private function getRules(Request $request)
    {
        $is_method_patch = $request->isMethod('patch');
        if(!$is_method_patch)
        {
            return  [
                'title' => 'required',
                'description' => 'required',
            ];
        }
        // your own logic
        return [];
    }
}
