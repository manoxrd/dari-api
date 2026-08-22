<?php

namespace App\Http\Requests;

use App\Enums\PropertyPurpose;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
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
      'thumbnail' => 'image|sometimes|file',
      'title' => 'string|sometimes|max:255|min:3',
      'description' => 'string|max:10000|nullable',
      'price' => 'sometimes|numeric',
      'area' => 'sometimes|numeric',
      'bedrooms' => 'sometimes|numeric',
      'bathrooms' => 'sometimes|numeric',
      'purpose' => ['string', 'sometimes', Rule::enum(PropertyPurpose::class)]
    ];
  }
}
