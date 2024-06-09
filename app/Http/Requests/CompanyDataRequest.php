<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDataRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
        'document' => [
            'required',
            'string',
        ],
        'company_name' => 'required|string',
        'main_activity' => 'required|string',
        'corporate_name' => 'string',
        'name' => 'string',
        'type' => 'required|string',
    ];
  }
}
