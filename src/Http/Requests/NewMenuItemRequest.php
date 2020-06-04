<?php

namespace QikkerOnline\NovaMenuBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use QikkerOnline\NovaMenuBuilder\NovaMenuBuilder;

class NewMenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return resolve(NovaMenuBuilder::class)->authorize(request()) ? true : false;
    }

    public function messages()
    {
        return [
            'class.required' => 'The type field is required.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            [
                'class' => 'required',
            ],
            $this->get('class') ? $this->get('class')::getRules() : []
        );
    }
}
