<?php

namespace Notabenedev\StaffTypes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffParamPostRequest extends FormRequest
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
        return [
            'value' => ["required", "string", "max:150"],
            'staff_param_name_id' => ["required", "integer"],
            'set_id' => ["nullable","integer"],
        ];
    }

    public function messages()
    {
        return [
            'staff_param_name_id.required' => "Имя не найдено",
            'staff_param_name_id.integer' => "Неверный формат имени",
            'set_id.integer' => "Неверный формат сета",
            'value.required' => "Значение не найдено",
            'value.string' => "Неверное значение",
        ];
    }
}
