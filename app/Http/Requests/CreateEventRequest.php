<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'category' => 'required|exists:categories,id',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}