<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginFormRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // création de compte
    public function register(RegisterFormRequest $request)

    {
        try {
            $password = Hash::make($request->password); // hashing du mot de passe
            $validetedData = $request->validated();
            $validetedData['password'] = $password; // ajout du mot de passe hashé dans les données validées
            $user = User::create($validetedData); // Création de l'utilisateur

            return response()->json([
                'status' => 'success',
                'message' => 'Votre compte a bien été créé.',
                'user' => $user
            ], 201);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Une erreur c'est produite au moment de la création de votre compte, svp réessayez plus tard!"], 500);
        }
    }

    // connexion
    public function login(LoginFormRequest $request)
    {
        try {
                // vérification des identifiants
                if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Identifiants incorrects'], 401);
                }
                // s'il n'y pas d'erreur, on génère un token
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Vous êtes connecté(e) !',
                    'user' => $user,
                    'token' => $token
                ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la connexion'], 500);
        }

    }

    // déconnexion
    public function logout()
    {
        try {
            $user = Auth::user();
            if($user) {
                $user->currentAccessToken()->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Déconnexion réussie'
                ], 200);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec au moment de la déconnexion à votre compte'], 500);
        }
    }
}
