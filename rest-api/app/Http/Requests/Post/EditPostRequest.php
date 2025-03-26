<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
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
            // sometimes permet d'envoyer uniquement les champs à modifier
            'title' => 'sometimes|string|min:3|max:255',
            'content' => 'sometimes|string',
            'status' => 'sometimes|boolean'
        ];
    }

    // personnaliser les messages d'erreur
    public function messages(): array
    {
        return [
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.min' => 'Le titre doit contenir au moins 3 caractères',
            'title.max' => 'Le titre doit contenir au plus 255 caractères',
            'content.required' => 'Le contenu est obligatoire',
            'content.string' => 'Le contenu doit être une chaîne de caractères',
            'status.boolean' => 'Le statut doit être soit 0 soit 1'
        ];
    }
}
