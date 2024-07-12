<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'is_active' => '',
        ];
    }
}
