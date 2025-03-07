<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|max:60',
            'content' => 'required|string',
            'is_draft' => 'boolean',
            'published_at' => 'required|date',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
          return redirect()->back()
                ->withErrors($validator)
                ->withInput()->setStatusCode(422);
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 60 karakter.',
            'content.required' => 'Konten tidak boleh kosong.',
            'is_draft.boolean' => 'Nilai draft harus berupa true atau false.',
            'published_at.date' => 'Format tanggal tidak valid.',
        ];
    }
}
