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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->get('class')::getRules();
    }
}
