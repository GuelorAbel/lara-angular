<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
            // les règles de validation
            'name' => 'required|min:4|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|min:9',
        ];
    }
    // les messages d'erreurs
    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire',
            'name.min' => 'Le nom doit contenir au moins 4 caractères',
            'name.max' => 'Le nom doit contenir au plus 150 caractères',
            'email.required' => "L'email est obligatoire",
            'email.email' => "L'email doit être valide",
            'email.unique' => 'Cet email est déjà utilisé',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'phone.required' => 'Le numéro de téléphone est obligatoire',
            'phone.min' => 'Le numéro de téléphone doit contenir au moins 9 caractères',
        ];
    }
}
