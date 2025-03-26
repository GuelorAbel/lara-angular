<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string',
            'status' => 'required|boolean'
        ];
    }

    // personnaliser les messages d'erreur
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire',
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.min' => 'Le titre doit contenir au moins 3 caractères',
            'title.max' => 'Le titre doit contenir au plus 255 caractères',
            'content.required' => 'Le contenu est obligatoire',
            'content.string' => 'Le contenu doit être une chaîne de caractères',
            'status.required' => 'Le statut est obligatoire',
            'status.boolean' => 'Le statut doit être un booléen'
        ];
    }
}
