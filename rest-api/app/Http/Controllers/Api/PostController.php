<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\EditPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Lister tous les posts.
     */
    public function index()
    {
        try {
            // méthode pour lister tous les posts
                $posts = Post::orderBy('id', 'desc')->get(); // récupération des posts par ordre décroissant à partir de l'id
                return response()->json([
                    'posts' => PostResource::collection($posts)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer un post.
     */
    public function store(CreatePostRequest $request)
    {
        // création d'un post
        try {
            $slug = Str::slug($request->title); // génération du slug
            $validetedData = $request->validated(); // validation des données
            $validetedData['slug'] = $slug; // ajout du slug dans les données validées
            $post = Post::create($validetedData); // création du post

            return response()->json([
                'post' => new PostResource($post),
                'message' => 'Post créé avec succès'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Visionner un post à partir de son id.
     */
    public function show(Post $post)
    {
        // récupération d'un post à partir de son id
        try {
            return response()->json([
                'post' => new PostResource($post)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération du post',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Metre à jour un post.
     */
    public function update(EditPostRequest $request, Post $post)
    {
        // Modification d'un post
        try {
            $validatedData = $request->validated(); // validation des données
            if($request->filled('title')) {
                $validatedData['slug'] = Str::slug($request->title); // génération du slug à partir du nouveau titre
            }
            $post->update($validatedData); // mise à jour du post

            $post->refresh(); // Rafraîchissement du modèle pour obtenir les données les plus récentes
            
            return response()->json([
                'message' => 'Le post a bien été modifié avec succès',
                'post' => new PostResource($post),
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la validation des données',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un post.
     */
    public function destroy(Post $post)
    {
        // Suppression d'un post
        try {
            $post->delete(); // suppression du post
            return response()->json([
                'message' => 'Le post a bien été supprimé'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
