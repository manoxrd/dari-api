<?php

namespace App\Http\Requests;

use App\Enums\PropertyPurpose;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterPropertyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'per_page' => 'min:1|max:30|integer',
          'purpose' => ['nullable', Rule::enum(PropertyPurpose::class)],
          'bedrooms' => 'integer|min:1',
          'bathrooms' => 'integer|min:1',
          'min_price' => 'min:1|numeric',
          'max_price' => 'min:1|numeric'
        ];
    }
}
