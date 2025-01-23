<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterCompaniesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rule' => 'required|in:greater,smaller,between',
            'billions' => 'required_if:rule,greater,smaller|numeric',
            'range' => 'required_if:rule,between|array|size:2',
            'range.*' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'rule.required' => 'The rule field is required.',
            'rule.in' => 'The selected rule is invalid.',
            'billions.required_if' => 'The billions field is required when rule is greater or smaller.',
            'billions.numeric' => 'The billions field must be a number.',
            'range.required_if' => 'The range field is required when rule is between.',
            'range.array' => 'The range field must be an array.',
            'range.size' => 'The range field must contain exactly 2 items.',
            'range.*.numeric' => 'Each item in the range field must be a number.',
        ];
    }
}
