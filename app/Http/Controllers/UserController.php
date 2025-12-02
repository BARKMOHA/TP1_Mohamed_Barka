<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Language;
use App\Http\Resources\LanguageResource;

use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Créer un utilisateur",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","language_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="language_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Utilisateur créé"),
     *     @OA\Response(response=422, description="Erreur de validation")
     * )
    */

    
    public function store(Request $request)
    {
        // Validation complète
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'language_id' => 'required|exists:languages,id',
        ]);

        // Création
        $user = User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'language_id' => $validated['language_id'],
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);   
    }
    
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Mettre à jour un utilisateur",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","language_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="language_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Utilisateur mis à jour"),
     *     @OA\Response(response=404, description="Utilisateur introuvable"),
     *     @OA\Response(response=422, description="Erreur de validation")
     * )
    */

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'])
                ->setStatusCode(404);
        }

        // Validation 
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $id,
            'password'    => 'required|string|min:6',
            'language_id' => 'required|exists:languages,id',
        ]);

        // Mise à jour
        $user->update([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'language_id' => $validated['language_id'],
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(200);   
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}/language",
     *     summary="Recevoir le langage préféré d’un utilisateur",
     *     tags={"Users"},
     *     description="Détermine le langage préféré d’un utilisateur basé sur les films qu'il a critiqués. En cas d’égalité, retourne celui qui apparaît en premier.",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Langage préféré détecté ou message si aucune critique",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string")
     *                 )
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur introuvable"
     *     )
     * )
    */


    public function language($id)
    {
        // Charger l'utilisateur avec toutes ses critiques + films liés
        $user = User::with('critics.film')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ])->setStatusCode(404);
        }

        // Si l'utilisateur n'a fait aucune critique
        if ($user->critics->isEmpty()) {
            return response()->json([
                'message' => 'User has no critics, no preferred language'
            ])->setStatusCode(200);
        }

        // Compter les langages utilisés dans ses critiques

        $langCounts = $user->critics    //https://laravel.com/docs/12.x/collections#method-pluck
            ->pluck('film.language_id')  // extraire tous les language_id 
            ->countBy();                 // compter les occurrences
            
            
        
        
            // Récupérer le langage ID le plus fréquent
        $preferredLanguageId = $langCounts->sortDesc()->keys()->first();

        // Charger la ressource du langage
        $language = \App\Models\Language::find($preferredLanguageId);

        return (new \App\Http\Resources\LanguageResource($language))
            ->response()
            ->setStatusCode(200);
    }
}
