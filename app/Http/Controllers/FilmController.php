<?php

namespace App\Http\Controllers;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Resources\FilmResource;
use App\Http\Resources\ActorResource;
use App\Http\Resources\CriticResource;

class FilmController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/films",
     *     summary="Liste paginée des films",
     *     tags={"Films"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste paginée des films",
     *     )
     * )
    */

    public function index()
    {
        $films = Film::paginate(20);
    
        return FilmResource::collection($films)
            ->response()
            ->setStatusCode(200);
    }
    
    public function show($id)
    {
       //
    }
    /**
     * @OA\Get(
     *     path="/api/films/{id}/actors",
     *     summary="Acteurs d’un film",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du film",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Liste des acteurs"),
     *     @OA\Response(response=404, description="Film introuvable")
     * )
    */

    public function actors($id)
    {
        $film = Film::with('actors')->find($id);
    
        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }
    
        return ActorResource::collection($film->actors)
            ->response()
            ->setStatusCode(200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/films/{id}/critics",
     *     summary="Critiques d’un film",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du film",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Liste des critiques"),
     *     @OA\Response(response=404, description="Film introuvable")
     * )
    */

    public function critics($id)
    {
        $film = Film::with('critics')->find($id);
    
        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }
    
        return CriticResource::collection($film->critics)
            ->response()
            ->setStatusCode(200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/films/{id}/average-score",
     *     summary="Recevoir la moyenne des critiques d’un film",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du film pour lequel on veut la moyenne",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moyenne des critiques",
     *         @OA\JsonContent(
     *             @OA\Property(property="film_id", type="integer"),
     *             @OA\Property(property="average_score", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film introuvable"
     *     )
     * )
    */
    public function averageScore($id)
    {
        $film = Film::with('critics')->find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'])
                ->setStatusCode(404);
        }

        if ($film->critics->isEmpty()) {
            return response()->json(['average_score' => null])
                ->setStatusCode(200);
        }

        $average = round($film->critics->avg('rating'), 2);

        return response()->json(['average_score' => $average])
            ->setStatusCode(200);
    }


    /**
     * @OA\Get(
     *     path="/api/films/search",
     *     summary="Rechercher des films",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=false,
     *         description="Mot-clé dans le titre",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="rating",
     *         in="query",
     *         required=false,
     *         description="Filtrer par rating exact",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="minLength",
     *         in="query",
     *         required=false,
     *         description="Durée minimum",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="maxLength",
     *         in="query",
     *         required=false,
     *         description="Durée maximum",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Résultats de la recherche")
     * )
    */


    public function search(Request $request)
    {
        $query = Film::query(); //https://laravel.com/docs/12.x/scout#searching

        // par titre
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        //  rating 
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        //  minLength
        if ($request->filled('minLength')) {
            $query->where('length', '>=', $request->minLength);
        }

        //  maxLength 
        if ($request->filled('maxLength')) {
            $query->where('length', '<=', $request->maxLength);
        }
        //paginer le resultat de search
        $films = $query->paginate(20);

        return FilmResource::collection($films)
            ->response()
            ->setStatusCode(200);
    }

        
}
