<?php

namespace App\Http\Requests;

use App\Enums\PropertyPurpose;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
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
      'thumbnail' => 'image|required|file',
      'title' => 'string|required|max:255|min:3',
      'description' => 'string|max:10000|nullable',
      'price' => 'required|numeric',
      'area' => 'required|numeric',
      'bedrooms' => 'required|numeric',
      'bathrooms' => 'required|numeric',
      'purpose' => ['string', 'required', Rule::enum(PropertyPurpose::class)]
    ];
  }
}
